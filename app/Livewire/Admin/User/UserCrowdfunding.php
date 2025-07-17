<?php

namespace App\Livewire\Admin\User;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\GiftRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserCrowdfunding extends Component
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $statusFilter = 'all';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    public $user;
    public $showMyGifts = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => 'all'],
        'sortBy' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
        'showMyGifts' => ['except' => false],
    ];

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


        if ($gift->user_id !== $this->user->id()) {
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

        $newStatus = $gift->is_public === true ? false : true;
        $gift->update(['is_public' => $newStatus]);


        session()->flash('message', "Gift Status Updated successfully.");
        $this->loadGift();
    }

    public function render()
    {
        $query = GiftRequest::with(['user', 'completedContributions'])->where(
            'user_id',
            $this->user->id
        );

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
                $this->user->id
            )->count(),

            'active' => GiftRequest::where(
                'status',
                'active'
            )->where(
                'user_id',
                $this->user->id
            )->count(),

            'completed' => GiftRequest::where(
                'status',
                'completed'
            )->where(
                'user_id',
                $this->user->id
            )->count(),

            'total_raised' => GiftRequest::where(
                'user_id',
                $this->user->id
            )->sum(
                'current_amount'
            ),
        ];

        return view('livewire.admin.user.user-crowdfunding', [
            'gifts' => $gifts,
            'stats' => $stats
        ]);
    }
}
