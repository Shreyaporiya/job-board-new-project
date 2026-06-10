<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'payment_id',
        'customer_email',
        'amount',
        'currency',
        'payment_status',
    ];
}