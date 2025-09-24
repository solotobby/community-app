<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmailVerification extends Mailable
{
    use Queueable, SerializesModels;

    public $firstName;
    public $verificationUrl;
    public $emailType = 'verification';

    public function __construct($firstName, $verificationUrl)
    {
        $this->firstName = $firstName;
        $this->verificationUrl = $verificationUrl;
    }

    public function build()
    {
        return $this->subject('Verify Your Email Address - Famlic')
                    ->view('emails.famlic')
                    ->with([
                        'emailType' => $this->emailType,
                        'firstName' => $this->firstName,
                        'code' => $this->verificationUrl,
                    ]);
    }
}
