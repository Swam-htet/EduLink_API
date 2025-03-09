<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $emailSubject;

    public $htmlContent;

    public function __construct(string $subject, string $htmlContent)
    {
        $this->emailSubject = $subject;
        $this->htmlContent = $htmlContent;
    }

    public function build()
    {
        return $this->subject($this->emailSubject)
                    ->html($this->htmlContent);
    }
}
