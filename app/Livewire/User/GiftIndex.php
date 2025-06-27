<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\GiftRequest;
use Illuminate\Support\Facades\Auth;

class GiftIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $statusFilter = 'all';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    public $showMyGifts = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => 'all'],
        'sortBy' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
        'showMyGifts' => ['except' => false],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingShowMyGifts()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['search', 'statusFilter', 'sortBy', 'sortDirection', 'showMyGifts']);
        $this->resetPage();
    }

    public function deleteGift($giftId)
    {
        $gift = GiftRequest::findOrFail($giftId);

        // Check if user owns this gift
        if ($gift->user_id !== Auth::id()) {
            session()->flash('error', 'You can only delete your own gifts.');
            return;
        }

        // Check if gift has contributions
        if ($gift->completedContributions()->count() > 0) {
            session()->flash('error', 'Cannot delete gift with existing contributions.');
            return;
        }

        $gift->delete();
        session()->flash('message', 'Gift deleted successfully.');
    }

    public function toggleStatus($giftId)
    {
        $gift = GiftRequest::findOrFail($giftId);

        // if ($gift->completedContributions()->count() > 0 && $this->gift->status === 'active') {
        //     session()->flash('error', 'Cannot pause gift with existing contributions.');
        //     return;
        // }

        $newStatus = $this->gift->is_public === true ? false : true;
        $this->gift->update(['is_public' => $newStatus]);

        session()->flash('message', "Gift Status Updated successfully.");
        $this->loadGift();

    }

    public function render()
    {
        $query = GiftRequest::with(['user', 'completedContributions'])->where('user_id', Auth::id());

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        // Apply sorting
        $query->orderBy($this->sortBy, $this->sortDirection);

        $gifts = $query->paginate(12);

        // Calculate stats
        $stats = [
            'total' => GiftRequest::where(
                'user_id',
                Auth::id()
            )->count(),

            'active' => GiftRequest::where(
                'status',
                'active'
            )->where(
                'user_id',
                Auth::id()
            )->count(),

            'completed' => GiftRequest::where(
                'status',
                'completed'
            )->where(
                'user_id',
                Auth::id()
            )->count(),

            'total_raised' => GiftRequest::where(
                'user_id',
                Auth::id()
            )->sum(
                'current_amount'
            ),
        ];

        return view('livewire.user.gift-index', [
            'gifts' => $gifts,
            'stats' => $stats
        ]);
    }
}
