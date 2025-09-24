<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PasswordResetEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $resetUrl;
    public $emailType = 'password_reset';

    public function __construct($resetUrl)
    {
        $this->resetUrl = $resetUrl;
    }

    public function build()
    {
        return $this->subject('Reset Password - Famlic')
                    ->view('emails.famlic')
                    ->with([
                        'emailType' => $this->emailType,
                        'resetUrl' => $this->resetUrl,
                    ]);
    }
}
