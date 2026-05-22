<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\GenerateLibraryReport;

class ReportController extends Controller
{
    // Show the form
    public function index()
    {
        return view('report_form');
    }

    // Handle form submit
    public function generate(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
        ]);

        // Dispatch job to queue
        GenerateLibraryReport::dispatch($request->start_date, $request->end_date);

        return back()->with('success', 'Report generation started! You will be notified once it is ready.');
    }
}
