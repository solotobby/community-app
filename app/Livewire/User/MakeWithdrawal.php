<?php

namespace App\Livewire\User;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PaystackController;
use App\Models\BankInfo;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;
use Throwable;

class MakeWithdrawal extends Component
{
    use WithPagination;

    public $amount = '';
    public $bank_name = '';
    public $bank_code = '';
    public $account_number = '';
    public $account_name = '';

    public $pin = '';
    public $current_pin = '';
    public $new_transaction_pin = '';
    public $new_transaction_pin_confirmation = '';
    public float $balance = 0;

    public $user;
    public $bankInfo;
    public $banks = [];
    public $transaction_pin;
    public $perPage = 10;
    protected $paginationTheme = 'bootstrap';

    public $showBankModal = false;
    public $showPinModal = false;
    public $showConfirmModal = false;

    public function mount()
    {
        $this->user = Auth::user();
        $this->bankInfo = $this->user->bankInfo;
        $this->transaction_pin = $this->user->transaction_pin;
        $this->balance = $this->user->wallet->withdrawable_balance ?? 0;

        $bank = $this->user->bankInfo;
        if ($bank) {
            $this->bank_name = $bank->bank_name;
            $this->bank_code = $bank->bank_code;
            $this->account_number = $bank->account_number;
            $this->account_name = $bank->account_name;
        }

        $this->fetchBanks();
    }

    public function fetchBanks()
    {
        $this->banks = app(PaystackController::class)->fetchBankList() ?? [];
    }

    public function openBankModal()
    {
        $this->fetchBanks();
        $this->showBankModal = true;
        $this->resetValidation();
    }

    public function closeBankModal()
    {
        $this->showBankModal = false;
        $this->resetValidation();
    }

    public function openPinModal()
    {
        $this->reset(['new_transaction_pin', 'current_pin', 'new_transaction_pin_confirmation']);
        $this->showPinModal = true;
        $this->resetValidation();
    }

    public function closePinModal()
    {
        $this->showPinModal = false;
        $this->resetValidation();
    }

    public function closeConfirmModal()
    {
        $this->showConfirmModal = false;
        $this->pin = '';
        $this->resetValidation();
    }

    public function saveTransactionPin()
    {
        $user = Auth::user();

        $rules = [
            'new_transaction_pin' => 'required|digits:4',
            'new_transaction_pin_confirmation' => 'required|same:new_transaction_pin',
        ];

        // If user already has a PIN, require current PIN
        if ($user->transaction_pin) {
            $rules['current_pin'] = 'required|digits:4';
        }

        $this->validate($rules);

        // Verify current PIN if it exists
        if ($user->transaction_pin && !Hash::check($this->current_pin, $user->transaction_pin)) {
            $this->addError('current_pin', 'Current PIN is incorrect.');
            return;
        }

        $user->update([
            'transaction_pin' => Hash::make($this->new_transaction_pin),
        ]);

        $this->closePinModal();
        $this->mount();
        session()->flash('success', 'Transaction PIN ' . ($user->transaction_pin ? 'updated' : 'set') . ' successfully.');
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
        $this->mount();
        session()->flash('success', 'Bank details saved successfully.');
    }

    public function submit(): void
    {
        $this->validate([
            'amount' => 'required|numeric|min:100|max:' . $this->balance,
        ]);

        if (!$this->bank_name || !$this->account_number || !$this->account_name) {
            session()->flash('error', 'Please add your bank details first.');
            return;
        }

        if (!$this->user->transaction_pin) {
            session()->flash('error', 'Please set your transaction PIN first.');
            return;
        }

        $this->showConfirmModal = true;
    }

    private function resetClaimProcess()
    {
        $this->showConfirmModal = false;
        $this->pin = '';
        $this->amount = '';
    }
    public function confirmWithdrawal(): void
    {
        $this->validate([
            'pin' => 'required|digits:4',
        ]);

        // Verify PIN
        if (!Hash::check($this->pin, $this->user->transaction_pin)) {
            $this->addError('pin', 'Invalid transaction PIN.');
            return;
        }

        try {
            DB::transaction(function () {
                $wallet = $this->user->wallet;

                // Deduct amount from wallet
                $wallet->decrement('balance', $this->amount);
                $wallet->decrement('withdrawable_balance', $this->amount);

                $transaction =  Transaction::create([
                    'reference' => 'WD_' . Str::upper(Str::random(15)),
                    'user_id' => Auth::id(),
                    'transaction_type' => 'wallet_withdrawal',
                    'transaction_reason' => 'Wallet Withdrawal',
                    'amount' => $this->amount,
                    'status' => 'pending',
                    'level_id' => $this->user->level,
                ]);

                if ($this->processPayment($transaction)) {

                    $this->resetClaimProcess();
                    session()->flash('success', 'Payment has been initiated to your account.');
                } else {

                    $wallet->decrement('balance', $this->amount);
                    $wallet->decrement('withdrawable_balance', $this->amount);
                    $this->resetClaimProcess();
                    session()->flash('error', 'Error processing payment to your account.');
                }

                $this->balance = $wallet->fresh()->withdrawable_balance;
            });

            $this->closeConfirmModal();
            $this->reset(['amount', 'pin']);
            session()->flash('success', 'Withdrawal request submitted successfully!');
        } catch (Throwable $e) {

            Log::error('Withdrawal error: ' . $e->getMessage());
            $this->resetClaimProcess();
            session()->flash('error', 'An error occurred while processing your withdrawal.');

        }
    }
    private function processPayment($transaction): bool
    {
        DB::beginTransaction();
        try {
            $feePercentage = 5;
            $feeAmount = ($feePercentage / 100) * $transaction->amount;
            $amount = $transaction->amount - $feeAmount;


            $paystack = new PaystackController();

            $response = $paystack->createRecipient(
                $this->user->bankInfo->account_name,
                $this->user->bankInfo->account_number,
                $this->user->bankInfo->bank_code,
                'NGN'
            );

            if ($response && isset($response['recipient_code'])) {
                $this->user->update(['recipient_code' => $response['recipient_code']]);
            }
            $this->user->refresh();

            // Initialize transfer
            $transferResult = $paystack->initializeTransfer(
                $amount,
                $this->user->recipient_code,
                'Wallet Withdrawal',
                $transaction->reference
            );

            if ($transferResult['status']) {
                Transaction::where(
                    'reference',
                    $transaction->reference
                )->update([
                    'status' => 'success',
                    'amount' => $amount
                ]);

                app(AdminController::class)->fundAdminWallet(
                    $feeAmount,
                    'Wallet Withdrawal from: ' . $this->user->name
                );

                DB::commit();
                return true;
            } else {
                throw new \Exception($transferResult['message'] ?? 'Transfer failed');
            }
        } catch (\Exception $e) {
            DB::rollback();
            Transaction::where('reference', $transaction->reference ?? '')->update(['status' => 'failed']);

            return false;
        }
    }

    public function render()
    {
        $withdrawals = Transaction::where('user_id', Auth::id())
            ->where('transaction_type', 'wallet_withdrawal')
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.user.make-withdrawal', [
            'withdrawals' => $withdrawals,
        ]);
    }
}
