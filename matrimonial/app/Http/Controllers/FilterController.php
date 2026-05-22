<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Filter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FilterController extends Controller
{
    public function saveresult(Request $request)
    {
        // Find the logged-in user's profile
        $profile = Profile::where('user_id', Auth::id())->first();

        if (!$profile) {
            return back()->with('error', 'Profile not found for this user!');
        }

        if($request->gender == null){
            $gender = 'Any';
        }
        else{
            $gender = $request->gender;
        }

        $filter = Filter::create([
            'profile_id' => $profile->id,     // Correct profile id
            'age_from' => $request->age_from,
            'age_to' => $request->age_to,
            'gender' => $request->gender == "Any" ? null : $request->gender,
            'religion' => $request->religion,
            'community' => $request->community,
            'marital_status' => $request->marital_status,
            'profession' => $request->profession,
            'country' => $request->country,
            'state' => $request->state,
            'city' => $request->city,
        ]);

        return back()->with('success', 'Filter saved successfully!');
    }

}
