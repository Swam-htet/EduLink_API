<?php

namespace App\Contracts\Services\Mail;

interface MailServiceInterface
{
    // student registration
    public function sendStudentRegistrationPendingEmail(array $data): bool;
    public function sendStudentForgotPasswordOtpEmail(array $data): bool;
    public function sendStudentPasswordChangeOtpEmail(array $data): bool;
    public function sendStudentPasswordChangeSuccessEmail(array $data): bool;
    public function sendStudentRegistrationApprovedEmail(array $data): bool;
    public function sendStudentRegistrationRejectedEmail(array $data): bool;


}
