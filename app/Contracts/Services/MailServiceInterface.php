<?php

namespace App\Contracts\Services;

interface MailServiceInterface
{
    /**
     * Send welcome email to user
     *
     * @param string $email
     * @param string $name
     * @return bool
     */
    public function sendWelcomeEmail(string $email, string $name): bool;

    /**
     * Send password reset email
     *
     * @param string $email
     * @param string $token
     * @return bool
     */
    public function sendPasswordResetEmail(string $email, string $token): bool;

    /**
     * Send notification email
     *
     * @param string $email
     * @param string $subject
     * @param string $message
     * @return bool
     */
    public function sendNotificationEmail(string $email, string $subject, string $message): bool;
}
