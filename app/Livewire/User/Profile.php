<?php

namespace App\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\BankInfo;
use App\Models\Level;
use Illuminate\Support\Facades\Http;

class Profile extends Component
{
    public $hasBankInfo, $hasPin;
    public $name, $email, $level, $referred_by, $referral_code, $bank_name, $account_name, $account_number, $bank_code;
    public $banks = [];
    public $transaction_pin;
    public $showBankModal = false;
    public $showPinModal = false;

    public $showUserModal = false;
    public $current_password, $new_password, $new_password_confirmation;


    public function mount()
    {
        $user = Auth::user();

        $this->name = $user->name;
        $this->email = $user->email;
        $this->referral_code = $user->referral_code;
        $this->referred_by = $user->referrer->name ?? null;
        $this->level = Level::findOrFail($user->level);
        $this->transaction_pin = $user->transaction_pin ?? true;

        $bank = $user->bankInfo;
        if ($bank) {
            $this->bank_name = $bank->bank_name;
            $this->bank_code = $bank->bank_code;
            $this->account_number = $bank->account_number;
            $this->account_name = $bank->account_name;
        }
    }

    public function validateAccount()
    {
        if (strlen($this->account_number) === 10 && $this->bank_code) {
            $this->resolveAccountName();
        } else {
            session()->flash('error', 'Please select a bank and enter a valid 10-digit account number.');
        }
    }

    public function fetchBanks()
    {
        try {
            $response = Http::withToken(config('services.paystack.secret_key'))
                ->get('https://api.paystack.co/bank');

            if ($response->ok()) {
                $this->banks = $response->json('data');
            } else {
                session()->flash('error', 'Unable to fetch banks from Paystack.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error fetching banks.');
        }
    }

    public function openBankModal()
    {
        $this->reset(['bank_name', 'bank_code']);
        $this->fetchBanks();
        $this->showBankModal = true;
    }

    public function updatedAccountNumber($value)
    {
        if (strlen($value) === 10 && $this->bank_code) {
            $this->resolveAccountName();
        }
    }

    public function updatedBankName($value)
    {
        $selected = collect($this->banks)->firstWhere('name', $value);
        $this->bank_code = $selected['code'] ?? '';

        if (strlen($this->account_number) === 10 && $this->bank_code) {
            $this->resolveAccountName();
        }
    }

    public function resolveAccountName()
    {
        try {
            $response = Http::withToken(config('services.paystack.secret_key'))
                ->get('https://api.paystack.co/bank/resolve', [
                    'account_number' => $this->account_number,
                    'bank_code' => $this->bank_code,
                ]);

            if ($response->ok()) {
                $this->account_name = $response['data']['account_name'] ?? '';
                session()->flash('success', 'Account name fetched successfully.');
            } else {
                $this->account_name = '';
                session()->flash('error', 'Unable to resolve account name.');
            }
        } catch (\Exception $e) {
            $this->account_name = '';
            session()->flash('error', 'An error occurred while resolving account.');
        }
    }

    public function openUserModal()
    {
        $this->resetValidation();
        $this->showUserModal = true;
    }

    public function closeUserModal()
    {
        $this->showUserModal = false;
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

        $user = auth()->user();

        if ($this->new_password) {
            $user->password = Hash::make($this->new_password);
        }

        $user->save();

        $this->closeUserModal();
        session()->flash('success', 'User password updated successfully.');
    }


    public function updateProfile()
    {
        $this->validate([
            'bank_name' => 'nullable|string|max:255',
            'bank_code' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:20',
            'account_name' => 'nullable|string|max:255',
            'transaction_pin' => 'nullable|string|min:4|max:6',
        ]);

        $user = Auth::user();

        session()->flash('success', 'Profile updated successfully.');
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
        session()->flash('success', 'Bank detail saved successfully.');
    }

    public function saveTransactionPin()
    {
        $this->validate([
            'transaction_pin' => 'required|digits:4',
        ]);

        auth()->user()->update([
            'transaction_pin' => Hash::make($this->transaction_pin),
        ]);

        $this->reset('transaction_pin');
        session()->flash('success', 'Transaction PIN set successfully.');
        $this->closePinModal();
    }


    public function openPinModal()
    {
        $this->showPinModal = true;
    }

    public function closePinModal()
    {
        $this->showPinModal = false;
    }


    public function closeBankModal()
    {
        $this->showBankModal = false;
    }

    public function render()
    {
        return view('livewire.user.profile');
    }
}
