<?php

namespace App\Jobs\Middleware;

use Illuminate\Support\Facades\Cache;

class PreventDuplicateJob
{
    protected $lockTime = 60; // seconds

    public function handle($job, $next)
    {
        $key = 'job_lock:' . get_class($job) . ':' . $job->user->id;

        if (Cache::has($key)) {
            return; // Job already running
        }

        Cache::put($key, true, $this->lockTime);

        try {
            $next($job);
        } finally {
            Cache::forget($key);
        }
    }
}
