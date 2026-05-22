<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\State;
use App\Models\City;

class LocationController extends Controller
{
    public function create()
    {
        $countries = Country::all();
        return view('select-static', compact('countries'));
    }

    public function getStates($country_id)
    {
        return State::where('country_id', $country_id)->get();
    }

    public function getCities($state_id)
    {
        return City::where('state_id', $state_id)->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'country' => 'required',
            'state'   => 'required',
            'city'    => 'required'
        ]);

        return back()->with('success', 'Profile Saved Successfully!');
    }
}
