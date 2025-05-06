<?php

namespace App\Mail;

use App\Models\Tenants\ExamResult;
use App\Models\Tenants\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ExamResultMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     *
     * @param Student $student
     * @param ExamResult $examResult
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.student.exam-result')
            ->subject('Your Exam Result')
            ->with([
                'data' => $this->data,
            ]);
    }
}
