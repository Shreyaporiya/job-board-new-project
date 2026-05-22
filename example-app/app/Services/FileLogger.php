<?php

namespace App\Services;

use App\Contracts\LoggerInterface;
use Illuminate\Support\Facades\File;

class FileLogger implements LoggerInterface
{
    public function log(string $message): void
    {
        File::append(storage_path('logs/custom.log'), $message . PHP_EOL);
    }
}
