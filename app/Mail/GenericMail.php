<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GenericMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subjectText;
    public $messageBody;

    public function __construct($subjectText, $messageBody)
    {
        $this->subjectText = $subjectText;
        $this->messageBody = $messageBody;
    }

    public function build()
    {
        return $this->subject($this->subjectText)
                    ->view('emails.generic')
                    ->with([
                        'body' => $this->messageBody
                    ]);
    }
}
