<?php

namespace App\Listeners;

use App\Events\CompetitorSubmitted;
use App\Notifications\SportManager\CompetitorRegistered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Notification;

class SendCompetitorRegisteredNotification
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
     * @param  object  $event
     * @return void
     */
    public function handle(CompetitorSubmitted $event)
    {
        Notification::route('mail','Info@amsterdamsewaterspelen.nl')->notify(new CompetitorRegistered($event->competitor));
    }
}
