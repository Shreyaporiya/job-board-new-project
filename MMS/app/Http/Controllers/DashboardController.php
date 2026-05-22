<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Profile::with(['user', 'images'])
            ->where('visibility', 'public')
            ->whereHas('user', function ($q) {
                $q->where('status', '!=', 'banned');
            })
            ->where('is_active', 1)
            ->where('user_id', '!=', auth()->id());

        $profiles = $query->paginate(4);

        return view('user.dashboard', compact('profiles'));
    }
}
