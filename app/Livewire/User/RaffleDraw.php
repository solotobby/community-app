<?php

namespace App\Livewire\User;

use App\Http\Controllers\PaystackController;
use App\Models\LevelItem;
use Illuminate\Support\Str;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\BankInfo;
use App\Models\RaffleDraw as Raffle;
use App\Models\Transaction;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class RaffleDraw extends Component
{
    public $user;
    public $currentDraw;
    public $showClaimModal = false;
    public $showPinModal = false;
    public $showSetPinModal = false;
    public $selectedDraw;
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

    public function mount()
    {
        $this->user = Auth::user();
        $this->banks = $this->fetchBanks();
    }

    public function fetchBanks()
    {
        try {
            $response = Http::withToken(config('services.paystack.secret_key'))
                ->get('https://api.paystack.co/bank');

            if ($response->ok()) {
                return $response->json('data');
            } else {
                session()->flash('error', 'Unable to fetch banks from Paystack.');
                return [];
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error fetching banks.');
            return [];
        }
    }

    public function validateAccount()
    {
        $this->validate([
            'account_number' => 'required|string|min:10|max:10',
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

            if ($response->ok()) {
                $data = $response->json('data');
                $this->account_name = $data['account_name'];
                session()->flash('message', 'Account validated successfully!');
            } else {
                session()->flash('error', 'Unable to validate account. Please check your details.');
                $this->account_name = '';
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error validating account.');
            $this->account_name = '';
        }
    }

    public function openClaimModal($drawId)
    {
        $this->selectedDraw = Raffle::findOrFail($drawId);
        $this->bankInfo = auth()->user()->bankInfo;

        if ($this->bankInfo) {
            $this->hasBankAccount = true;

            // Check if user has transaction PIN
            if (!$this->user->transaction_pin) {
                $this->showSetPinModal = true;
            } else {
                $this->showClaimModal = true;
            }
        } else {
            $this->showBankModal = true;
        }
    }

    public function performDraw()
    {
        if (!$this->user->can_raffle || $this->user->raffle_draw_count < 1) {
            session()->flash('error', 'No draw available.');
            return;
        }

        $levelItems = LevelItem::where('level_id', $this->user->level)->get();
        if ($levelItems->isEmpty()) {
            session()->flash('error', 'No rewards configured for your level.');
            return;
        }

        $rewardItem = $levelItems->random();

        $draw = Raffle::create([
            'user_id' => $this->user->id,
            'reward' => $rewardItem->item_name,
            'price' => $rewardItem->price,
            'currency' => $rewardItem->currency,
            'used_type' => 'draw',
            'status' => 'pending',
            'expired_at' => now()->addHours(24),
        ]);

        $newCount = $this->user->raffle_draw_count - 1;
        $this->user->update([
            'raffle_draw_count' => $newCount,
            'can_raffle' => $newCount > 0,
        ]);

        $this->currentDraw = $draw;
        $this->user = $this->user->fresh();

        session()->flash('message', 'You won a reward! Claim within 24 hours.');
    }

    public function saveBankDetails()
    {
        $this->validate([
            'bank_name' => 'required|string',
            'account_name' => 'required|string',
            'account_number' => 'required|string|min:10|max:10',
        ]);

        $bankCode = collect($this->banks)->firstWhere('name', $this->bank_name)['code'] ?? null;

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
            $this->showSetPinModal = true;
        } else {
            $this->showClaimModal = true;
        }

        session()->flash('message', 'Bank details saved successfully!');
    }

    public function closeBankModal()
    {
        $this->showBankModal = false;
        $this->resetBankFields();
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
        $this->confirm_transaction_pin = '';
        $this->resetErrorBag([
            'new_transaction_pin',
            'confirm_transaction_pin'
        ]);
        $this->showSetPinModal = true;
    }

    public function closeSetPinModal()
    {
        $this->showSetPinModal = false;
        $this->new_transaction_pin = '';
        $this->confirm_transaction_pin = '';
        $this->resetErrorBag(['new_transaction_pin', 'confirm_transaction_pin']);
    }

    public function saveTransactionPin()
    {
        $this->validate([
            'new_transaction_pin' => 'required|numeric|digits:4|confirmed',
        ], [
            'new_transaction_pin.confirmed' => 'PIN confirmation does not match.',
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
            'pin' => 'required|string',
        ]);

        $draw = $this->selectedDraw;

        if ($draw->status !== 'pending' || now()->gt($draw->expired_at)) {
            session()->flash('error', 'This reward has expired or is already claimed.');
            $this->showPinModal = false;
            return;
        }

        if (!Hash::check($this->pin, $this->user->transaction_pin)) {
            session()->flash('error', 'Invalid transaction PIN.');
            return;
        }

        if ($this->processPayment()) {
            $draw->update([
                'status' => 'earned',
                'claimed_at' => now(),
            ]);
            $this->showClaimModal = false;
            $this->pin = '';

            session()->flash('message', 'Payment has been initiated to your account.');
        } else {
            $this->showClaimModal = false;
            $this->pin = '';
            session()->flash('error', 'Error Processing Payment to your account.');
        }
    }

    public function processPayment()
    {

        $draw = $this->selectedDraw;
        $user = $this->user;
        $amount = $draw->price;
        try {

            $txn = 'TXN_' . Str::uuid();
            // Create transaction
            Transaction::create([
                'reference' => $txn,
                'user_id' => $user->id,
                'transaction_type' => 'payout',
                'transaction_reason' => 'Raffle Draw Withdrawal',
                'level_id' => $user->level,
                'amount' => $draw->price,
                'status' => 'pending',
            ]);

            $paystack = new PaystackController();

            // $resolve = $paystack->resolveAccount(
            //     $user->bankInfo->account_number,
            //     $user->bankInfo->bank_code
            // );
            $response = $paystack->createRecipient(
                $user->bankInfo->account_name,
                $user->bankInfo->account_number,
                $user->bankInfo->bank_code,
                'NGN'
            );
            if ($response) {
                $user->recipient_code = $response['recipient_code'];
                $user->save();
            }

            $transferFund = $paystack->initializeTransfer(
                $draw->price,
                $user->recipient_code,
                'Raffle Draw Withdrawal',
                $txn
            );
            if ($transferFund['status']) {
                Transaction::where('reference', $txn)->update(['status' => 'success']);
                return true;
            } else {
                session()->flash('error', $transferFund['message'] ?? 'Transfer failed.');
            }
        } catch (\Throwable $e) {
            logger()->error('Paystack payout failed', ['error' => $e->getMessage()]);
            session()->flash('error', 'An unexpected error occurred while processing payment.');
        }
    }
    public function render()
    {
        Raffle::where('user_id', $this->user->id)
            ->where('status', 'pending')
            ->where('expired_at', '<', now())
            ->update(['status' => 'expired']);

        $draws = Raffle::where('user_id', $this->user->id)->latest()->get();

        return view('livewire.user.raffle-draw', [
            'availableDraws' => $this->user->raffle_draw_count,
            'draws' => $draws,
        ]);
    }
}
