<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notification;

class NotificationsSeeder extends Seeder
{
    public function run(): void
    {
        Notification::create([
            'title' => 'تنويه هام',
            'content' => 'سيتم تعطيل المدرسة يوم الخميس بسبب سوء الأحوال الجوية.',
            'user_id' => 1, // غيّر حسب اليوزر الموجود
        ]);

        Notification::create([
            'title' => 'تذكير بدفع الأقساط',
            'content' => 'يرجى من جميع الأهالي تسديد الأقساط المتأخرة قبل نهاية الشهر.',
            'user_id' => 1,
        ]);
    }
}
