<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BetUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $BetUpdated;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($BetUpdated)
    {
        $this->BetUpdated = $BetUpdated;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    
    public function broadcastOn()
    {
        return new Channel('bettingboard');
    }

    public function broadcastWith()
    {
        return $this->BetUpdated;
    }
    public function broadcastAs()
    {
        return 'BetUpdated';
    }
}
