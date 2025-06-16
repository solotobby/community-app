<?php

namespace App\Livewire\User;

use App\Http\Controllers\PaystackController;
use App\Models\LevelItem;
use App\Models\BankInfo;
use App\Models\RaffleDraw as Raffle;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\WithPagination;

class RaffleDraw extends Component
{
    use WithPagination;
    // Core properties
    public $user;
    public $selectedDraw = null;
    public $bankInfo;

    // Modal states
    public $showClaimModal = false;
    public $showSetPinModal = false;
    public $showBankModal = false;
    public $showContactModal = false;

    // Form fields
    public $pin = '';
    public $new_transaction_pin = '';
    public $new_transaction_pin_confirmation = '';
    public $bank_name = '';
    public $account_name = '';
    public $bank_code = '';
    public $account_number = '';

    // Contact form fields
    public $phone = '';
    public $address = '';
    public $landmark = '';
    public $lga = '';
    public $state = '';
    public $country = '';

    // Cached data
    public $banks = [];

    protected $paginationTheme = 'bootstrap';
    protected $queryString = ['page' => ['except' => 1]];

    // Validation rules
    protected $rules = [
        'new_transaction_pin' => 'required|numeric|digits:4|confirmed',
        'bank_name' => 'required|string',
        'bank_code' => 'required|string',
        'account_name' => 'required|string',
        'account_number' => 'required|string|min:10|max:10',
        'pin' => 'required|string',
        'phone' => 'required|string|max:20',
        'address' => 'required|string|max:255',
        'landmark' => 'nullable|string|max:255',
        'lga' => 'nullable|string|max:255',
        'state' => 'nullable|string|max:255',
        'country' => 'nullable|string|max:255',
    ];

    protected $messages = [
        'new_transaction_pin.confirmed' => 'PIN confirmation does not match.',
        'account_number.min' => 'Account number must be exactly 10 digits.',
        'account_number.max' => 'Account number must be exactly 10 digits.',
    ];

    public function mount()
    {
        $this->user = Auth::user();
        $this->bankInfo = $this->user->bankInfo;
        $this->banks =  $this->fetchBanks();
    }

