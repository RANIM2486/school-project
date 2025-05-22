<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Reason;

class ReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         Reason::create([
            'name' => 'Excellent Attendance',
            'points' => 10
        ]);

        Reason::create([
            'name' => 'Helping Others',
            'points' => 5
        ]);

        Reason::create([
            'name' => 'Discipline',
            'points' => 7
        ]);

        Reason::create([
            'name' => 'Outstanding Behavior',
            'points' => 8
        ]);
    }
}
