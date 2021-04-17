<?php

namespace App\Listeners;

use App\Events\NotifyUser;
use App\Notifications\SendMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendEmail
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
     * @param  NotifyUser  $event
     * @return void
     */
    public function handle(NotifyUser $event)
    {
        // Send Email
        $event->user->notify(new SendMail($event->user, $event->title, $event->description));
    }
}
