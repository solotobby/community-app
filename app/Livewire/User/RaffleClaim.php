<?php

namespace App\Livewire\User;

use App\Models\Level;
use App\Models\LevelItem;
use App\Models\RaffleDraw;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RaffleClaim extends Component
{
    public $drawType;
    public $selectedItems = [];
    public $showConfirmation = false;
    public $showSuccess = false;
    public $errorMessage = null;
    public $raffleDraw;

    public $availableItems;
    public $entryFeeAmount;
    public $referralAmount;

    public $userLevel;
    public $user;
    public function mount()
    {
        $this->drawType = Auth::user()->registration_draw ? 'registration' : 'referral';
        $this->availableItems = LevelItem::all();
        $this->userLevel = Level::findOrFail(Auth::user()->level);
    }

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
        $this->referralAmount = $this->userLevel->referral_bonus;
        $this->entryFeeAmount = $this->userLevel->entry_gift;
        $this->user = Auth::user();

        // Determine draw amount
        $amount = $this->drawType === 'referral'
            ? $this->referralAmount
            : $this->entryFeeAmount;
        if (!$this->user->can_raffle && $this->user->raffle_draw_count === 0) {

            $this->showConfirmation = false;
            $this->showSuccess = false;
            $this->errorMessage = 'You can not play a Raffle Draw as you do not have any slot, kindly upgrade your account or referral more users';
           return;
        };
        $count = $this->drawType === 'referral'
            ? 3
            : rand(4, 7);
        $finalItems = Arr::random($this->selectedItems, min($count, count($this->selectedItems)));
        // Prepare reward data
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
                'user_id'   => $this->user->id,
                'used_type'      => $this->drawType,
                'reward'    => json_encode($rewards),
                'price'    => $amount,
                'expired_at' => now()->addDays(3),
                'currency' => 'NGN',
                'status' => 'pending',
            ]);

            // Update user's draw count
            $newCount = $this->user->raffle_draw_count - 1;
            $this->user->update([
                'raffle_draw_count' => $newCount,
                'can_raffle' => $newCount > 0,
                'registration_draw' => false,
            ]);

            DB::commit();

            $this->showSuccess = true;
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Draw creation failed', [
                'user_id' => $this->user->id,
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
        return view('livewire.user.raffle-claim');
    }
}
