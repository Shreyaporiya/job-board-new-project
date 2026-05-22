<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Benchmark;
use App\Models\User;
use App\Jobs\SendWelcomeEmail;

class UserController extends Controller
{
    public function index()
    {
        // Fetch users with pagination (5 per page)
        $users = DB::table('users')
                   ->select('*')
                   ->get();
                   /*->paginate(3);*/

        // $users = User::paginate(5);

        // $users = User::where('id', '>', 3)->paginate(4);

        // $users = User::where('id', '>', 3)->cursorPaginate(3);

        // // Pass data to the view
        // return view('users.index', compact('users'));

        // $users = Cache::remember('users', 300, function () {
        //     return User::all();
        // });


        // $users=Benchmark::dd(fn () => User::find(1),iterations: 10 ); // 0.1 ms

        // Benchmark::dd([
        //     'Scenario 1' => fn () => User::count(), // 0.5 ms
        //     'Scenario 2' => fn () => User::all()->count(), // 20.0 ms
        // ]);
        // Get all users except the logged-in user
        // $users = User::where('id', '!=', auth()->id())->get();

        // Pass $users to the view
        return view('users.index', compact('users'));
    }


    public function sendEmail()
    {
        $user = User::find(1); // Get any user
        SendWelcomeEmail::dispatch($user);

        return 'Email job dispatched!';
    }

    public function search(Request $request)
    {
        $query = User::query();

        // 🔍 Search by name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        // 🎚️ Filter by status (active/inactive)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // ↕️ Sort records (latest/oldest)
        if ($request->filled('sort')) {
            if ($request->sort === 'latest') {
                $query->orderBy('created_at', 'DESC');
            }
            if ($request->sort === 'oldest') {
                $query->orderBy('created_at', 'ASC');
            }
        }

        // 📄 Pagination
        $users = $query->paginate(10)->appends($request->query());

        return view('users.search', compact('users'));
    }

}
