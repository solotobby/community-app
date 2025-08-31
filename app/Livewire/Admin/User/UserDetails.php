<?php

namespace App\Livewire\Admin\User;

use App\Models\User;
use Livewire\Component;

class UserDetails extends Component
{

    public $showBlockModal = false;
    public $selectedUserId = null;
    public $isBlocking = true;
    public $user;
    public function mount($id)
    {
        $this->user = User::with(['bankInfo', 'levelInfo'])->findOrFail($id);
    }
    public function loadItems()
    {
        // $this-> = $this->user->levelItems()->latest()->get();
    }
    public function confirmBlockModal($userId)
    {
        $user = User::findOrFail($userId);
        $this->selectedUserId = $userId;
        $this->isBlocking = $user->status == 1;
        $this->showBlockModal = true;
    }

    public function closeBlockModal()
    {
        $this->reset(['showBlockModal', 'selectedUserId', 'isBlocking']);
    }

    public function toggleBlock()
    {
        $user = User::findOrFail($this->selectedUserId);
        $user->status = $user->status == 1 ? 0 : 1;
        $user->save();

        $user->refresh();
        $this->mount($user->id);

        session()->flash('message', $user->status == 0 ? 'User blocked successfully.' : 'User unblocked successfully.');
        $this->closeBlockModal();
    }

    public function blockUser()
    {
        $user = User::where('id', $this->selectedUserId)->first();

        if ($user) {
            $user->status = $user->status ? 0 : 1;
            $user->save();

            $user->refresh();
            $this->mount($user->id);
            session()->flash('message', $user->status ? 'User unblocked.' : 'User blocked.');
        }

        $this->closeBlockModal();
    }

    public function render()
    {
        return view('livewire.admin.user.user-details');
    }
}
