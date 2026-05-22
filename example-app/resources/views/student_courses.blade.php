<!DOCTYPE html>
<html>
<head>
    <title>Student Courses</title>
</head>
<body>
    <h1>Courses for {{ $student->name }}</h1>
    <ul>
        @foreach($student->courses as $course)
            <li>
                {{ $course->title }} 
                (Pivot ID: {{ $course->pivot->id }}, Approved: {{ $course->pivot->id }})
            </li>
        @endforeach
    </ul>
</body>
</html>
