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
            'guide_id' =>2,
            'teacher_id'=>1
        ]);
    }
}
