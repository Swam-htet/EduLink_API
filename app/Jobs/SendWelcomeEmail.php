<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Contracts\Services\MailServiceInterface;
use Illuminate\Support\Facades\Log;

class SendWelcomeEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * The maximum number of seconds the job can run.
     *
     * @var int
     */
    public $timeout = 30;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private string $email,
        private string $name
    ) {}

    /**
     * Execute the job.
     */
    public function handle(MailServiceInterface $mailService): void
    {
        try {
            Log::info('Sending welcome email', ['email' => $this->email, 'name' => $this->name]);
            $mailService->sendWelcomeEmail($this->email, $this->name);
            Log::info('Welcome email sent successfully', ['email' => $this->email]);
        } catch (\Exception $e) {
            Log::error('Failed to send welcome email', [
                'email' => $this->email,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('Welcome email job failed', [
            'email' => $this->email,
            'error' => $exception->getMessage()
        ]);
    }
}
