<?php

namespace App\Providers;

use App\Contracts\Services\MailServiceInterface;
use App\Services\MailService;
use Illuminate\Support\ServiceProvider;

class MailServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(MailServiceInterface::class, MailService::class);
    }

    public function boot(): void
    {
        //
    }
}
