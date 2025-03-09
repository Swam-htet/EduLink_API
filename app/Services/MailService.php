<?php

namespace App\Services;

use App\Contracts\Services\MailServiceInterface;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Mail\NotificationMail;

class MailService implements MailServiceInterface
{
    public function sendWelcomeEmail(string $email, string $name): bool
    {
        try {
            Mail::to($email)->send(new WelcomeMail($name, $email));
            return true;
        } catch (Exception $e) {
            Log::error('Failed to send welcome email: ' . $e->getMessage());
            return false;
        }
    }

    public function sendPasswordResetEmail(string $email, string $token): bool
    {
        try {
            // Implement password reset email logic here
            return true;
        } catch (Exception $e) {
            Log::error('Failed to send password reset email: ' . $e->getMessage());
            return false;
        }
    }

    public function sendNotificationEmail(string $email, string $subject, string $message): bool
    {
        try {
            Mail::to($email)->send(new NotificationMail($subject, $message));
            return true;
        } catch (Exception $e) {
            Log::error('Failed to send notification email: ' . $e->getMessage());
            return false;
        }
    }
}
