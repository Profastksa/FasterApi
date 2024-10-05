<?php

namespace App\Providers;

use App\Models\OrganizationProfile;
use Exception;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema as FacadesSchema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Schema;
use Illuminate\Support\Facades\Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Register any application services here
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        try {
            // Enable Debugbar
          //\Debugbar::enable();

            // Retrieve the first OrganizationProfile
            $Profile = OrganizationProfile::first();

            // Share the OrganizationProfile with all views
            View::share('OrganizationProfile', $Profile);
        } catch (Exception $e) {
            // Log any exceptions
            Log::error('Failed to initialize organization profile', ['exception' => $e]);
        }

        // Set default string length for Schema
        Schema::defaultStringLength(100);

        // Use Bootstrap for pagination
        Paginator::useBootstrap();
    }
}
