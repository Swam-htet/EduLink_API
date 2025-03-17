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
use App\Contracts\Services\StudentRegistrationServiceInterface;
use App\Services\Student\StudentRegistrationService;
use App\Contracts\Repositories\StudentRepositoryInterface;
use App\Repositories\StudentRepository;
use App\Contracts\Services\StudentAuthServiceInterface;
use App\Services\Student\StudentAuthService;
use App\Contracts\Services\StudentManagementServiceInterface;
use App\Services\Student\StudentManagementService;
use App\Contracts\Services\CourseManagementServiceInterface;
use App\Services\Course\CourseManagementService;
use App\Contracts\Repositories\CourseRepositoryInterface;
use App\Repositories\CourseRepository;
use App\Contracts\Services\CourseServiceInterface;
use App\Services\Course\CourseService;
use App\Contracts\Services\SubjectManagementServiceInterface;
use App\Services\Subject\SubjectManagementService;
use App\Contracts\Repositories\SubjectRepositoryInterface;
use App\Repositories\SubjectRepository;
use App\Contracts\Services\SubjectServiceInterface;
use App\Services\Subject\SubjectService;
use App\Contracts\Services\ClassManagementServiceInterface;
use App\Services\Class\ClassManagementService;
use App\Contracts\Repositories\ClassRepositoryInterface;
use App\Repositories\ClassRepository;
use App\Contracts\Services\ClassServiceInterface;
use App\Services\Class\ClassService;

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

        // student registration services
        $this->app->singleton(StudentRegistrationServiceInterface::class, StudentRegistrationService::class);

        // student repository
        $this->app->singleton(StudentRepositoryInterface::class, StudentRepository::class);

        // student auth services
        $this->app->singleton(StudentAuthServiceInterface::class, StudentAuthService::class);

        $this->app->singleton(StudentManagementServiceInterface::class,  StudentManagementService::class);

        $this->app->bind(CourseManagementServiceInterface::class, CourseManagementService::class);

        $this->app->bind(CourseRepositoryInterface::class, CourseRepository::class);

        $this->app->bind(CourseServiceInterface::class, CourseService::class);

        // Subject management bindings
        $this->app->singleton(SubjectManagementServiceInterface::class, SubjectManagementService::class);

        $this->app->singleton(SubjectRepositoryInterface::class, SubjectRepository::class);

        // Subject public API bindings
        $this->app->singleton(SubjectServiceInterface::class, SubjectService::class);

        // Class management bindings
        $this->app->singleton(ClassManagementServiceInterface::class, ClassManagementService::class);

        $this->app->singleton(ClassRepositoryInterface::class, ClassRepository::class);

        // Class public API bindings
        $this->app->singleton(ClassServiceInterface::class, ClassService::class);
    }



    public function boot(): void
    {
    }
}
