<?php

namespace App\Listeners;

use App\Events\NewUserCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewUserNotification;

class SendNewUserNotification implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  NewUserCreated  $event
     * @return void
     */
    public function handle(NewUserCreated $event)
    {
        $user = $event->getModel();

        // Construct email content
        $emailContent = "New User Registered:\n";
        $emailContent .= "Name: {$user->name}\n";
        $emailContent .= "Email: {$user->email}\n";
        // Add other user data as needed

        // Send email to admin
        Mail::to(['faster.saudi@gmail.com', 'ahmedict6@gmail.com'])->send(new NewUserNotification($emailContent));
    }
}
