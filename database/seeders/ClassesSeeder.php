<?php

namespace Database\Seeders;

// database/seeders/SchoolClassSeeder.php

use App\Models\classes;
use Illuminate\Database\Seeder;

class ClassesSeeder extends Seeder
{
    public function run(): void
    {
       classes::factory()->count(20)->create();
    }
}
