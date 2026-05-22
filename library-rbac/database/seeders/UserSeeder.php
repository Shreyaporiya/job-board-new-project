<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{

    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('Admin@123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Librarian User',
            'email' => 'librarian@example.com',
            'password' => Hash::make('Librarian@123'),
            'role' => 'librarian',
        ]);

        User::create([
            'name' => 'Member User',
            'email' => 'member@example.com',
            'password' => Hash::make('Member@123'),
            'role' => 'member',
        ]);
    }

}
