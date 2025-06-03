<?php

namespace Database\Seeders;

// database/seeders/SchoolClassSeeder.php

use App\Models\classes;
use Illuminate\Database\Seeder;
use App\Models\SchoolClass;

class ClassesSeeder extends Seeder
{
    public function run(): void
    {
        classes::create([
            'level' => 'الصف الأول',
            'name' => 'الابتدائية',
            'students_count' => 30,
            'fees' => 100000,
        ]);
    }
}
