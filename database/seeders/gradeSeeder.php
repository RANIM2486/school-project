<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Grade;

class GradeSeeder extends Seeder
{
    public function run(): void
    {
        Grade::create([
            'student_id' => 1,
            'subject_id' => 1,
            'guid_id'=>4,
            'exam1' => 9,
            'exam2' => 8,
            'exam3' => 10,
            'quiz' => 9,
            'final_exam' => 55,
            'date' => now(),
        ]);
    }
}
