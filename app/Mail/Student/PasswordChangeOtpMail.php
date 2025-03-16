<?php

namespace App\Mail\Student;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordChangeOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->subject('Password Change Confirmation - ' . config('app.name'))
                    ->view('emails.student.password-change-otp');
    }
}
