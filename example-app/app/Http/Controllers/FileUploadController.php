<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Upload;

class FileUploadController extends Controller
{
    // SHOW FORM
    public function showForm()
    {
        $upload = Upload::latest()->first(); // last uploaded
        return view('upload', compact('upload'));
    }

    // HANDLE UPLOAD
    public function handleUpload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf,ico,docx|max:2048',
            'name' => 'required'
        ]);

        $file = $request->file('file');
        $enteredName = $request->name;

        // Get real extension from uploaded file
        $realExt = $file->getClientOriginalExtension();

        // If user has not typed extension, add it
        if (!str_contains($enteredName, '.')) {
            $finalName = $enteredName . '.' . $realExt;
        } else {
            $finalName = $enteredName;
        }

        // Store File
        $path = $file->storeAs('uploads', $finalName, 'public');

        // Save in DB
        Upload::create([
            'name' => $finalName,
            'path' => $path
        ]);

        return back()
            ->with('success', 'File uploaded successfully')
            ->with('path', $path);
    }
}
