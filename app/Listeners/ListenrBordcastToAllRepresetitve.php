<?php

namespace App\Listeners;

use App\Events\BordcastToAllRepresetitve;
use App\Traits\SendNotifcationWithFirebaseTrait;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ListenrBordcastToAllRepresetitve
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
     * @param  object  $event
     * @return void
     */
    public function handle(BordcastToAllRepresetitve $event)
    {
        // dd($event);
        $this->SendGloablNotifcation(
            $event->topic,
            $event->title,
            $event->content,
            $event->filename,
            $event->order_id
        );
    }
}
