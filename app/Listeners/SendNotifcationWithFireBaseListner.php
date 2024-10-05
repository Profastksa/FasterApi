<?php

namespace App\Listeners;

use App\Events\SendNotifcationWithFireBase;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Traits\SendNotifcationWithFirebaseTrait;


class SendNotifcationWithFireBaseListner
{
    use SendNotifcationWithFirebaseTrait;
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
     * @param  SendNotifcationWithFireBase  $event
     * @return void
     */
    public function handle(SendNotifcationWithFireBase $event)
    {
        // dd($event);
        $this->sendFirebAseNotifcation(
            [$event->token],
            $event->title,
            $event->message,
            $event->filename,
            $event->order_id,
        );
    }
}
