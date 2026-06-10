<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function showCourses($id)
    {
        $student = Student::findOrFail($id);
        return response()->json($student->courses);
    }

    public function checkout(Request $request)
    {
        $priceId = $request->price_id;

        return $request->user()
            ->newSubscription('default', $priceId)
            ->checkout([
                'success_url' => route('subscription.success'),
                'cancel_url' => route('subscription.cancel'),
            ]);
    }
}

