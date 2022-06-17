<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user_id_from;
    public $user_id_to;
    public $business_id;
    public $office_id;
    public $message;
    public $read_at;
    public $created_at;
    public $updated_at;
    public $user_received;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user_id_from, $user_id_to, $business_id, $office_id, $read_at, $created_at, $updated_at, $message, $user_received)
    {
        $this->user_id_from = $user_id_from;
        $this->user_id_to = $user_id_to;
        $this->business_id = $business_id;
        $this->office_id = $office_id;
        $this->message = $message;
        $this->read_at = $read_at;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        $this->user_received = $user_received;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
//        return new PrivateChannel('channel-name');
        return ['new-message'];
    }

    public function broadcastAs() {

        return 'new-message';

    }
}
