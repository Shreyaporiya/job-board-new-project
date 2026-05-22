<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRequest extends Model
{
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'status',
    ];

    // Relationship (sender)
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // Relationship (receiver)
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
