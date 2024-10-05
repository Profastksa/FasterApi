<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BordcastToAllRepresetitve
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $topic , $content , $title , $order_id , $filename;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($topic , $title , $content , $filename  ,  $order_id = 1)
    {
        $this->topic = $topic;
        $this->title = $title;
        $this->content = $content;
        $this->order_id = $order_id;
        $this->filename = $filename;
        // dd($filname);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    // public function broadcastOn()
    // {
    //     return new PrivateChannel('channel-name');
    // }
}
