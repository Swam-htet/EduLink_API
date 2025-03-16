<?php

namespace App\Services\Mail;

use App\Contracts\Services\Mail\MailServiceInterface;
use App\Mail\Student\RegistrationPendingMail;
use App\Mail\Student\ForgotPasswordOtpMail;
use App\Mail\Student\PasswordChangeOtpMail;
use App\Mail\Student\PasswordChangeSuccessMail;
use App\Mail\Student\RegistrationApprovedMail;
use App\Mail\Student\RegistrationRejectedMail;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Exception;


class MailService implements MailServiceInterface
{
    private function sendEmail(string $mailableClass, array $data, string $type): bool
    {
        try {
            if (!class_exists($mailableClass)) {
                throw new Exception(
                    "Email template class {$mailableClass} not found",
                    Response::HTTP_INTERNAL_SERVER_ERROR
                );
            }

            /** @var Mailable $mailable */
            $mailable = new $mailableClass($data);

            Mail::to($data['email'])->send($mailable);

            return true;
        } catch (\Exception $e) {

            Log::error("Failed to send {$type} email: " . $e->getMessage());

            throw $e;
        }
    }

    public function sendStudentRegistrationPendingEmail(array $data): bool
    {
        return $this->sendEmail(RegistrationPendingMail::class, $data, 'registration pending');
    }

    public function sendStudentForgotPasswordOtpEmail(array $data): bool
    {
        return $this->sendEmail(ForgotPasswordOtpMail::class, $data, 'forgot password OTP');
    }

    public function sendStudentPasswordChangeOtpEmail(array $data): bool
    {
        return $this->sendEmail(PasswordChangeOtpMail::class, $data, 'password change OTP');
    }

    public function sendStudentPasswordChangeSuccessEmail(array $data): bool
    {
        return $this->sendEmail(PasswordChangeSuccessMail::class, $data, 'password change success');
    }

    public function sendStudentRegistrationApprovedEmail(array $data): bool
    {
        return $this->sendEmail(RegistrationApprovedMail::class, $data, 'registration approved');
    }

    public function sendStudentRegistrationRejectedEmail(array $data): bool
    {
        return $this->sendEmail(RegistrationRejectedMail::class, $data, 'registration rejected');
    }
}
