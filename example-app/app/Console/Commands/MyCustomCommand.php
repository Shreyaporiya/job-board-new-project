<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;

class MyCustomCommand extends Command
{
    // The name and signature of the console command
    protected $signature = 'my:customcommand {name} {--greeting=Hi}';


    // The console command description
    protected $description = 'This is my custom Artisan command';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $name = $this->argument('name');
        $greeting = $this->option('greeting');

        $this->info("$greeting, $name!");
        $this->newline();
        // Command logic goes here
        $this->info('Hello! This is my custom command.');

        $users = $this->withProgressBar(User::all(), function (User $user) {
            $this->info("Processing user: {$user->name}");
        });
        return 0;
    }

//     public function handle(): int
// {
//     $name = $this->argument('name');
//     $greeting = $this->option('greeting');

//     $this->info("$greeting, $name!");
//     $this->newline();

//     $this->info('Processing all users:');

//     $users = $this->withProgressBar(User::all(), function (User $user) {
//         // Perform task for each user
//         $this->line("Processing user: {$user->name}");
//     });

//     $this->info("\nTask completed!");

//     return 0;
// }
}
