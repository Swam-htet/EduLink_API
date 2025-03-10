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
use App\Services\TokenService;
use App\Contracts\Services\TokenServiceInterface;

class CustomAuthServiceProvider extends ServiceProvider
{
    public function register(): void
    {

    }

    public function boot(): void
    {

    }
}
