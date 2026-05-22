<?php

namespace App\Http\Controllers;

use App\Models\Student;

class StudentController extends Controller
{
    public function showCourses($id)
    {
        $student = Student::findOrFail($id);
        return response()->json($student->courses);
    }
}

