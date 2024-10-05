<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendNotifcationWithFireBase
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $token , $title , $message , $order_id , $filename;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($token , $title , $message , $filename = '' ,  $order_id = 1 )
    {
        $this->token  =  $token;
        $this->title  =  $title;
        $this->message  =  $message;
        $this->order_id  = $order_id;
        $this->filename  = $filename;
        // dd($filename);
        // dd('ok');
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
