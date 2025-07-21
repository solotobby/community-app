<?php

namespace App\Livewire\Auth;

use App\Http\Controllers\PaystackController;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use App\Models\Level;
use Illuminate\Support\Facades\Hash;

#[Layout('components.layouts.auth')]
class Login extends Component
{
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;


    public function login()
    {
        $this->validate();
        $this->ensureIsNotRateLimited();


        $user = User::where('email', $this->email)->first();

        if (!$user || !Hash::check($this->password, $user->password)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        //  Prevent login if the user is blocked
        if (!$user->status) {
            throw ValidationException::withMessages([
                'email' => 'Your account has been blocked. Please contact support.',
            ]);
        }

        // If user is already subscribed or free
        if (
            $user->hasAnyRole('admin', 'super_admin')
            || $user->has_subscribed || $user->free_user
        ) {
            RateLimiter::clear($this->throttleKey());
            Session::regenerate();

            Auth::login(user: $user);
            $this->redirectIntended(route('home'), navigate: true);
            return;
        }


        $level = Level::find($user->level);
        $transaction = Transaction::create([
            'reference' => 'TXN_' . Str::upper(Str::random(15)),
            'user_id' => $user->id,
            'transaction_type' => 'subscription',
            'transaction_reason' => 'Registration Level Payment',
            'level_id' => $user->level,
            'amount' => $level?->registration_amount ?? 0,
            'status' => 'pending',
        ]);

        $paymentUrl = app(PaystackController::class)->initializeFunding(
            $user->email,
            $transaction->amount,
            $transaction->reference,
            route('paystack.payment.callback'),
            []
        );

        if ($paymentUrl) {
            $this->js(<<<JS
            window.location.href = "{$paymentUrl}";
        JS);
        } else {
            session()->flash('error', 'Payment initialization failed. Please try again.');
        }
    }


    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email) . '|' . request()->ip());
    }
}
