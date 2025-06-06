<?php

namespace App\Livewire\Admin\User;

use Livewire\Component;
use App\Models\User;
use App\Models\Reward;
use Livewire\WithPagination;

class Reffaral extends Component
{
    use WithPagination;

    public $userId;
    public $user;

    protected $paginationTheme = 'bootstrap';

    public function mount($id)
    {
        $this->userId = $id;
        $this->user = User::findOrFail($id);
    }

    public function render()
    {
        $rewards = Reward::with(['user', 'referrer.levelInfo'])
            ->where('user_id', $this->userId)
            ->latest()
            ->paginate(10);


        return view('livewire.admin.user.reffaral', [
            'rewards' => $rewards,
            'user' => $this->user
        ]);
    }
}
