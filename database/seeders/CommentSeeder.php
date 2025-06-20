<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Comment;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        Comment::create([
            'student_id' => 1,
            'name' => 'ضعيف بالرياضيات',
            'teacher_id' => 5,
            'date' => now(),
            'type' => 'إيجابية',
        ]);
    }
}
