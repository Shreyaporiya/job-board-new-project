<?php

namespace App\Http\Controllers;

use App\Services\MessageService;

class MessageController extends Controller
{
    protected $message;

    public function __construct(MessageService $message)
    {
        $this->message = $message;
    }

    public function show()
    {
        return response()->json([
            'message' => $this->message->getMessage()
        ]);
    }
}
