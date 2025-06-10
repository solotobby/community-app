<?php

namespace App\Livewire\Admin\Transaction;

use App\Models\Transaction;
use Livewire\Component;
use Livewire\WithPagination;

class ListTransactions extends Component
{
    use WithPagination;

    public $search = '';

    protected $queryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $transactions = Transaction::with(['user.level'])
            ->when($this->search, function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.transaction.list-transactions', [
            'transactions' => $transactions,
        ]);
    }
}
