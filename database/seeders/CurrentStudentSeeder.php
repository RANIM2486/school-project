<?php

namespace Database\Seeders;

use App\Models\Current_Student;
use Illuminate\Database\Seeder;
use App\Models\CurrentStudent;

class CurrentStudentSeeder extends Seeder
{
    public function run(): void
    {
        CurrentStudent::create([
            'student_id' => 1,
            'class_id' => 1,
            'section_id' => 1,
            'status'=>'مستمر',
        ]);
    }
}
