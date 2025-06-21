<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ابدأ بالمستخدمين إن وجد لديك
        // $this->call(UsersSeeder::class); // إذا أنشأت Seeder للمستخدمين

        $this->call([
            UsersSeeder::class,
            ClassesSeeder::class,
            SectionSeeder::class,
            SubjectSeeder::class,
            StudentSeeder::class,
            CurrentStudentSeeder::class,
            GradeSeeder::class,
            CommentSeeder::class,
            FeesSeeder::class,
    NotificationsSeeder::class,
    AdsSeeder::class,
    AttendancesSeeder::class,

         ]);
    }
}
