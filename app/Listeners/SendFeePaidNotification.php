<?php

namespace App\Listeners;

use App\Events\FeePaid;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Notification;

class SendFeePaidNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(FeePaid $event): void
    {
         // الحصول على الطالب المرتبط بالقسط
        $student = $event->fee->student;

        // الحصول على الأب (الذي لديه الـ parent_id)
        $parent = $student->parent;

        // إنشاء إشعار للأب عندما يتم دفع القسط
        Notification::create([
            'user_id' => $parent->id,  // الأب الذي سيستقبل الإشعار
            'title' => 'تم دفع القسط بنجاح',  // العنوان
            'content' => "تم دفع القسط بنجاح للطالب: {$student->name}.\nالمبلغ: {$event->fee->amount}.\nالتاريخ: {$event->fee->due_date}",
        ]);
    }
}
