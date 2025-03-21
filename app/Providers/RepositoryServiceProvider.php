<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\Services\StaffAuthServiceInterface;
use App\Services\StaffAuthService;
use App\Contracts\Repositories\ExamRepositoryInterface;
use App\Contracts\Repositories\ExamQuestionRepositoryInterface;
use App\Contracts\Repositories\StudentExamResponseRepositoryInterface;
use App\Contracts\Repositories\ExamResultRepositoryInterface;
use App\Repositories\ExamRepository;
use App\Repositories\ExamQuestionRepository;
use App\Repositories\StudentExamResponseRepository;
use App\Repositories\ExamResultRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        // ... existing bindings ...

        $this->app->bind(StaffAuthServiceInterface::class, StaffAuthService::class);
        $this->app->bind(ExamRepositoryInterface::class, ExamRepository::class);
        $this->app->bind(ExamQuestionRepositoryInterface::class, ExamQuestionRepository::class);
        $this->app->bind(StudentExamResponseRepositoryInterface::class, StudentExamResponseRepository::class);
        $this->app->bind(ExamResultRepositoryInterface::class, ExamResultRepository::class);
    }
}
