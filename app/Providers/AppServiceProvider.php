<?php

namespace App\Providers;

use App\Services\Common\TenantService;
use Illuminate\Support\ServiceProvider;
use App\Contracts\Services\TenantServiceInterface;
use App\Contracts\Services\TenantConfigServiceInterface;
use App\Services\TenantConfigService;
use App\Contracts\Services\StaffManagementServiceInterface;
use App\Services\StaffManagementService;
use App\Contracts\Repositories\StaffRepositoryInterface;
use App\Repositories\StaffRepository;
use App\Contracts\Repositories\TenantConfigRepositoryInterface;
use App\Repositories\TenantConfigRepository;
use App\Contracts\Services\StaffAuthServiceInterface;
use App\Services\StaffAuthService;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // multi-tenant services
        $this->app->singleton(TenantServiceInterface::class, TenantService::class);

        // tenant config services
        $this->app->singleton(TenantConfigServiceInterface::class, TenantConfigService::class);

        // tenant config repository
        $this->app->singleton(TenantConfigRepositoryInterface::class, TenantConfigRepository::class);

        // staff management services
        $this->app->singleton(StaffManagementServiceInterface::class, StaffManagementService::class);

        // staff repository
        $this->app->singleton(StaffRepositoryInterface::class, StaffRepository::class);

        // staff auth services
        $this->app->singleton(StaffAuthServiceInterface::class, StaffAuthService::class);
    }



    public function boot(): void
    {
    }
}
