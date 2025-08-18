<?php

namespace App\Providers;
use App\ApiResponse\ResponseBuilder;
use Illuminate\Support\ServiceProvider;

class RestApiServicesProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind("ApiResponseFacades", function () {
            return new responseBuilder();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
