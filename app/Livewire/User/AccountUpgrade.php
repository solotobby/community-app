<?php

namespace App\Livewire\User;

use App\Models\Level;
use App\Models\User;
use App\Models\Transaction;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class AccountUpgrade extends Component
{
    public $showUpgradeModal = false;
    public $selectedLevel = null;
    public $availableLevels = [];
    public $currentUser;

    protected $listeners = ['openUpgradeModal' => 'openModal'];

    public function mount()
    {
        $this->currentUser = Auth::user();
        $this->loadAvailableLevels();
    }

    public function loadAvailableLevels()
    {
        $currentUserLevel = $this->currentUser->level;

        $this->availableLevels = Level::where('registration_amount', '>', $currentUserLevel->registration_amount ?? 0)
            ->orderBy('registration_amount', 'asc')
            ->get();
    }

    public function openModal()
    {
        $this->showUpgradeModal = true;
        $this->loadAvailableLevels();
    }

    public function closeModal()
    {
        $this->showUpgradeModal = false;
        $this->selectedLevel = null;
    }

    public function selectLevel($levelId)
    {
        $this->selectedLevel = Level::find($levelId);
    }

    public function initiateUpgrade()
    {
        if (!$this->selectedLevel) {
            session()->flash('error', 'Please select a level to upgrade to.');
            return;
        }

        // Calculate upgrade cost (difference between levels)
        $currentAmount = $this->currentUser->level->registration_amount ?? 0;
        $upgradeAmount = $this->selectedLevel->registration_amount - $currentAmount;

        if ($upgradeAmount <= 0) {
            session()->flash('error', 'Invalid upgrade selection.');
            return;
        }

        // Create pending transaction
        $transaction = Transaction::create([
            'user_id' => $this->currentUser->id,
            'level_id' => $this->selectedLevel->id,
            'transaction_type' => 'debit',
            'transaction_reason' => 'level_upgrade',
            'amount' => $upgradeAmount,
            'status' => 'pending',
            'reference' => 'TXN_' . Str::upper(Str::random(15)),
            'description' => "Account upgrade to {$this->selectedLevel->name}",
            'metadata' => json_encode([
                'from_level_id' => $this->currentUser->level_id,
                'to_level_id' => $this->selectedLevel->id,
                'upgrade_type' => 'level_upgrade'
            ])
        ]);

        // Initialize Paystack payment
        $paymentUrl = $this->initializePaystackPayment($transaction, $upgradeAmount);

        if ($paymentUrl) {
            // Redirect to Paystack payment page
            return redirect()->away($paymentUrl);
        } else {
            session()->flash('error', 'Failed to initialize payment. Please try again.');
        }
    }

    private function initializePaystackPayment($transaction, $amount)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('paystack.secret_key'),
                'Content-Type' => 'application/json',
            ])->post('https://api.paystack.co/transaction/initialize', [
                'email' => $this->currentUser->email,
                'amount' => $amount * 100, // Convert to kobo
                'reference' => $transaction->reference,
                'callback_url' => route('payment.callback'),
                'metadata' => [
                    'user_id' => $this->currentUser->id,
                    'transaction_id' => $transaction->id,
                    'type' => 'level_upgrade',
                    'level_id' => $this->selectedLevel->id,
                    'custom_fields' => [
                        [
                            'display_name' => 'Transaction Type',
                            'variable_name' => 'transaction_type',
                            'value' => 'Level Upgrade'
                        ],
                        [
                            'display_name' => 'Upgrade To',
                            'variable_name' => 'upgrade_to',
                            'value' => $this->selectedLevel->name
                        ]
                    ]
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['data']['authorization_url'] ?? null;
            }

            return null;
        } catch (\Exception $e) {
            \Log::error('Paystack initialization failed: ' . $e->getMessage());
            return null;
        }
    }

    public function render()
    {
        return view('livewire.user.account-upgrade');
    }
}
