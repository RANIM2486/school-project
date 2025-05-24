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
            ['text' => 'مساعدة زميل', 'value' => 5, 'type' => 'موجب'],
            ['text' => 'تأخر عن الحصة', 'value' => -3, 'type' => 'سالب'],
            ['text' => 'سلوك عدواني', 'value' => -10, 'type' => 'سالب'],
            ['text' => 'تنظيف الصف', 'value' => 4, 'type' => 'موجب'],
            ['text' => 'إزعاج داخل الصف', 'value' => -2, 'type' => 'سالب'],
                    ];

        foreach ($reasons as $reason) {
            Reason::create($reason);
        }
    }
}
