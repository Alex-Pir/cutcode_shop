<?php

namespace App\Listeners;

use App\Notifications\NewUserNotification;
use Illuminate\Auth\Events\Registered;

class SendEmailNewUserListener
{
    public function handle(Registered $event): void
    {
        $event->user->notify(new NewUserNotification());
    }
}
