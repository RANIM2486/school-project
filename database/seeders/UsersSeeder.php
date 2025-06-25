<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
    //     // مدير
    //     $users=[[
    //         'name' => 'مدير المدرسة',
    //         'email' => 'admin@school.com',
    //         'password' => Hash::make('password'),
    //         'role' => 'admin',
    //     ],
    //     [
    //         'name' => 'أحمد المعلم',
    //         'email' => 'teacher@school.com',
    //         'password' => Hash::make('password'),
    //         'role' => 'teacher',
    //     ],


    //        [ 'name' => 'ليلى المحاسبة',
    //         'email' => 'accountant@school.com',
    //         'password' => Hash::make('password'),
    //         'role' => 'accountant',
    //     ],
    //             [
    //         'name' => 'مروان الموجه',
    //         'email' => 'guide@school.com',
    //         'password' => Hash::make('password'),
    //         'role' => 'guide',
    //      ],

    //     [
    //         'name' => 'خالد ولي الأمر',
    //         'email' => 'parent@school.com',
    //         'password' => Hash::make('password'),
    //         'role' => 'parent',
    //     ],


    //   [
    //         'name' => 'زياد IT',
    //         'email' => 'it@school.com',
    //         'password' => Hash::make('password'),
    //         'role' => 'it',
    //     ]];

    //    foreach ($users as $userData) {
    //         $user = User::create($userData);
    //         // إذا بدك تولد توكن لكل مستخدم ممكن هنا:
    //         $token = $user->createToken('auth_token')->plainTextToken;
    //         echo "Created user {$user->email} with token: {$token}\n";
    //     }

      $faker = Faker::create();

        // توليد 10 مستخدمين عشوائيين
        $users = User::factory(20)->create();

        foreach ($users as $user) {
            // توليد توكنات إعادة تعيين كلمة السر للمستخدم
            DB::table('password_reset_tokens')->insert([
                'email' => $user->email,
                'token' => Str::random(60),
                'created_at' => now(),
            ]);

            // توليد جلسات للمستخدم
            DB::table('sessions')->insert([
                'id' => Str::random(32),
                'user_id' => $user->id,
                'ip_address' => $faker->ipv4(),
                'user_agent' => $faker->userAgent(),
                'payload' => json_encode(['data' => 'sample data']),
                'last_activity' => $faker->unixTime(),
            ]);
        }



    }
}
