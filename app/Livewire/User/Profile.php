<?php

namespace App\Livewire\User;

use App\Http\Controllers\MailController;
use App\Http\Controllers\PaystackController;
use Illuminate\Support\Str;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\BankInfo;
use App\Models\Level;
use App\Models\PhoneOtp;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class Profile extends Component
{
    // Modal states
    public $showContactModal = false;
    public $showBankModal = false;
    public $showPinModal = false;
    public $showUserModal = false;
    public $showPhoneVerificationModal = false;

    public $showResetPinModal = false;


    // Contact information
    public $phone, $dob, $phone_verified, $email_verified, $address, $landmark, $lga, $state, $country;

    // User information
    public $name, $email, $level, $referred_by, $referral_code;

    // Bank information
    public $bank_name, $account_name, $account_number, $bank_code;
    public $banks = [];

    // Security
    public $transaction_pin = '';
    public $new_transaction_pin = '';
    public $current_pin = '';
    public $confirm_transaction_pin = '';

    public $reset_token = '';
    public $new_pin = '';
    public $confirm_pin = '';

    // Password change
    public $current_password, $new_password, $new_password_confirmation;

    // Phone verification
    public $verification_code_sent = false;
    public $verification_code = '';

    public function mount()
    {
        $user = Auth::user();

        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->phone_verified = $user->phone_verified ?? false;
        $this->email_verified = $user->email_verified ?? false;
        $this->address = $user->address;
        $this->landmark = $user->landmark;
        $this->lga = $user->lga;
        $this->dob = $user->dob;
        $this->state = $user->state;
        $this->country = $user->country;
        $this->referral_code = $user->referral_code;
        $this->referred_by = $user->referrer->name ?? null;
        $this->level = Level::find($user->level);
        $this->transaction_pin = $user->transaction_pin ? '****' : null;

        $bank = $user->bankInfo;
        if ($bank) {
            $this->bank_name = $bank->bank_name;
            $this->bank_code = $bank->bank_code;
            $this->account_number = $bank->account_number;
            $this->account_name = $bank->account_name;
        } else {
            $this->fetchBanks();
        }
    }

    public function fetchBanks()
    {
        $this->banks = app(PaystackController::class)->fetchBankList() ?? [];
    }

    public function openBankModal()
    {
        $this->reset(['bank_name', 'bank_code', 'account_number', 'account_name']);
        $this->showBankModal = true;
    }

    public function closeBankModal()
    {
        $this->showBankModal = false;
        $this->resetValidation();
    }

    public function updatedBankName($value)
    {
        $selected = collect($this->banks)->firstWhere('name', $value);
        $this->bank_code = $selected['code'] ?? '';
        $this->account_name = '';

        if (strlen($this->account_number) === 10 && $this->bank_code) {
            $this->validateAccount();
        }
    }

    public function updatedAccountNumber($value)
    {
        $this->account_name = '';
        if (strlen($value) === 10 && $this->bank_code) {
            $this->validateAccount();
        }
    }


    public function validateAccount(): void
    {
        if (strlen($this->account_number) !== 10 || empty($this->bank_code)) {
            session()->flash('error', 'Please select a bank and enter a valid 10‑digit account number.');
            return;
        }

        try {
            $result = app(PaystackController::class)->resolveAccount(
                $this->account_number,
                $this->bank_code
            );

            if ($result['status'] ?? false) {
                $this->account_name = $result['data']['account_name'] ?? '';
                session()->flash('success', 'Account name fetched successfully.');
            } else {
                $this->account_name = '';
                session()->flash('error', $result['message'] ?? 'Unable to resolve account name.');
            }
        } catch (Throwable $e) {
            $this->account_name = '';
            Log::error('Account resolution error: ' . $e->getMessage());
            session()->flash('error', 'An unexpected error occurred while resolving account.');
        }
    }


    public function saveBankDetails()
    {
        $this->validate([
            'bank_name' => 'required|string|max:255',
            'bank_code' => 'required|string|max:255',
            'account_number' => 'required|string|size:10',
            'account_name' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        BankInfo::updateOrCreate(
            ['user_id' => $user->id],
            [
                'bank_name' => $this->bank_name,
                'bank_code' => $this->bank_code,
                'account_number' => $this->account_number,
                'account_name' => $this->account_name,
            ]
        );

        $this->closeBankModal();
        $this->mount(); // Refresh data
        session()->flash('success', 'Bank details saved successfully.');
    }

    // Contact Methods
    public function openContactModal()
    {
        $user = auth()->user();
        $this->phone = $user->phone;
        $this->dob = $user->dob;
        $this->address = $user->address;
        $this->landmark = $user->landmark;
        $this->landmark = $user->landmark;
        $this->lga = $user->lga;
        $this->state = $user->state;
        $this->country = $user->country;
        $this->showContactModal = true;
        $this->resetValidation();
    }

    public function closeContactModal()
    {
        $this->showContactModal = false;
        $this->resetValidation();
    }

    public function saveContactInfo()
    {
        $this->validate([
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'landmark' => 'nullable|string|max:255',
            'lga' => 'nullable|string|max:255',
            'dob' => 'nullable|date|before:today',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
        ]);

        if (auth()->user()->phone !== $this->phone) {
            auth()->user()->update([
                'phone_verified' => false,
                'phone_verified_at' => null,
            ]);
        }
        auth()->user()->update([
            'phone' => $this->phone,
            'dob' => $this->dob,
            'address' => $this->address,
            'landmark' => $this->landmark,
            'lga' =>  $this->lga,
            'state' =>  $this->state,
            'country' => $this->country
        ]);

        $this->closeContactModal();
        $this->mount();
        session()->flash('success', 'Contact information updated successfully.');
    }

    // PIN Methods
    public function openPinModal()
    {
        $this->reset(['new_transaction_pin', 'current_pin', 'confirm_transaction_pin']);
        $this->showPinModal = true;
        $this->resetValidation();
    }

    public function closePinModal()
    {
        $this->showPinModal = false;
        $this->resetValidation();
    }


    public function openResetPinModal()
    {
        $this->sendEmailToken();
        $this->showResetPinModal = true;
        $this->showPinModal = false;
        $this->reset_token = '';
        $this->new_pin = '';
        $this->confirm_pin = '';
        $this->resetValidation();
    }

    public function resendToken()
    {
        $user = Auth::user();
        $code = rand(100000, 999999);

        PhoneOtp::updateOrCreate(
            ['phone' => $user->email],
            [
                'code' => $code,
                'expires_at' => now()->addMinutes(10),
            ]
        );

        // Send OTP via mail
        $response = app(MailController::class)->sendMail(
            $user->email,
            'RESET TRANSACTION PIN',
            'Kindly use the code to reset your transaction pin: ' . $code
        );

        return back()->with('success', 'A new token has been sent to your email.');
    }

    public function sendEmailToken()
    {
        try {

            $user = Auth::user();
            $code = rand(100000, 999999);

            PhoneOtp::updateOrCreate(
                ['phone' => $user->email],
                [
                    'code' => $code,
                    'expires_at' => now()->addMinutes(10),
                ]
            );

            // Send OTP via mail
            $response = app(MailController::class)->sendMail(
                $user->email,
                'RESET TRANSACTION PIN',
                'Kindly use the code to reset your transaction pin: ' . $code
            );

            $this->resetPinInputs();

            session()->flash($response ? 'success' : 'error', $response
                ? 'Verification code sent to your email.'
                : 'Failed to send verification code. Try again.');
        } catch (Throwable $e) {
            Log::error('OTP send failed', ['error' => $e->getMessage()]);
            session()->flash('error', 'Failed to send verification code. Please try again.');
        }
    }
    public function closeResetPinModal()
    {
        $this->showResetPinModal = false;
        $this->resetValidation();
    }

    public function resetTransactionPin()
    {
        $user = Auth::user();

        $rules = [
            'reset_token' => 'required',
            'new_pin' => 'required|digits:4',
            'confirm_pin' => 'required|same:new_pin',
        ];


        $this->validate($rules);

        // Verify token
        $record = PhoneOtp::where('phone', $user->email)
            ->where('code', $this->reset_token)
            ->where('expires_at', '>=', now())
            ->first();

        if (!$record) {
            session()->flash('error', 'Invalid or expired token.');
            return;
        }

        $user->update([
            'transaction_pin' => Hash::make($this->new_pin),
        ]);

        $record->delete();

        $this->closeResetPinModal();
        $this->mount();
        session()->flash('success', 'Transaction PIN ' . ($user->transaction_pin ? 'updated' : 'set') . ' successfully.');
    }

    private function resetPinInputs()
    {
        $this->reset_token = '';
        $this->new_pin = '';
        $this->confirm_pin = '';
        $this->resetValidation();
    }

    public function saveTransactionPin()
    {
        $user = auth()->user();

        $rules = [
            'new_transaction_pin' => 'required|digits:4',
            'confirm_transaction_pin' => 'required|same:new_transaction_pin',
        ];

        // If user already has a PIN, require current PIN
        if ($user->transaction_pin) {
            $rules['current_pin'] = 'required|digits:4';
        }

        $this->validate($rules);

        // Verify current PIN if it exists
        if ($user->transaction_pin && !Hash::check($this->current_pin, $user->transaction_pin)) {
            return session()->flash('error', 'Current PIN is incorrect.');
        };

        $user->update([
            'transaction_pin' => Hash::make($this->new_transaction_pin),
        ]);

        $this->closePinModal();
        $this->mount();
        session()->flash('success', 'Transaction PIN ' . ($user->transaction_pin ? 'updated' : 'set') . ' successfully.');
    }

    // Password Methods
    public function openUserModal()
    {
        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);
        $this->showUserModal = true;
        $this->resetValidation();
    }

    public function closeUserModal()
    {
        $this->showUserModal = false;
        $this->resetValidation();
    }

    public function updateUserDetails()
    {
        $this->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        if (!Hash::check($this->current_password, auth()->user()->password)) {
            return session()->flash('error', 'Current password is incorrect.');
        }

        auth()->user()->update([
            'password' => Hash::make($this->new_password),
        ]);

        $this->closeUserModal();
        session()->flash('success', 'Password updated successfully.');
    }

    // Phone Verification Methods
    public function openPhoneVerificationModal()
    {
        $this->showPhoneVerificationModal = true;
        $this->verification_code_sent = false;
        $this->verification_code = '';
        $this->resetValidation();
    }

    public function closePhoneVerificationModal()
    {
        $this->showPhoneVerificationModal = false;
        $this->verification_code_sent = false;
        $this->verification_code = '';
        $this->resetValidation();
    }

    public function sendVerificationCode()
    {
        try {
            $code = rand(100000, 999999);

            PhoneOtp::updateOrCreate(
                ['phone' => $this->phone],
                [
                    'code' => $code,
                    'expires_at' => now()->addMinutes(10),
                ]
            );

            $newPhone = Str::startsWith($this->phone, '+')
                ? $this->phone
                : '+234' . ltrim($this->phone, '0');

            $payload = [
                'api_key' => config('services.termii.api_key'),
                'message_type' => 'NUMERIC',
                'to' => $newPhone,
                'from' => config('services.termii.sender_id'),
                'channel' => 'generic',
                'type' => 'plain',
                "sms" => "Your phone number verification code is: {$code} - Famlic"
            ];

            // Send OTP via Termii
            $response = Http::post('https://v3.api.termii.com/api/sms/send', $payload);

            if ($response->successful()) {
                $this->verification_code_sent = true;
                log::info('success', ['response' => $response->body(), 'payload' => $payload]);
                session()->flash('success', 'Verification code sent to your phone.');
            } else {
                $this->verification_code_sent = false;
                Log::error('Termii OTP send failed', ['response' => $response->body()]);
                session()->flash('error', 'Failed to send verification code. Try again.');
            }
        } catch (Throwable $e) {
            Log::error('OTP send failed', ['error' => $e->getMessage()]);
            session()->flash('error', 'Failed to send verification code. Please try again.');
        }
    }

    public function resendVerificationCode()
    {
        $this->sendVerificationCode();
    }

    public function verifyPhoneNumber()
    {
        $this->validate([
            'verification_code' => 'required|digits:6',
        ]);

        $record = PhoneOtp::where('phone', $this->phone)
            ->where('code', $this->verification_code)
            ->where('expires_at', '>=', now())
            ->first();

        if (!$record) {
            session()->flash('error', 'Invalid or expired verification code.');
            return;
        }

        auth()->user()->update([
            'phone_verified' => true,
            'phone_verified_at' => now(),
        ]);

        $record->delete();

        $this->closePhoneVerificationModal();
        $this->mount();

        session()->flash('success', 'Phone number verified successfully.');
    }

    public function render()
    {
        return view('livewire.user.profile');
    }
}
