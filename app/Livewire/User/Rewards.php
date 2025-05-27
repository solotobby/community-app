<?php

namespace App\Livewire\User;

use App\Models\Reward;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Rewards extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $rewards = Reward::with('referrer')->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('livewire.user.rewards', compact('rewards'));
    }
}
