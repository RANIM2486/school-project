<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BusStudentSeeder extends Seeder
{
    public function run(): void
    {
        // الطالب 1 في الباص 1
        DB::table('bus_student')->insert([
            'student_id' => 1,
            'bus_id' => 1
        ]);

        // الطالب 2 في الباص 2
        DB::table('bus_student')->insert([
            'student_id' => 2,
            'bus_id' => 2
        ]);
    }
}
