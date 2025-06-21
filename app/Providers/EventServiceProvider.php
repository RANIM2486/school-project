<?php

namespace App\Providers;

//use Illuminate\Support\ServiceProvider;
use App\Events\FeePaid;
use App\Listeners\SendFeePaidNotification;
use App\Events\InstallmentPaid;
use App\Listeners\SendInstallmentPaidNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        FeePaid::class => [
            SendFeePaidNotification::class,
        ],
            InstallmentPaid::class => [
        SendInstallmentPaidNotification::class,
    ],
    ];
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
         parent::boot();
    }
}
