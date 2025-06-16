<?php

namespace App\Livewire\User;

use App\Models\Level;
use App\Models\LevelItem;
use App\Models\RaffleDraw;
use App\Models\Reward;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class UserDashboard extends Component
{
    public $drawType;
    public $selectedItems = [];
    public $showConfirmation = false;
    public $showSuccess = false;
    public $errorMessage = null;
    public $raffleDraw;

    // Account Upgrade Properties
    public $showUpgradeModal = false;
    public $selectedLevel = null;
    public $availableLevels = [];

    public $availableItems;
    public $entryFeeAmount;
    public $referralAmount;

    public $userLevel;
    public $user;

    public function mount()
    {
        $this->drawType = Auth::user()->registration_draw ? 'registration' : 'referral';
        $this->availableItems = LevelItem::all();
        //$this->availableItems = LevelItem::where('level_id', Auth::user()->level)->get();
        $this->userLevel = Level::findOrFail(Auth::user()->level);
        $this->loadAvailableLevels();
    }

    // Account Upgrade Methods
    public function loadAvailableLevels()
    {
        $currentUser = Auth::user();
        $currentUserLevel = $currentUser->level;

        $this->availableLevels = Level::where('registration_amount', '>', $currentUserLevel->registration_amount ?? 0)
            ->orderBy('registration_amount', 'asc')
            ->get();
    }

    public function openUpgradeModal()
    {
        $this->showUpgradeModal = true;
        $this->loadAvailableLevels();
    }

    public function closeUpgradeModal()
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

        $currentUser = Auth::user();

        // Calculate upgrade cost (difference between levels)
        $currentAmount = $currentUser->level->registration_amount ?? 0;
        $upgradeAmount = $this->selectedLevel->registration_amount;

        if ($upgradeAmount <= 0) {
            session()->flash('error', 'Invalid upgrade selection.');
            return;
        }

        // Create pending transaction
        $transaction = Transaction::create([
            'user_id' => $currentUser->id,
            'level_id' => $this->selectedLevel->id,
            'transaction_type' => 'debit',
            'transaction_reason' => 'level_upgrade',
            'amount' => $upgradeAmount,
            'status' => 'pending',
            'reference' => 'TXN_' . Str::upper(Str::random(15)),
            'description' => "Account upgrade to {$this->selectedLevel->name}",
            'metadata' => json_encode([
                'from_level_id' => $currentUser->level,
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
            $this->closeUpgradeModal();
        }
    }

    private function initializePaystackPayment($transaction, $amount)
    {
        try {
            $currentUser = Auth::user();

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.paystack.secret_key'),
                'Content-Type' => 'application/json',
            ])->post('https://api.paystack.co/transaction/initialize', [
                'email' => $currentUser->email,
                'amount' => $amount * 100,
                'reference' => $transaction->reference,
                'callback_url' => route('user.paystack.upgrade.callback'),
                'metadata' => [
                    'user_id' => $currentUser->id,
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

    // Original Draw Methods
    public function selectItem($itemId)
    {
        if (in_array($itemId, $this->selectedItems)) {
            $this->selectedItems = array_diff($this->selectedItems, [$itemId]);
        } elseif (count($this->selectedItems) < 7) {
            $this->selectedItems[] = $itemId;
        }
    }

    public function confirmSelection()
    {
        if (count($this->selectedItems) < 4) {
            $this->errorMessage = 'Please select at least 4 items.';
            return;
        }

        $this->errorMessage = null;
        $this->showConfirmation = true;
    }

    public function processRaffleDraw()
    {
        $this->showConfirmation = false;
        $user = Auth::user();

        if (!$user->can_raffle && $user->raffle_draw_count === 0) {
            $this->showSuccess = false;
            session()->flash('error', 'You cannot play a Raffle Draw as you do not have any slot. Kindly upgrade your account or refer more users.');

            return redirect(request()->header('Referer') ?? url()->current());
        }

        if ($this->drawType === 'referral') {
            $referral = Reward::where('user_id', $user->id)
                ->where('reward_status', 'pending')
                ->first();

            if (!$referral) {
                session()->flash('error', 'No available referrals to use for raffle draw.');
                 return redirect(request()->header('Referer') ?? url()->current());
            }

            Log::info($referral);
            $amount = $referral->amount;
        } else {
            $amount = $this->userLevel->entry_gift;
        }

        $count = $this->drawType === 'referral' ? 3 : rand(4, 7);
        $finalItems = Arr::random($this->selectedItems, min($count, count($this->selectedItems)));

        $rewards = LevelItem::whereIn('id', $finalItems)->get()->map(function ($item) {
            return [
                'name' => $item->item_name,
                'image' => $item->item_image,
            ];
        });

        DB::beginTransaction();
        try {
            // Save draw record
            $this->raffleDraw = RaffleDraw::create([
                'user_id'   => $user->id,
                'used_type' => $this->drawType,
                'reward'    => json_encode($rewards),
                'price'     => $amount,
                'expired_at' => now()->addDays(3),
                'currency'  => 'NGN',
                'status'    => 'pending',
            ]);

            // If referral, mark as earned
            if ($this->drawType === 'referral' && isset($referral)) {
                $referral->update([
                    'reward_status' => 'earned',
                    'is_claim' => true,
                ]);
            }

            // Update user's draw count
            $newCount = $user->raffle_draw_count - 1;
            $user->update([
                'raffle_draw_count' => $newCount,
                'can_raffle' => $newCount > 0,
                'registration_draw' => false,
            ]);

            DB::commit();
            $this->showSuccess = true;
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Draw creation failed', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            session()->flash('error', 'An error occurred while processing your draw.');
        }
    }

    public function resetDraw()
    {
        $this->selectedItems = [];
        $this->showConfirmation = false;
        $this->showSuccess = false;
        $this->errorMessage = null;
        $this->raffleDraw = null;
    }

    public function getSelectedItemsCount()
    {
        return count($this->selectedItems);
    }

    public function render()
    {
        return view('livewire.user.user-dashboard');
    }
}
