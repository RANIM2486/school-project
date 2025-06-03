<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        // مدير
        User::create([
            'name' => 'مدير المدرسة',
            'email' => 'admin@school.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // معلم
        User::create([
            'name' => 'أحمد المعلم',
            'email' => 'teacher@school.com',
            'password' => Hash::make('password'),
            'role' => 'teacher',
        ]);

        // موجه
        User::create([
            'name' => 'مروان الموجه',
            'email' => 'guide@school.com',
            'password' => Hash::make('password'),
            'role' => 'guid',
        ]);

        // محاسب
        User::create([
            'name' => 'ليلى المحاسبة',
            'email' => 'accountant@school.com',
            'password' => Hash::make('password'),
            'role' => 'accountant',
        ]);

        // ولي أمر
        User::create([
            'name' => 'خالد ولي الأمر',
            'email' => 'parent@school.com',
            'password' => Hash::make('password'),
            'role' => 'parent',
        ]);

        // مسؤول IT
        User::create([
            'name' => 'زياد IT',
            'email' => 'it@school.com',
            'password' => Hash::make('password'),
            'role' => 'it',
        ]);
    }
}
