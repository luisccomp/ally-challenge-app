<?php

namespace App\Providers;

use App\Service\AllyIntegration;
use App\Service\BCIntegration;
use App\Service\Impl\AllyIntegrationImpl;
use App\Service\Impl\BCIntegrationImpl;
use App\Service\Impl\MockBCIntegrationImpl;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(BCIntegration::class, MockBCIntegrationImpl::class);
        $this->app->bind(AllyIntegration::class, AllyIntegrationImpl::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
