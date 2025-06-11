<?php

namespace App\Livewire\User;


use App\Models\Level;
use App\Models\LevelItem;
use App\Models\RaffleDraw;
use App\Models\Reward;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserDashboard extends Component
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
        //$this->availableItems = LevelItem::where('level_id', Auth::user()->level)->get();
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
            // return redirect()->to(url()->current());
            //return redirect()->route(request()->route()->getName()); // refresh page on failure
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
