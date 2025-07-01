<?php

namespace App\Livewire\Admin\Crowdfunding;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\GiftRequest;

class Crowdfunding extends Component
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
    ];

    public function updatingSearch() { $this->resetPage(); }
    public function updatingStatusFilter() { $this->resetPage(); }

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
        $this->reset(['search', 'statusFilter', 'sortBy', 'sortDirection']);
        $this->resetPage();
    }

    public function deleteGift($giftId)
    {
        $gift = GiftRequest::findOrFail($giftId);

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

        $gift->update(['is_public' => !$gift->is_public]);

        session()->flash('message', "Gift Status Updated successfully.");
    }

    public function render()
    {
        $query = GiftRequest::with(['user', 'completedContributions']);

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        $query->orderBy($this->sortBy, $this->sortDirection);

        $gifts = $query->paginate(12);

        $stats = [
            'total' => GiftRequest::count(),
            'active' => GiftRequest::where('status', 'active')->count(),
            'completed' => GiftRequest::where('status', 'completed')->count(),
            'total_raised' => GiftRequest::sum('current_amount'),
        ];

        return view('livewire.admin.crowdfunding.crowdfunding', [
            'gifts' => $gifts,
            'stats' => $stats
        ]);
    }
}
