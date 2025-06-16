<?php


namespace App\Livewire\Auth;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Spatie\Permission\Models\Role;

#[Layout('components.layouts.auth')]
class Register extends Component
{
    public string $name = '';
    public string $email = '';
    public string $referral_code;
    public string $password = '';
    public string $password_confirmation = '';
    public string $level = '';

    /** @var \Illuminate\Database\Eloquent\Collection */
    public $levels;
    public $selectedLevelAmount = null;


    public function mount()
    {
        $this->levels = \App\Models\Level::all();
         $this->referral_code = request()->query('ref', '');
    }

    public function updatedLevel($value)
    {
        $level = $this->levels->where('id', $value)->first();
        $this->selectedLevelAmount = $level ? $level->registration_amount : null;
    }

    public function getSelectedLevelAmountProperty()
    {
        if (!$this->level) return null;

        $level = $this->levels->where('id', $this->level)->first();
        return $level ? $level->registration_amount : null;
    }

    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'level' => ['required', 'integer', 'exists:levels,id'],
            'referral_code' => ['nullable', 'string'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::where('email', $validated['email'])->first();

        $referralCode = $validated['referral_code'] ?? null;

        $referrerId = null;
        if ($referralCode) {
            $referrer = User::where('referral_code', $referralCode)->first();
            if ($referrer) {
                $referrerId = $referrer->id;
            }
        }

        if ($user) {
            if ($user->has_subscribed) {
                // Already subscribed, log them in and redirect
                Auth::login($user);
                $this->redirect(route('home'), navigate: true);
                return;
            }

            // Update details if not subscribed
            $user->update([
                'name' => $validated['name'],
                'password' => $validated['password'],
                'level' => $validated['level'],
            ]);
        } else {
            // New user
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $validated['password'],
                'level' => $validated['level'],
                'referrer_id' => $referrerId,
            ]);

            $role = Role::where('name', 'user')->first();
            $user->assignRole($role?->id);
            event(new Registered($user));
        }

        // Auth::login($user);

        // Create transaction
        $transaction = Transaction::create([
            'reference' => 'TXN_' . Str::upper(Str::random(15)),
            'user_id' => $user->id,
            'transaction_type' => 'subscription',
            'transaction_reason' => 'Registration Level Payment',
            'level_id' => $validated['level'],
            'amount' => $this->levels->find($validated['level'])->registration_amount,
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

        //$this->redirect(route('paystack.payment.init', ['reference' => $transaction->reference]), navigate: true);
    }
}
