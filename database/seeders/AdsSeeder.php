<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ad;

class AdsSeeder extends Seeder
{
    public function run(): void
    {
        Ad::create([
            'user_id' => 1, // غيّر حسب اليوزر الموجود
            'title' => 'دورة تقوية في الرياضيات',
            'content' => 'ستبدأ دورة تقوية مجانية في الرياضيات لطلاب الصف السابع يوم الأحد القادم.',
        ]);

        Ad::create([
            'user_id' => 1,
            'title' => 'مسابقة ثقافية',
            'content' => 'يُعلن عن مسابقة ثقافية على مستوى المدرسة الأسبوع المقبل.',
        ]);
    }
}
