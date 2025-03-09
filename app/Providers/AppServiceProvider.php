<?php

namespace App\Providers;

use App\Services\TenantService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Register TenantService as a singleton
        $this->app->singleton(TenantService::class, function ($app) {
            return new TenantService();
        });
    }


    public function boot(): void
    {
    }
}
