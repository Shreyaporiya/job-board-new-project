<?php

namespace App\GraphQL\Mutations;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthMutation
{
    public function login($_, array $args)
    {
        if (
            !Auth::attempt([
                'email' => $args['email'],
                'password' => $args['password']
            ])
        ) {
            throw new \Exception('Invalid credentials');
        }

        $user = Auth::user();

        return [
            'token' => $user->createToken('authToken')->plainTextToken,
            'user' => $user,
        ];
    }
}