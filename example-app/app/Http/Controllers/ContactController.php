<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function showForm()
    {
        return view('contact');
    }

    public function handleForm(Request $request)
    {
        $headerValue = $request->header('X-Header-Name') ?? 'No header found';
        $bearerToken = $request->bearerToken();
        $ipAddresses = implode(', ', $request->ips()); // Convert array to string

        $validated = $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email',
            'message' => 'required|min:10'
        ]);

        return back()->with([
            'success' => 'Form submitted successfully!',
            'headerValue' => $headerValue,
            'bearerToken' => $bearerToken,
            'ipAddresses' => $ipAddresses,
            'host' => $request->host(),
            'httpHost' => $request->httpHost(),
            'schemeAndHttpHost' => $request->schemeAndHttpHost(),
        ])->withInput();
    }
}
