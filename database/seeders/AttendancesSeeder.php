<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attendance;

class AttendancesSeeder extends Seeder
{
    public function run(): void
    {
        Attendance::create([
            'student_id' => 1,  // ID للطالب الحالي (current_student_id)
            'guide_id' => 1,    // المعلم المسؤول
            'attendance_date' => now()->subDays(1),
            'status' => 'موجود',
        ]);

        Attendance::create([
            'student_id' => 1,
            'guide_id' => 1,
            'attendance_date' => now(),
            'status' => 'غير موجود',
        ]);
    }
}
