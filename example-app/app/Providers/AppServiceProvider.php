<?php

namespace App\Providers;

use App\Contracts\LoggerInterface;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Carbon\Carbon;
use App\Services\FileLogger; 
use Illuminate\Notifications\ChannelManager;
use App\Notifications\Channels\SmsChannel;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(LoggerInterface::class, FileLogger::class);
    }

    /**
     * Bootstrap any application services.
     */

    public function boot()
    {
        $this->app->make(ChannelManager::class)->extend('sms', function($app) {
            return new SmsChannel();
        });
        Paginator::useBootstrapFive(); // For Bootstrap 5
        Carbon::serializeUsing(function ($carbon) {
            return $carbon->format('Y-m-d H:i:s');
        });
    }
}
