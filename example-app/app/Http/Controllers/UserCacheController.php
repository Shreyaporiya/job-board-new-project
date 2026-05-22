<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use App\Models\User;
use Illuminate\Http\Request;

class UserCacheController extends Controller
{
    // Fetch user with Redis caching
    public function getUser($id)
    {
        $key = "user:{$id}";

        // Store in Redis for 10 minutes if not cached
        $user = Cache::remember($key, 600, function () use ($id) {
            return User::find($id);
        });

        return response()->json($user);
    }

    // Update user and refresh cache
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());

        // Refresh cache
        Cache::put("user:{$id}", $user, 600);

        return response()->json([
            'message' => 'User updated & cache refreshed!',
            'user' => $user
        ]);
    }

    // Delete user from DB and remove cache
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        Cache::forget("user:{$id}");

        return response()->json(['message' => 'User deleted & cache cleared!']);
    }

    // Example of storing custom data in Redis
    public function customCache()
    {
        Cache::put('greeting', 'Hello from Redis!', 300);
        $message = Cache::get('greeting');

        return response()->json(['message' => $message]);
    }
}
