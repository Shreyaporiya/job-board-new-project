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

        // 🔍 Search by name
        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%'.$request->search.'%');
            });
        }

        // 🎯 FILTERS
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        if ($request->filled('religion')) {
            $query->where('religion', $request->religion);
        }

        if ($request->filled('community')) {
            $query->where('community', $request->community);
        }

        if ($request->filled('profession')) {
            $query->where('profession', $request->profession);
        }

        if ($request->filled('country')) {
            $query->where('country', $request->country);
        }

        if ($request->filled('state')) {
            $query->where('state', $request->state);
        }

        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        if ($request->filled('marital_status')) {
            $query->where('marital_status', $request->marital_status);
        }

        // Age Filter
        if ($request->filled('age_from') && $request->filled('age_to')) {
            $query->whereBetween('age', [$request->age_from, $request->age_to]);
        }

        $profiles = $query->paginate(4);

        return view('user.dashboard', compact('profiles'));
    }
}
