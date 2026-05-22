<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
// use App\Http\Requests;
use App\Models\Profile;
use App\Models\User;


class UserSettingController extends Controller
{
    public function index()
    {
        return view('user.settings');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
        ]);

        Auth::user()->update($request->only('name', 'email'));

        return back()->with('success', 'Profile updated successfully.')->with('activeTab', 'profile');
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            // Get the first error message for password
            $errorMessage = $validator->errors()->first('password');

            return back()
                ->with('error', $errorMessage)  // pass the error message
                ->with('activeTab', 'security'); // optional: keep tab active
        }

        Auth::user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()
            ->with('success', 'Password updated successfully.')
            ->with('activeTab', 'security');
    }


    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required'],
        ]);

        $user = Auth::user();

        if (!Hash::check($request->password, $user->password)) {
            return back()
                ->withErrors(['password' => 'Incorrect password.'])
                ->with('openDeleteModal', true);
        }

        // 🔥 DELETE CHILD DATA FIRST
        if ($user->profile) {
            $user->profile->filters()->delete();
            $user->profile->delete();

        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')
            ->with('success', 'Account deleted successfully!');
    }


    public function checkPassword(Request $request)
    {
        $request->validate([
            'password' => 'required'
        ]);

        if (!Hash::check($request->password, Auth::user()->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Incorrect password'
            ], 422);
        }

        return response()->json([
            'status' => true
        ]);
    }


}
