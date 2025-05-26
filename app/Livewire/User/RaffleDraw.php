<?php

namespace App\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\RaffleDraw;

class RaffleDraw extends Component
{
    public $reward;
    public $message;

    public function performDraw()
    {
        $user = Auth::user();

        if (!$user->can_raffle) {
            $this->message = 'You are not eligible for a raffle draw at this time.';
            return;
        }

        // Get level items
        $levelItems = $user->level?->levelItems;

        if ($levelItems->isEmpty()) {
            $this->message = 'No rewards available for your level.';
            return;
        }

        // Pick a random item
        $item = $levelItems->random();

        $this->reward = $item->name; // Assuming `name` column holds reward title

        // Log reward draw
        RaffleDraw::create([
            'user_id' => $user->id,
            'reward' => $this->reward,
        ]);

        // Mark draw used
        $user->can_raffle = false;
        $user->save();

        $this->message = "🎉 Congratulations! You won: {$this->reward}";
    }

    public function render()
    {
        return view('livewire.raffle-draw');
    }
}
