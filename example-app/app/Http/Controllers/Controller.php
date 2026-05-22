<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use app\Http\Models\Upload;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    

    public function handleUpload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf,docx|max:2048',
            'name' => 'required|string|max:255',
        ]);

        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();
        $customName = Str::slug($request->name) . '.' . $extension;

        $path = $file->storeAs('uploads', $customName, 'public');

        // Save to DB
        Upload::create([
            'name' => $request->name,
            'path' => $path
        ]);

        return back()->with('success', 'File uploaded successfully.');
    }

}
