<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Subject;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        Subject::create([
            'name' => 'الرياضيات',
            'min_grade' => 40,
            'max_grade' => 100,
            'exam1' => 10,
            'exam2' => 10,
            'exam3' => 10,
            'final_exam' => 60,
            'teacher_id'=>1
        ]);
    }
}
