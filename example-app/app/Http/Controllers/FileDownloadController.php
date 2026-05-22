<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileDownloadController extends Controller
{
    public function showForm()
    {
        return view('download-form');
    }

    public function downloadFile(Request $request)
    {
        $request->validate([
            'filename' => 'required|string'
        ]);

        $filename = $request->input('filename');
        $path = public_path('files/' . $filename);

        if (file_exists($path)) {
            $headers = ['Content-Type' => mime_content_type($path)];
            return response()->download($path, $filename, $headers);
        } else {
            return back()->with('error', 'File not found!');
        }
    }
}
