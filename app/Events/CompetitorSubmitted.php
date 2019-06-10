<?php

namespace App\Events;

use App\Models\Competitor;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CompetitorSubmitted {
	use Dispatchable, InteractsWithSockets, SerializesModels;
	/**
	 * @var Competitor
	 */
	public $competitor;
	
	/**
	 * Create a new event instance.
	 *
	 * @param Competitor $competitor
	 */
	public function __construct(Competitor $competitor) {
		//
		$this->competitor = $competitor;
	}
	
	/**
	 * Get the channels the event should broadcast on.
	 *
	 * @return \Illuminate\Broadcasting\Channel|array
	 */
	public function broadcastOn() {
		return new PrivateChannel('channel-name');
	}
}
