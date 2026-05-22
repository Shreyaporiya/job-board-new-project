<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\UserRequest;
class ProfileController extends Controller
{
    public function index()
    {
        $myProfile = Profile::where('user_id', Auth::id())->first();
        if ($myProfile) {
            // All public profiles except logged-in user
            $profiles = Profile::with(['user', 'images'])
                ->where('visibility', 'public')
                ->where('user_id', '!=', Auth::id())
                // ->where('gender', '!=', $myProfile->gender)
                ->where('is_active', 1)
                ->whereHas('user', function ($q) {
                    $q->where('status', '!=', 'banned');
                })
                ->get();

            $myFilter = null;
            $myFilter = DB::table('filters')
                ->select('age_from', 'age_to', 'gender', 'religion', 'community', 'marital_status', 'profession', 'country', 'state', 'city')
                ->get();

            $relations = [];
            if ($myProfile) {
                $relations = UserRequest::where(function ($q) use ($myProfile) {
                    $q->where('sender_id', $myProfile->id)
                        ->orWhere('receiver_id', $myProfile->id);
                })->get();
            }

            $profiles = $profiles->transform(function ($profile) use ($relations, $myProfile) {

                $profile->requestStatus = null;

                foreach ($relations as $relation) {

                    $isMatch =
                        ($relation->sender_id == $myProfile->id && $relation->receiver_id == $profile->id) ||
                        ($relation->sender_id == $profile->id && $relation->receiver_id == $myProfile->id);

                    if ($isMatch) {
                        if ($relation->is_accepted) {
                            $profile->requestStatus = 'friends';
                        } elseif ($relation->is_pending) {
                            $profile->requestStatus =
                                $relation->sender_id == $myProfile->id ? 'sent' : 'received';
                        } elseif ($relation->is_rejected) {
                            $profile->requestStatus = 'rejected';
                        } elseif ($relation->is_blocked) {
                            $profile->requestStatus = 'blocked';
                        }
                        break;
                    }
                }

                return $profile;
            });

            /* ✅ FILTER HERE */
            $profiles = $profiles
                ->filter(fn($profile) => $profile->requestStatus === null)
                ->values(); // reset index

            return view('profile.index', compact('profiles', 'myFilter'));
        }
        else
        {
            return view('profile.create');
        }
    }


    public function show($id)
    {
        $profile = Profile::with(['user', 'images'])
            ->where('id', $id)   // user_id from route
            ->firstOrFail();

        return view('profile.show', compact('profile'));
    }



    // Show profile creation form
    public function create()
    {
        return view('profile.create');
    }


