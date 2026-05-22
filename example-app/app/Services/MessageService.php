<?php

namespace App\Services;

class MessageService
{
    protected $name;

    public function __construct($name = 'Guest')
    {
        $this->name = $name;
    }

    public function getMessage()
    {
        return "Hello, {$this->name}! Welcome to Laravel.";
    }
}
