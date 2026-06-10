<?php

namespace App\GraphQL\Mutations;

use Illuminate\Support\Facades\Auth;

class Login
{
    public function __invoke($_, array $args)
    {
        if (
            !Auth::attempt([
                'email' => $args['email'],
                'password' => $args['password'],
            ])
        ) {

            throw new \Exception('Invalid credentials');
        }

        $user = Auth::user();

        $token = $user->createToken('graphql-token')->plainTextToken;

        return [
            'token' => $token,
            'user' => $user,
        ];
    }
}