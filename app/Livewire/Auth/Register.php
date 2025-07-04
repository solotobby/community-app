<?php


namespace App\Livewire\Auth;

use App\Http\Controllers\PaystackController;
use App\Models\Level;
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
    public $agreeTerms = false;
    public string $referral_code;
    public string $password = '';
    public string $password_confirmation = '';
    public string $level = '';

    public $showTermsModal = false;
    /** @var \Illuminate\Database\Eloquent\Collection */
    public $levels;
    public $selectedLevelAmount = null;


    public function mount()
    {
        $this->levels = Level::orderBy('registration_amount')->get();
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

    public function openTermsModal()
    {
        $this->showTermsModal = true;
    }

    public function closeTermsModal()
    {
        $this->showTermsModal = false;
    }



    public function register()
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'level' => ['required', 'integer', 'exists:levels,id'],
            'referral_code' => ['nullable', 'string'],
            'agreeTerms' => ['accepted'],
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
            if ($user->has_subscribed && !$user->free_user) {
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
        $level = $this->levels->find($validated['level']);

        if ($level->registration_amount == 0) {
            $user->update([
                'free_user' => true,
            ]);
            Auth::login($user);
            $this->redirect(route('home'), navigate: true);
            return;
        }

        // Create transaction
        $transaction = Transaction::create([
            'reference' => 'TXN_' . Str::upper(Str::random(15)),
            'user_id' => $user->id,
            'transaction_type' => 'subscription',
            'transaction_reason' => 'Registration Level Payment',
            'level_id' => $validated['level'],
            'amount' => $level->registration_amount,
            'status' => 'pending',
        ]);

        //Initiate Payment
        $paymentUrl = app(PaystackController::class)->initializeFunding(
            $user->email,
            $transaction->amount,
            $transaction->reference,
            route('paystack.payment.callback'),
            []
        );

        if ($paymentUrl) {
            return redirect()->away($paymentUrl);
        } else {
            session()->flash('error', 'Payment initialization failed, try again.');
        }
    }
}
