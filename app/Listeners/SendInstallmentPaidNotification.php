<?php

namespace App\Listeners;

use App\Events\InstallmentPaid;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Notification;

class SendInstallmentPaidNotification
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
    public function handle(InstallmentPaid $event): void
    {
        $installment = $event->installment;
        $fee = $installment->fee;
        $student = $fee->student;
        $parent = $student->parent;

        Notification::create([
            'user_id' => $parent->id,
            'title' => 'دُفعت دفعة جديدة',
            'content' => "تم دفع دفعة جديدة من قسط {$fee->type} للطالب {$student->name} بمبلغ {$installment->amount} ل.س.",
        ]);
    }
}
