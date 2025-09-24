<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $firstName;
    public $emailType = 'welcome';
    public $giftLink = route('user.gift.create-gift');
    public $home = route('homepage');

    public function __construct($firstName)
    {
        $this->firstName = $firstName;
    }

    public function build()
    {
        return $this->subject('🎉 Welcome to Famlic – Let\'s raise your first fund together!')
                    ->view('emails.famlic')
                    ->with([
                        'emailType' => $this->emailType,
                        'firstName' => $this->firstName,
                        'giftLink'  => $this->giftLink,
                        'home'  => $this->home
                    ]);
    }
}
