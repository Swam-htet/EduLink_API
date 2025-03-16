<?php

namespace App\Mail\Student;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationPendingMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->subject('Registration Pending Approval - ' . config('app.name'))
                    ->view('emails.student.registration-pending');
    }
}
