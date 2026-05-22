<?php

namespace App\Http\Controllers;

use App\Contracts\LoggerInterface;

class LogController extends Controller
{
    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function store()
    {
        $this->logger->log("User visited the store page");

        return response()->json(['status' => 'Message logged successfully!']);
    }
}
