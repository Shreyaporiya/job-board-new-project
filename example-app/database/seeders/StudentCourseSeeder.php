<?php       

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\Course;

class StudentCourseSeeder extends Seeder
{
    public function run(): void
    {
        $s1 = Student::create(['name' => 'Shreya']);
        $s2 = Student::create(['name' => 'Priya']);

        $c1 = Course::create(['title' => 'Ui/UX']);
        $c2 = Course::create(['title' => 'Web Development']);

        // Attach courses to students
        $s1->courses()->attach([$c1->id, $c2->id]); // Shreya in both courses
        $s2->courses()->attach([$c2->id]);          // Priya only in Web Development
    }
}