<?php

namespace App\Listeners;

use App\Events\CompetitorSubmitted;
use App\Notifications\Competitor\CompetitorSubmitted as Notification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendCompetitorSubmittedNotification implements ShouldQueue {
	/**
	 * Create the event listener.
	 *
	 * @return void
	 */
	public function __construct() {
		//
	}
	
	/**
	 * Handle the event.
	 *
	 * @param CompetitorSubmitted $event
	 * @return void
	 */
	public function handle(CompetitorSubmitted $event) {
		$event->competitor->user->notify(new Notification());
	}
}
