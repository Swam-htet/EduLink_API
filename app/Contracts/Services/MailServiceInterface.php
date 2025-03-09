<?php

namespace App\Contracts\Services;

interface MailServiceInterface
{
    public function sendWelcomeEmail(string $email, string $name): bool;

    public function sendPasswordResetEmail(string $email, string $token): bool;

    public function sendNotificationEmail(string $email, string $subject, string $message): bool;
}
