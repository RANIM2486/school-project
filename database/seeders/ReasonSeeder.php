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

        $reasons = [
            ['name' => 'مساعدة زميل', 'value' => 5, 'type' => 'موجب'],
            ['name' => 'تأخر عن الحصة', 'value' => -3, 'type' => 'سالب'],
            ['name' => 'سلوك عدواني', 'value' => -10, 'type' => 'سالب'],
            ['name' => 'تنظيف الصف', 'value' => 4, 'type' => 'موجب'],
            ['name' => 'إزعاج داخل الصف', 'value' => -2, 'type' => 'سالب'],
                    ];

        foreach ($reasons as $reason) {
            Reason::create($reason);
        }
    }
}