    // Store profile data
    public function store(Request $request)
    {
        $request->validate([
            'age' => 'required|integer|min:18|max:100',
            'gender' => 'required|in:Male,Female',
            'religion' => 'required|string|max:50',
            'community' => 'required|string|max:50',
            'marital_status' => 'required|in:single,divorced,widow',
            'education' => 'required|string|max:500',
            'profession' => 'required|string|max:100',

            /* ---------- PREFERENCES ---------- */
            'preferences' => 'nullable|array',
            'preferences.age_min' => 'nullable|integer|min:18',
            'preferences.age_max' => 'nullable|integer|max:100',
            'preferences.religion' => 'nullable|string|max:50',
            'preferences.cast' => 'nullable|string|max:50',
            'preferences.marital_status' => 'nullable|array',
            'preferences.marital_status.*' => 'string',

            'preferences.profession' => 'nullable|array',
            'preferences.profession.*' => 'string',

            'preferences.personality' => 'nullable|array',
            'preferences.personality.*' => 'string',

            'preferences.location' => 'nullable|array',
            'preferences.location.*' => 'string',

            'country' => 'required|string|max:50',
            'state' => 'required|string|max:50',
            'city' => 'required|string|max:50',
            'visibility' => 'required|in:public,private',

            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        /*NORMALIZE & CLEAN PREFERENCES */
        $preferences = $request->preferences ?? [];

        // Convert comma-separated profession to array
        if (!empty($preferences['profession'][0])) {
            $preferences['profession'] = array_values(array_filter(
                array_map('trim', explode(',', $preferences['profession'][0]))
            ));
        }

        // Convert comma-separated personality traits to array
        if (!empty($preferences['personality'][0])) {
            $preferences['personality'] = array_values(array_filter(
                array_map('trim', explode(',', $preferences['personality'][0]))
            ));
        }
        // city, state, country
        // city, state, country
        // city, state, country


        if (!empty($preferences['location'][0])) {

            $preferences['location'] = array_values(array_filter(
                array_map('trim', explode(',', $preferences['location'][0]))
            ));

        }

        // Remove empty preference values
        $preferences = array_filter($preferences, function ($value) {
            return $value !== null && $value !== '' && $value !== [];
        });

        /*CREATE PROFILE*/
        $profile = Profile::create([
            'user_id' => Auth::id(),
            'age' => $request->age,
            'gender' => $request->gender,
            'religion' => $request->religion,
            'community' => $request->community,
            'marital_status' => $request->marital_status,
            'education' => $request->education,
            'profession' => $request->profession,
            'preferences' => $preferences,
            'country' => $request->country,
            'state' => $request->state,
            'city' => $request->city,
            'visibility' => $request->visibility,
        ]);

        /* PROFILE IMAGE UPLOAD */

        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $fileName = time() . '_' . $image->getClientOriginalName();
            $path = $image->storeAs('uploads/profiles', $fileName, 'public');

            $profile->images()->create([
                'user_id' => Auth::id(),
                'file_name' => $fileName,
                'file_path' => 'storage/' . $path,
                'Type_of_image' => 'profile',
            ]);
        }

        return redirect()->route('dashboard')
            ->with('success', 'Profile created successfully!');
    }


    public function edit(Request $request): View
    {
        $profile = Profile::where('user_id', Auth::id())->first();

        return view('profile.edit', [
            'user' => $request->user(),
            'profile' => $profile,
        ]);
    }

    public function update(ProfileUpdateRequest $request)
    {
        $user = $request->user();
        $profile = Profile::firstOrCreate(['user_id' => $user->id]);

        /* NORMAL PROFILE UPDATE */

        // Update user fields
        $user->fill($request->validated());
        $user->save();

        // Update profile fields (except image)
        $profile->fill($request->except('profile_image'));
        $profile->save();

        /* PROFILE IMAGE UPLOAD  */
        if ($request->hasFile('profile_image')) {

            $file = $request->file('profile_image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('uploads/profiles', $fileName, 'public');

            $oldImage = $profile->images()->first();

            if ($oldImage) {
                // delete old file
                if (Storage::disk('public')->exists(str_replace('storage/', '', $oldImage->file_path))) {
                    Storage::disk('public')->delete(str_replace('storage/', '', $oldImage->file_path));
                }

                $oldImage->update([
                    'file_name' => $fileName,
                    'file_path' => 'storage/' . $path,
                    'Type_of_image' => 'profile',
                ]);
            } else {
                $profile->images()->create([
                    'user_id' => $user->id,
                    'profile_id' => $profile->id,
                    'file_name' => $fileName,
                    'file_path' => 'storage/' . $path,
                    'Type_of_image' => 'profile',
                ]);
            }
        }

        return redirect()
            ->route('profile.edit')
            ->with('status', 'Profile updated successfully!');
    }


    public function changeActivation(Request $request): RedirectResponse
    {
        $profile = Profile::where('user_id', Auth::id())->first();


        if (!$profile) {
            return redirect()->route('dashboard')->with('error', 'Profile not found.');
        }

        $statusMessage = '';
        if ($request->activation_action === 'activate') {
            $profile->update(['is_active' => 1]);
            $statusMessage = 'Profile activated successfully!';
        } elseif ($request->activation_action === 'deactivate') {
            $profile->update(['is_active' => 0]);
            $statusMessage = 'Profile deactivated successfully!';
        } else {
            $statusMessage = 'Invalid action.';
        }

        return redirect()->route('profile.edit')->with('status', $statusMessage);
    }
    public function deleteForm(Request $request): View
    {
        return view('profile.partials.delete-user-form');
    }

    public function destroyProfile(Request $request)
    {
        // PASSWORD VALIDATION
        $request->validate([
            'password' => ['required'],
        ]);

        $user = Auth::user();

        // PASSWORD CHECK
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => 'Incorrect password.',
            ]);
        }

        // GET PROFILE
        $profile = Profile::where('user_id', $user->id)->first();

        if (!$profile) {
            return back()->with('error', 'Profile not found.');
        }

        // DELETE PROFILE IMAGES
        foreach ($profile->images as $image) {

            $filePath = public_path($image->file_path);

            if (is_file($filePath)) {
                unlink($filePath);
            }

            $image->delete();
        }

        // DELETE PROFILE
        $profile->delete();

        // LOGOUT USER
        Auth::logout();

        // INVALIDATE SESSION
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('/')
            ->with('success', 'Profile deleted successfully!');
    }



    public function search(Request $request)
    {
        $query = Profile::with('user', 'images');
        $query->where('is_active', 1)
            ->where('user_id', '!=', Auth::id())
            ->whereHas('user', function ($q) {
                $q->where('status', '!=', 'banned');
            });

        if ($request->name) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->name . '%');
            });
        }

        if ($request->age_from) {
            $query->where('age', '>=', $request->age_from);
        }

        if ($request->age_to) {
            $query->where('age', '<=', $request->age_to);
        }

        if ($request->gender) {
            $query->where('gender', $request->gender);
        }

        if ($request->marital_status) {
            $query->where('marital_status', $request->marital_status);
        }

        if ($request->religion) {
            $query->where('religion', $request->religion);
        }

        if ($request->community) {
            $query->where('community', $request->community);
        }

        if ($request->profession) {
            $query->where('profession', 'like', '%' . $request->profession . '%');
        }

        if ($request->country) {
            $query->where('country', 'like', '%' . $request->country . '%');
        }

        $profiles = $query->get();

        $data = $request->only(['name', 'age_from', 'age_to', 'profession', 'country', 'religion', 'community']);

        $myFilter = DB::table('filters')
            ->select('age_from', 'age_to', 'gender', 'religion', 'community', 'marital_status', 'profession', 'country', 'state', 'city')
            ->get();

        return view('profile.index', compact('profiles', 'data', 'myFilter'));
    }

    public function myProfile()
    {
        $profile = Profile::with('user', 'images')->where('user_id', Auth::id())->first();

        if (!$profile) {
            return redirect()->route('profile.create')->with('info', 'Please create your profile first.');
        }

        return view('profile.myprofile', compact('profile'));
    }
}



