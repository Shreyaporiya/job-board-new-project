<?php

namespace App\Jobs\Middleware;

use Illuminate\Support\Facades\Cache;

class PreventDuplicateJob
{
    protected $lockTime = 60; // seconds

    public function handle($job, $next)
    {
        // Use job name and user ID as unique key
        $key = 'job_lock:' . get_class($job) . ':' . $job->user->id;

        // If job is already running, skip execution
        if (Cache::has($key)) {
            return;
        }

        // Lock the job
        Cache::put($key, true, $this->lockTime);

        try {
            $next($job); // Execute job
        } finally {
            Cache::forget($key); // Release lock
        }
    }
}

