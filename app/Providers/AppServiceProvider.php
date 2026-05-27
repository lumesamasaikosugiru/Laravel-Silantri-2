<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Events\SantriPermissionStatusChanged;
use App\Listeners\SendPermissionWhatsappNotification;
use Illuminate\Support\Facades\Event;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Event::listen(
        //     SantriPermissionStatusChanged::class,
        //     SendPermissionWhatsappNotification::class,
        // );
    }
}
