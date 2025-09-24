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

    public function createGift()
    {

        return redirect()->route('user.gift.create-gift');
    }

    public function shareGift($platform)
    {
        if (!$this->gift) {
            return;
        }

        $url = urlencode($this->gift->getPublicUrl());
        $text = urlencode('Help contribute to: ' . $this->gift->title);

        $shareUrls = [
            'facebook' => "https://www.facebook.com/sharer/sharer.php?u={$url}",
            'twitter' => "https://twitter.com/intent/tweet?url={$url}&text={$text}",
            'whatsapp' => "https://wa.me/?text={$text}%20{$url}",
            'telegram' => "https://t.me/share/url?url={$url}&text={$text}",
        ];

        if (isset($shareUrls[$platform])) {
            $this->dispatch('openWindow', $shareUrls[$platform]);
        }
    }

     public function copyLink()
    {
        if (!$this->gift) {
            return;
        }

        $this->dispatch('copyToClipboard', $this->gift->getPublicUrl());
        session()->flash('message', 'Link copied to clipboard!');
    }
    private function expirePastGifts(): void
    {
        GiftRequest::where('user_id', Auth::id())
            ->where('status', 'active')
            ->where('deadline', '<', now())
            ->update([
                'status'    => 'expired',
                'is_public' => false,
            ]);
    }

    public function render()
    {
        $this->expirePastGifts();
        $query = GiftRequest::with([
            'user',
            'completedContributions'
        ])->where('user_id', Auth::id());

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
            'total' => GiftRequest::where('user_id', Auth::id())->count(),
            'active' => GiftRequest::where('status', 'active')->where('user_id', Auth::id())->count(),
            'completed' => GiftRequest::where('status', 'completed')->where('user_id', Auth::id())->count(),
            'total_raised' => GiftRequest::where('user_id', Auth::id())->sum('current_amount'),
        ];

        return view('livewire.user.gift-index', [
            'gifts' => $gifts,
            'stats' => $stats
        ]);
    }
}
