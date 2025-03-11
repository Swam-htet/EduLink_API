<?php

namespace App\Providers;

use App\Services\TenantService;
use Illuminate\Support\ServiceProvider;
use App\Contracts\Services\TenantServiceInterface;
use App\Contracts\Services\TenantConfigServiceInterface;
use App\Services\TenantConfigService;
use App\Contracts\Services\MailServiceInterface;
use App\Services\MailService;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // multi-tenant services
        $this->app->singleton(TenantServiceInterface::class, TenantService::class);

        // common services
        $this->app->singleton(MailServiceInterface::class, MailService::class);

        // tenant services
        $this->app->singleton(TenantConfigServiceInterface::class, TenantConfigService::class);
    }


    public function boot(): void
    {
    }
}
