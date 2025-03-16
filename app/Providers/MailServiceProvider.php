<?php

namespace App\Providers;

use App\Contracts\Services\Mail\MailServiceInterface;
use App\Services\Mail\MailService;
use Illuminate\Support\ServiceProvider;

class MailServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(MailServiceInterface::class, MailService::class);
    }
}
