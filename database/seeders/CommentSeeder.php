<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Comment;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
         Comment::create([
            'current_student_id' => 1,
       'user_id'=>1,
           'note' => 'ضعيف بالرياضيات',
            'date' => now(),
             'type' => 'إيجابية',
         ]);
    }
}
