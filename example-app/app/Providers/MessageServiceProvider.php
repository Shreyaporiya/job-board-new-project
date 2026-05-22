<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\MessageService;

class MessageServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Binding MessageService in the service container
        $this->app->bind(MessageService::class, function ($app) {
            return new MessageService('Shreya');
        });
    }

    public function boot()
    {
        //
    }
}
