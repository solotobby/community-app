<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class GiftCreatedEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $firstName;
    public $campaignTitle;
    public $shareUrl;
    public $expiryDate;
    public $emailType = 'gift_created';

    public function __construct($firstName, $campaignTitle, $shareUrl, $expiryDate)
    {
        $this->firstName = $firstName;
        $this->campaignTitle = $campaignTitle;
        $this->shareUrl = $shareUrl;
        $this->expiryDate = $expiryDate;
    }

    public function build()
    {
        return $this->subject('🎉 Your fundraising campaign is live!')
                    ->view('emails.famlic')
                    ->with([
                        'emailType' => $this->emailType,
                        'firstName' => $this->firstName,
                        'campaignTitle' => $this->campaignTitle,
                        'shareUrl' => $this->shareUrl,
                        'expiryDate' => $this->expiryDate,
                    ]);
    }
}

