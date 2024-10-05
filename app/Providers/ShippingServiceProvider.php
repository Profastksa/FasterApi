<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Shiping\NewSMSAShippingServiceImplementation; // Ensure this import is correct

class ShippingServiceProvider extends ServiceProvider
{
     public function register()
    {
        // Bind newSMSAShipingServiceImplemenation as a singleton
        $this->app->singleton(NewSMSAShippingServiceImplementation::class, function ($app) {
            return new NewSMSAShippingServiceImplementation();
        });
    }

    public function boot()
    {
        //
    }
}
