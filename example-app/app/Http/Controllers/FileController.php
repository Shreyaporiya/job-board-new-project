<?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\File;

// class FileController extends Controller
// {
//     // Show dropdown with available files
//     public function index()
//     {
//         $directory = public_path('files');  // Folder: public/files
//         $files = [];

//         if (File::exists($directory)) {
//             $files = File::files($directory); // Get all files in folder
//         }

//         // Send file names to view
//         return view('files', ['files' => $files]);
//     }

//     // Download selected file
//     public function download(Request $request)
//     {
//         $request->validate([
//             'filename' => 'required|string'
//         ]);

//         $filename = $request->input('filename');
//         $path = public_path('files/' . $filename);

//         if (!file_exists($path)) {
//             return back()->with('error', 'File not found.');
//         }

//         return response()->download($path);
//     }
// }



namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    // Show upload form + list of files
    public function index()
    {
        // Get all files in storage/app/public/files
        $files = Storage::disk('public')->files('files');

        // Generate public URLs
        $fileUrls = array_map(fn($file) => [
            'name' => basename($file),
            'url' => asset('storage/' . $file),
        ], $files);

        return view('files', ['files' => $fileUrls]);
    }

    // Upload file
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240', // max 10MB
        ]);

        $path = $request->file('file')->store('files', 'public');

        return redirect('/files')->with('success', 'File uploaded successfully!');
    }

    // Delete file
    public function delete(Request $request)
    {
        $request->validate([
            'filename' => 'required|string',
        ]);

        $filePath = 'files/' . $request->input('filename');

        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
            return redirect('/files')->with('success', 'File deleted successfully!');
        } else {
            return redirect('/files')->with('error', 'File not found!');
        }
    }
}

