<?php

namespace App\Listeners;

use App\Events\SendEmailVerification;
use App\Mail\VerifyEmail;
use Illuminate\Support\Facades\Mail;

class SendEmailVerificationNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\SendEmailVerification  $event
     * @return void
     */
    public function handle(SendEmailVerification $event)
    {
        Mail::to($event->info['email'])->send(new VerifyEmail($event->info['pin']));
    }
}
