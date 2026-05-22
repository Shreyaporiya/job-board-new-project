<?php
// app/Models/Skill.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Skill extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'color'
    ];

    /**
     * The users that have this skill
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
                    ->withPivot('proficiency_level')
                    ->withTimestamps();
    }
}