    /**
     * Get banks with caching for better performance
     */
    public function fetchBanks()
    {
        try {
            $response = Http::withToken(config('services.paystack.secret_key'))
                ->get('https://api.paystack.co/bank');

            if ($response->ok()) {
                $this->banks = $response->json('data');
                return $this->banks;
            } else {
                session()->flash('error', 'Unable to fetch banks from Paystack.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error fetching banks.');
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

    /**
     * Open claim modal and check prerequisites
     */
    public function openClaimModal($drawId)
    {
        $this->selectedDraw = Raffle::findOrFail($drawId);

        Log::info('response', [$this->selectedDraw]);
        // Check if draw is still valid
        if (!$this->isDrawValid($this->selectedDraw)) {
            session()->flash('error', 'This reward has expired or is already claimed.');
            return;
        }

        // Refresh user data
        $this->user = $this->user->fresh();
        $this->bankInfo = $this->user->bankInfo;

        // First check: Address information
        if (!$this->hasContactInfo()) {
            $this->openContactModal();
            return;
        }

        // Second check: Bank information
        if (!$this->bankInfo) {
            $this->showBankModal = true;
            return;
        }

        // Third check: Transaction PIN
        if (!$this->user->transaction_pin) {
            $this->showSetPinModal = true;
            return;
        }

        $this->showClaimModal = true;
    }

    /**
     * Check if user has required contact information
     */
    private function hasContactInfo(): bool
    {
        return !empty($this->user->phone) && !empty($this->user->address);
    }

    /**
     * Check if draw is valid for claiming
     */
    private function isDrawValid(Raffle $draw): bool
    {
        return $draw->status === 'pending' && now()->lte($draw->expired_at);
    }

    /**
     * Contact Information Methods
     */
    public function openContactModal()
    {
        $user = $this->user;
        $this->phone = $user->phone ?? '';
        $this->address = $user->address ?? '';
        $this->landmark = $user->landmark ?? '';
        $this->lga = $user->lga ?? '';
        $this->state = $user->state ?? '';
        $this->country = $user->country ?? '';
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
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
        ]);

        try {
            // Check if phone number changed to reset verification
            if ($this->user->phone != $this->phone) {
                $this->user->update([
                    'phone_verified' => false,
                    'phone_verified_at' => null,
                ]);
            }

            $this->user->update([
                'phone' => $this->phone,
                'address' => $this->address,
                'landmark' => $this->landmark,
                'lga' => $this->lga,
                'state' => $this->state,
                'country' => $this->country
            ]);

            $this->user = $this->user->fresh();
            $this->closeContactModal();

            // Continue with the claim process - check next requirement
            if (!$this->bankInfo) {
                $this->showBankModal = true;
            } elseif (!$this->user->transaction_pin) {
                $this->showSetPinModal = true;
            } else {
                $this->showClaimModal = true;
            }

            session()->flash('success', 'Contact information updated successfully.');
        } catch (\Exception $e) {
            Log::error('Contact info save failed', [
                'user_id' => $this->user->id,
                'error' => $e->getMessage()
            ]);
            session()->flash('error', 'Failed to save contact information. Please try again.');
        }
    }

    /**
     * Perform raffle draw with better error handling
     */
    public function performDraw()
    {
        // Check user eligibility
        if (!$this->user->can_raffle || $this->user->raffle_draw_count < 1) {
            session()->flash('error', 'No draw available.');
            return;
        }

        DB::beginTransaction();
        try {
            // Get available rewards for user's level
            $levelItems = LevelItem::where('level_id', $this->user->level)->get();
            if ($levelItems->isEmpty()) {
                session()->flash('error', 'No rewards configured for your level.');
                return;
            }

            // Create draw record
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

            // Update user's draw count
            $newCount = $this->user->raffle_draw_count - 1;
            $this->user->update([
                'raffle_draw_count' => $newCount,
                'can_raffle' => $newCount > 0,
            ]);

            DB::commit();

            $this->user = $this->user->fresh();
            session()->flash('success', 'Congratulations! You won a reward! Claim within 24 hours.');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Draw creation failed', [
                'user_id' => $this->user->id,
                'error' => $e->getMessage()
            ]);
            session()->flash('error', 'An error occurred while processing your draw.');
        }
    }

    /**
     * Save bank details with validation
     */
    public function saveBankDetails()
    {
        if ($this->bank_code) {
            $selectedBank = collect($this->banks)->firstWhere('code', $this->bank_code);
            $this->bank_name = $selectedBank['name'] ?? '';
        }
        $this->validate([
            'bank_name' => 'required|string',
            'bank_code' => 'required|string',
            'account_name' => 'required|string',
            'account_number' => 'required|string|min:10|max:10',
        ]);

        try {
            BankInfo::updateOrCreate(
                ['user_id' => $this->user->id],
                [
                    'bank_name' => $this->bank_name,
                    'bank_code' => $this->bank_code,
                    'account_name' => $this->account_name,
                    'account_number' => $this->account_number,
                ]
            );

            $this->bankInfo = $this->user->fresh()->bankInfo;
            $this->closeBankModal();

            // Check transaction PIN after saving bank details
            if (!$this->user->transaction_pin) {
                $this->showSetPinModal = true;
            } else {
                $this->showClaimModal = true;
            }

            session()->flash('success', 'Bank details saved successfully!');
        } catch (\Exception $e) {
            Log::error('Bank details save failed', [
                'user_id' => $this->user->id,
                'error' => $e->getMessage()
            ]);
            session()->flash('error', 'Failed to save bank details. Please try again.');
        }
    }

    /**
     * Save transaction PIN
     */
    public function saveTransactionPin()
    {
        $this->validate([
            'new_transaction_pin' => 'required|numeric|digits:4|confirmed',
        ]);

        try {
            $this->user->update([
                'transaction_pin' => Hash::make($this->new_transaction_pin)
            ]);

            $this->user = $this->user->fresh();
            $this->closeSetPinModal();
            $this->showClaimModal = true;

            session()->flash('success', 'Transaction PIN set successfully!');
        } catch (\Exception $e) {
            Log::error('Transaction PIN save failed', [
                'user_id' => $this->user->id,
                'error' => $e->getMessage()
            ]);
            session()->flash('error', 'Failed to set transaction PIN. Please try again.');
        }
    }

    /**
     * Confirm claim with PIN verification
     */
    public function confirmClaim()
    {
        try {
            $this->validateOnly('pin');

            $draw = $this->selectedDraw;

            // Validate draw status
            if (!$this->isDrawValid($draw)) {
                $this->resetClaimProcess();
                session()->flash('error', 'This reward has expired or is already claimed.');
                return;
            }

            // Verify PIN
            if (!Hash::check($this->pin, $this->user->transaction_pin)) {
                $this->resetClaimProcess();
                session()->flash('error', 'Invalid transaction PIN.');
                return;
            }

            // Process payment
            if ($this->processPayment($draw)) {
                $draw->update([
                    'status' => 'earned',
                    'claimed_at' => now(),
                ]);

                $this->resetClaimProcess();
                session()->flash('success', 'Payment has been initiated to your account.');
            } else {
                $this->resetClaimProcess();
                session()->flash('error', 'Error processing payment to your account.');
            }
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Draw creation failed', [
                'user_id' => $this->user->id,
                'error' => $e->getMessage()
            ]);
            session()->flash('error', 'An error occurred while processing your draw.');
        }
    }

    /**
     * Process payment with improved error handling
     */
    private function processPayment($draw): bool
    {
        DB::beginTransaction();
        try {
            $txnReference = 'TXN_' . Str::uuid();

            // Create transaction record
            Transaction::create([
                'reference' => $txnReference,
                'user_id' => $this->user->id,
                'transaction_type' => 'payout',
                'transaction_reason' => 'Raffle Draw Withdrawal',
                'level_id' => $this->user->level,
                'amount' => $draw->price,
                'status' => 'pending',
            ]);

            $paystack = new PaystackController();

            // Create recipient if not exists
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
                $draw->price,
                $this->user->recipient_code,
                'Raffle Draw Withdrawal',
                $txnReference
            );

            if ($transferResult['status']) {
                Transaction::where('reference', $txnReference)->update(['status' => 'success']);
                DB::commit();
                return true;
            } else {
                throw new \Exception($transferResult['message'] ?? 'Transfer failed');
            }
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Payment processing failed', [
                'user_id' => $this->user->id,
                'draw_id' => $draw->id,
                'amount' => $draw->price,
                'error' => $e->getMessage()
            ]);

            // Update transaction status to failed
            Transaction::where('reference', $txnReference ?? '')->update(['status' => 'failed']);

            return false;
        }
    }

    /**
     * Reset claim process states
     */
    private function resetClaimProcess()
    {
        $this->showClaimModal = false;
        $this->pin = '';
    }

    // Modal management methods
    public function closeBankModal()
    {
        $this->showBankModal = false;
        $this->resetBankFields();
    }

    public function closeSetPinModal()
    {
        $this->showSetPinModal = false;
        $this->resetPinFields();
    }

    // Field reset methods
    private function resetBankFields()
    {
        $this->reset(['bank_name', 'account_name', 'account_number', 'bank_code']);
        $this->resetErrorBag(['bank_name', 'account_name', 'account_number', 'bank_code']);
    }

    private function resetPinFields()
    {
        $this->reset(['new_transaction_pin', 'new_transaction_pin_confirmation']);
        $this->resetErrorBag(['new_transaction_pin', 'new_transaction_pin_confirmation']);
    }

    /**
     * Render component with optimized queries
     */
    public function render()
    {
        // Bulk expire old draws
        $this->expireOldDraws();

        // Get user's draws with optimized query
        $draws = Raffle::where('user_id', $this->user->id)
            ->latest()
            ->paginate(10);

        return view('livewire.user.raffle-draw', [
            'availableDraws' => $this->user->raffle_draw_count,
            'draws' => $draws,
        ]);
    }

    /**
     * Expire old draws efficiently
     */
    private function expireOldDraws()
    {
        Raffle::where('user_id', $this->user->id)
            ->where('status', 'pending')
            ->where('expired_at', '<', now())
            ->update(['status' => 'expired']);
    }
}
