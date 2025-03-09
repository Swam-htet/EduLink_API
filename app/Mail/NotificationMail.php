<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The email subject.
     *
     * @var string
     */
    public $emailSubject;

    /**
     * The HTML content.
     *
     * @var string
     */
    public $htmlContent;

    /**
     * Create a new message instance.
     *
     * @param string $subject
     * @param string $htmlContent
     * @return void
     */
    public function __construct(string $subject, string $htmlContent)
    {
        $this->emailSubject = $subject;
        $this->htmlContent = $htmlContent;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->emailSubject)
                    ->html($this->htmlContent);
    }
}
