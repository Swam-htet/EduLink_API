<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\Services\StaffAuthServiceInterface;
use App\Services\StaffAuthService;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // ... existing bindings ...

        $this->app->bind(StaffAuthServiceInterface::class, StaffAuthService::class);
    }
}
