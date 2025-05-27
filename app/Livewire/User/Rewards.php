<?php

namespace App\Livewire\User;

use App\Http\Controllers\PaystackController;
use App\Models\BankInfo;
use App\Models\Reward;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class Rewards extends Component
{
    use WithPagination;

    public $user;
    public $currentDraw;
    public $showClaimModal = false;
    public $showPinModal = false;
    public $showSetPinModal = false;
    public $selectedReward; // Changed from selectedDraw to selectedReward
    public $hasBankAccount = false;
    public $bankInfo;
    public $pin = '';
    public $new_transaction_pin = '';
    public $new_transaction_pin_confirmation = '';
    public $confirm_transaction_pin = '';
    public $bank_name = '';
    public $account_name = '';
    public $account_number = '';
    public $banks = [];
    public $showBankModal = false;

    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->user = Auth::user();
        $this->banks = $this->fetchBanks();
        $this->bankInfo = $this->user->bankInfo;
        $this->hasBankAccount = $this->bankInfo ? true : false;
    }

    public function resetBankFields()
    {
        $this->bank_name = '';
        $this->account_name = '';
        $this->account_number = '';
        $this->resetErrorBag([
            'bank_name',
            'account_name',
            'account_number'
        ]);
    }

    public function openSetPinModal()
    {
        $this->new_transaction_pin = '';
        $this->new_transaction_pin_confirmation = '';
        $this->resetErrorBag([
            'new_transaction_pin',
            'new_transaction_pin_confirmation'
        ]);
        $this->showSetPinModal = true;
    }

    public function closeSetPinModal()
    {
        $this->showSetPinModal = false;
        $this->new_transaction_pin = '';
        $this->new_transaction_pin_confirmation = '';
        $this->resetErrorBag(['new_transaction_pin', 'new_transaction_pin_confirmation']);
    }

    public function saveTransactionPin()
    {
        $this->validate([
            'new_transaction_pin' => 'required|numeric|digits:4',
            'new_transaction_pin_confirmation' => 'required|same:new_transaction_pin',
        ], [
            'new_transaction_pin_confirmation.same' => 'PIN confirmation does not match.',
        ]);

        $this->user->update([
            'transaction_pin' => Hash::make($this->new_transaction_pin)
        ]);

        $this->user = $this->user->fresh();
        $this->closeSetPinModal();
        $this->showClaimModal = true;

        session()->flash('message', 'Transaction PIN set successfully!');
    }

    public function confirmClaim()
    {
        $this->validate([
            'pin' => 'required|string|digits:4',
        ]);

        $reward = $this->selectedReward;

        // Check if reward is still claimable
        if ($reward->is_claim || $reward->reward_status !== 'pending') {
            session()->flash('error', 'This reward has already been claimed or is not available.');
            $this->showClaimModal = false;
            return;
        }

        // Verify transaction PIN
        if (!Hash::check($this->pin, $this->user->transaction_pin)) {
            session()->flash('error', 'Invalid transaction PIN.');
            return;
        }

        if ($this->processPayment()) {
            $reward->update([
                'reward_status' => 'earned',
                'is_claim' => true,
                'claimed_at' => now(),
            ]);

            $this->showClaimModal = false;
            $this->pin = '';
            $this->selectedReward = null;

            session()->flash('message', 'Payment has been initiated to your account.');
        } else {
            $this->showClaimModal = false;
            $this->pin = '';
            session()->flash('error', 'Error processing payment to your account.');
        }
    }

    public function saveBankDetails()
    {
        $this->validate([
            'bank_name' => 'required|string',
            'account_name' => 'required|string',
            'account_number' => 'required|string|digits:10',
        ]);

        $bankCode = collect($this->banks)->firstWhere('name', $this->bank_name)['code'] ?? null;

        if (!$bankCode) {
            session()->flash('error', 'Invalid bank selected.');
            return;
        }

        BankInfo::updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'bank_name' => $this->bank_name,
                'bank_code' => $bankCode,
                'account_name' => $this->account_name,
                'account_number' => $this->account_number,
            ]
        );

        $this->bankInfo = auth()->user()->fresh()->bankInfo;
        $this->hasBankAccount = true;
        $this->closeBankModal();

        // Check if user has transaction PIN after saving bank details
        if (!$this->user->transaction_pin) {
            $this->openSetPinModal();
        } else {
            $this->showClaimModal = true;
        }

        session()->flash('message', 'Bank details saved successfully!');
    }

    public function fetchBanks()
    {
        try {
            $response = Http::withToken(config('services.paystack.secret_key'))
                ->get('https://api.paystack.co/bank');

            if ($response->successful()) {
                return $response->json('data');
            } else {
                session()->flash('error', 'Unable to fetch banks from Paystack.');
                return [];
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error fetching banks: ' . $e->getMessage());
            return [];
        }
    }

    public function validateAccount()
    {
        $this->validate([
            'account_number' => 'required|string|digits:10',
            'bank_name' => 'required|string',
        ]);

        $bankCode = collect($this->banks)->firstWhere('name', $this->bank_name)['code'] ?? null;

        if (!$bankCode) {
            session()->flash('error', 'Invalid bank selected.');
            return;
        }

        try {
            $response = Http::withToken(config('services.paystack.secret_key'))
                ->get("https://api.paystack.co/bank/resolve", [
                    'account_number' => $this->account_number,
                    'bank_code' => $bankCode,
                ]);

            if ($response->successful()) {
                $data = $response->json('data');
                $this->account_name = $data['account_name'];
                session()->flash('message', 'Account validated successfully!');
            } else {
                session()->flash('error', 'Unable to validate account. Please check your details.');
                $this->account_name = '';
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error validating account: ' . $e->getMessage());
            $this->account_name = '';
        }
    }

    public function openClaimModal($rewardId)
    {
        $this->selectedReward = Reward::findOrFail($rewardId);
        $this->bankInfo = auth()->user()->bankInfo;

        if ($this->bankInfo) {
            $this->hasBankAccount = true;

            // Check if user has transaction PIN
            if (!$this->user->transaction_pin) {
                $this->openSetPinModal();
            } else {
                $this->showClaimModal = true;
            }
        } else {
            $this->showBankModal = true;
        }
    }

    public function closeBankModal()
    {
        $this->showBankModal = false;
        $this->resetBankFields();
    }

    public function closeClaimModal()
    {
        $this->showClaimModal = false;
        $this->pin = '';
        $this->selectedReward = null;
        $this->resetErrorBag(['pin']);
    }

    public function processPayment()
    {
        $reward = $this->selectedReward;
        $user = $this->user;
        $amount = $reward->amount;

        try {
            $txn = 'TXN_' . Str::uuid();

            // Create transaction record
            Transaction::create([
                'reference' => $txn,
                'user_id' => $user->id,
                'transaction_type' => 'payout',
                'transaction_reason' => 'Referral Reward Withdrawal',
                'level_id' => $user->level ?? null,
                'amount' => $amount,
                'status' => 'pending',
            ]);

            $paystack = new PaystackController();

            // Create or get recipient
            if (!$user->recipient_code) {
                $response = $paystack->createRecipient(
                    $user->bankInfo->account_name,
                    $user->bankInfo->account_number,
                    $user->bankInfo->bank_code,
                    'NGN'
                );

                if ($response && isset($response['recipient_code'])) {
                    $user->recipient_code = $response['recipient_code'];
                    $user->save();
                } else {
                    throw new \Exception('Failed to create recipient');
                }
            }

            // Initialize transfer
            $transferFund = $paystack->initializeTransfer(
                $amount * 100, // Convert to kobo
                $user->recipient_code,
                'Referral Reward Withdrawal',
                $txn
            );

            if (isset($transferFund['status']) && $transferFund['status']) {
                Transaction::where('reference', $txn)->update(['status' => 'success']);
                return true;
            } else {
                Transaction::where('reference', $txn)->update(['status' => 'failed']);
                $errorMessage = $transferFund['message'] ?? 'Transfer failed.';
                session()->flash('error', $errorMessage);
                return false;
            }
        } catch (\Throwable $e) {
            // Update transaction status to failed
            if (isset($txn)) {
                Transaction::where('reference', $txn)->update(['status' => 'failed']);
            }

            logger()->error('Paystack payout failed', [
                'error' => $e->getMessage(),
                'user_id' => $user->id,
                'reward_id' => $reward->id
            ]);

            session()->flash('error', 'An unexpected error occurred while processing payment.');
            return false;
        }
    }

    public function render()
    {
        $rewards = Reward::with('referrer')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('livewire.user.rewards', compact('rewards'));
    }
}
