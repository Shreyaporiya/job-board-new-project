<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable= ['name'];
    
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_student', 'student_id', 'course_id')
                    ->withPivot('id'); 
                    //->wherePivot('approved', 1);  // only approved courses
    }

}


