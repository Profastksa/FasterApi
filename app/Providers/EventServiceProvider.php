<?php

namespace App\Providers;

use App\Events\SendNotifcationWithFireBase;
use App\Events\BordcastToAllRepresetitve;
use App\Listeners\SendNotifcationWithFireBaseListner;
use App\Listeners\ListenrBordcastToAllRepresetitve;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\IssueClientStatementCreated' => [
            'App\Listeners\SendIssueClientStatementEmail',
        ],
        'App\Events\OrderShipingCreated' => [
            'App\Listeners\SendOrderShipingToClientEmail',
        ],

        'App\Events\NewUserCreated' => [
            'App\Listeners\SendNewUserNotification',
        ],
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        SendNotifcationWithFireBase::class => [
            SendNotifcationWithFireBaseListner::class
        ],
        BordcastToAllRepresetitve::class => [
            ListenrBordcastToAllRepresetitve::class ,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
