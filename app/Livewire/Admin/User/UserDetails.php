<?php

namespace App\Livewire\Admin\User;

use App\Models\User;
use Livewire\Component;

class UserDetails extends Component
{
    public $user;
    public function mount($id)
    {
        $this->user = User::with(['bankInfo', 'levelInfo'])->findOrFail($id);
    }
    public function loadItems()
    {
        // $this-> = $this->user->levelItems()->latest()->get();
    }
    public function render()
    {
        return view('livewire.admin.user.user-details');
    }
}
