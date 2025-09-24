<?php

namespace App\Livewire\Auth;

use App\Mail\PasswordResetEmail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
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
            'email' => ['required', 'string', 'email', 'exists:users,email'],
        ]);

        // Generate token properly
        $user = User::where('email', $this->email)->first();
        $token = Password::createToken($user);
        $resetUrl = route('password.reset', [
            'token' => $token,
            'email' => $this->email
        ]);
        // Send only your custom email
        Mail::to($this->email)->send(new PasswordResetEmail($resetUrl));

        session()->flash('status', 'Password reset link sent!');
    }

    public function render()
    {
        return view('livewire.auth.forgot-password');
    }
}
