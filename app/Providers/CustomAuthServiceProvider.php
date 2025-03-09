<?php

namespace App\Providers;

use App\Contracts\Repositories\StudentRepositoryInterface;
use App\Contracts\Services\MailServiceInterface;
use App\Contracts\Services\StaffAuthServiceInterface;
use App\Contracts\Services\StudentAuthServiceInterface;
use App\Contracts\Services\StudentManagementServiceInterface;
use App\Contracts\Services\StudentRegistrationServiceInterface;
use App\Repositories\StudentRepository;
use App\Services\MailService;
use App\Services\StaffAuthService;
use App\Services\StudentAuthService;
use App\Services\StudentManagementService;
use App\Services\StudentRegistrationService;
use Illuminate\Support\ServiceProvider;

class CustomAuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Register repositories
        $this->app->singleton(StudentRepositoryInterface::class, function ($app) {
            return new StudentRepository();
        });

        // Register mail service
        $this->app->singleton(MailServiceInterface::class, function ($app) {
            return new MailService();
        });

        // Register StudentRegistrationService
        $this->app->singleton(StudentRegistrationServiceInterface::class, function ($app) {
            return new StudentRegistrationService(
                $app->make(MailServiceInterface::class),
                $app->make(StudentRepositoryInterface::class)
            );
        });

        // Register StudentAuthService
        $this->app->singleton(StudentAuthServiceInterface::class, function ($app) {
            return new StudentAuthService(
                $app->make(StudentRepositoryInterface::class)
            );
        });

        // Register StudentManagementService
        $this->app->singleton(StudentManagementServiceInterface::class, function ($app) {
            return new StudentManagementService(
                $app->make(StudentRepositoryInterface::class)
            );
        });

        // Register StaffAuthService
        $this->app->singleton(StaffAuthServiceInterface::class, function ($app) {
            return new StaffAuthService();
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
