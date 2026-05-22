<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\RedirectResponse;

class LanguageController extends Controller
{
    public function switch($locale): RedirectResponse
    {
        // Check if the locale exists in the language folder
        if (in_array($locale, ['en', 'fr', 'hi'])) {
            Session::put('locale', $locale); // Store in session
        }

        return redirect()->back(); // Redirect back to previous page
    }
}
