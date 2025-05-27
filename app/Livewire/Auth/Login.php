<?php

namespace App\Livewire\Auth;

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


#[Layout('components.layouts.auth')]
class Login extends Component
{
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->ensureIsNotRateLimited();

        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        $user = User::where('email', $this->email)->first();


        if ($user->hasRole('admin') || $user->has_subscribed) {

            RateLimiter::clear($this->throttleKey());
            Session::regenerate();

            $this->redirectIntended(default: route('home', absolute: false), navigate: true);
        } else {
            $level = Level::find($user->level);

            $transaction = Transaction::create([
                'reference' => 'TXN_' . Str::uuid(),
                'user_id' => $user->id,
                'transaction_type' => 'subscription',
                'transaction_reason' => 'Registration Level Payment',
                'level_id' => $user->level,
                'amount' => $level?->registration_amount ?? 0,
                'status' => 'pending',
            ]);


            $response = Http::withToken(config('services.paystack.secret_key'))->post(
                'https://api.paystack.co/transaction/initialize',
                [
                    'email' => $user->email,
                    'amount' => $transaction->amount * 100,
                    'reference' => $transaction->reference,
                    'callback_url' => route('paystack.payment.callback'),
                ]
            )->json();

            if (!$response['status']) {
                session()->flash('error', 'Payment initialization failed, try again.');
                return;
            }

            $this->js(<<<JS
        window.location.href = "{$response['data']['authorization_url']}";
        JS);
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
