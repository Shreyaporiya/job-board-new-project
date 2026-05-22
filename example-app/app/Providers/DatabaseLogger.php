<?php

namespace App\Providers;

use App\Contracts\LoggerInterface;
use Illuminate\Support\ServiceProvider;

class DatabaseLogger extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        DB::table('logs')->insert([
            'message' => $message,
            'created_at' => now(),
        ]);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
