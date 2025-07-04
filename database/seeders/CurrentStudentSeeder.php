<?php

namespace Database\Seeders;

use App\Models\Current_Student;
use Illuminate\Database\Seeder;

class CurrentStudentSeeder extends Seeder
{
    public function run(): void
    {
        Current_Student::create([
            'student_id' => 1,
            'class_id' => 1,
            'section_id' => 1,
            'status'=>'مستمر',
        ]);
          Current_Student::create([
            'student_id' => 2,
            'class_id' => 1,
            'section_id' => 1,
            'status'=>'مستمر',
        ]);
    }
}
