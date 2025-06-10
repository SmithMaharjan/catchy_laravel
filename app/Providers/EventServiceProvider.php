<?php

namespace App\Providers;

use App\Events\UserRegister;
use App\Listeners\SendVerificationEmail;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        UserRegister::class => [
            SendVerificationEmail::class
        ]
    ];
    /**
     * Bootstrap services.
     */
    public function boot(): void {}
}
