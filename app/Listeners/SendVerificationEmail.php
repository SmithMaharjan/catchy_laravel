<?php

namespace App\Listeners;

use App\Events\UserRegister;
use App\Jobs\SendVerificationEmailJob;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendVerificationEmail
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
    public function handle(UserRegister $event): void
    {
        dispatch(new SendVerificationEmailJob($event->user));
    }
}
