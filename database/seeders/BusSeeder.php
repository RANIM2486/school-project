<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bus;

class BusSeeder extends Seeder
{
    public function run(): void
    {
        Bus::create([
            'driver_name' => 'أبو محمد',
            'area' => 'المزة',
            'phone' => '0930000001'
        ]);

        Bus::create([
            'driver_name' => 'أبو أحمد',
            'area' => 'المالكي',
            'phone' => '0930000002'
        ]);
    }
}
