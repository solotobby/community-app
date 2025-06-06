<?php

namespace App\Livewire\Admin\User;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\RaffleDraw as Draw;

class RaffleDraw extends Component
{
    use WithPagination;

    public $user;
    public $statusFilter = 'all';
    public $search = '';
    public $selectedDraw;
    public $showDrawModal = false;
    public $showClaimModal = false;

    protected $paginationTheme = 'bootstrap';

    public function mount($id)
    {
        $this->user = User::findOrFail($id);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function viewDrawDetails($drawId)
    {
        $this->selectedDraw = RaffleDraw::find($drawId);
        $this->showDrawModal = true;
    }

    public function closeDrawModal()
    {
        $this->showDrawModal = false;
        $this->selectedDraw = null;
    }

    public function openClaimModal($drawId)
    {
        $this->selectedDraw = RaffleDraw::find($drawId);
        $this->showClaimModal = true;
    }

    public function closeClaimModal()
    {
        $this->showClaimModal = false;
        $this->selectedDraw = null;
    }

    public function processClaimAsAdmin()
    {
        if ($this->selectedDraw && $this->selectedDraw->status === 'pending') {
            $this->selectedDraw->update([
                'status' => 'earned',
                'claimed_at' => now(),
                'claimed_by_admin' => auth()->id()
            ]);

            session()->flash('success', 'Raffle draw reward claimed successfully for user.');
            $this->closeClaimModal();
        }
    }

    public function expireDraw($drawId)
    {
        $draw = Draw::find($drawId);
        if ($draw && $draw->status === 'pending') {
            $draw->update([
                'status' => 'expired',
                'expired_by_admin' => auth()->id()
            ]);

            session()->flash('success', 'Raffle draw marked as expired.');
        }
    }

    public function render()
    {
        $draws = $this->user->raffleDraws()
            ->when($this->statusFilter !== 'all', function ($query) {
                return $query->where('status', $this->statusFilter);
            })
            ->when($this->search, function ($query) {
                return $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.user.raffle-draw', compact('draws'));
    }
}
