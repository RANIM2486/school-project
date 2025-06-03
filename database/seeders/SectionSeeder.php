<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Section;

class SectionSeeder extends Seeder
{
    public function run(): void
    {
        Section::create([
            'name' => 'الشعبة أ',
            'class_id' => 1,
            'teacher_id'=>1
        ]);
    }
}
