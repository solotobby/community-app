<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.auth')]
class ForgotPassword extends Component
{
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        // For development - use default token 123456
        // if (app()->environment(['local', 'testing'])) {
        //     $resetUrl = route('password.reset', ['token' => '123456']) . '?email=' . urlencode($this->email);
        //     session()->flash('status', "Reset link (dev): {$resetUrl}");
        // } else {
            Password::sendResetLink($this->only('email'));
            session()->flash('status', __('A reset link will be sent if the account exists.'));
        // }
    }

    public function render()
    {
        return view('livewire.auth.forgot-password');
    }
}
