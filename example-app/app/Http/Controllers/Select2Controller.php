<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Select2Controller extends Controller
{
    public function index()
    {
        // STATIC DATA
        $options = [
            'Reading',
            'Traveling',
            'Music',
            'Cooking',
            'Sports',
            'Photography'
        ];

        return view('select-static', compact('options'));
    }

    public function store(Request $request)
    {
        return back()->with('selected', $request->options ?? []);
    }
}
