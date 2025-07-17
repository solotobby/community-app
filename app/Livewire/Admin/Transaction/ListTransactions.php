<?php

namespace App\Livewire\Admin\Transaction;

use App\Models\Transaction;
use App\Models\Wallet;
use Livewire\Component;
use Livewire\WithPagination;

class ListTransactions extends Component
{
    use WithPagination;

    public $search   = '';
    public $perPage  = 10;    
    protected $paginationTheme = 'bootstrap';

    /** Persist query in URL */
    protected $queryString = [
        'search'   => ['except' => ''],
        'perPage'  => ['except' => 10],
        'page'     => ['except' => 1],
    ];

    // Reset page when search or perPage changes
    public function updatingSearch()  { $this->resetPage(); }
    public function updatedSearch()   { $this->resetPage(); }
    public function updatingPerPage() { $this->resetPage(); }

    public function render()
    {
        $transactions = Transaction::with(['user.level'])
            ->when($this->search, function ($q) {
                $q->whereHas('user', fn ($u) =>
                        $u->where('name', 'like', "%{$this->search}%")
                          ->orWhere('email', 'like', "%{$this->search}%"))
                  ->orWhere('transaction_type',   'like', "%{$this->search}%")
                  ->orWhere('transaction_reason', 'like', "%{$this->search}%")
                  ->orWhere('status',             'like', "%{$this->search}%");
            })
            ->latest()
            ->paginate($this->perPage);

        // Stats
        $totalIncome  = Transaction::whereIn('transaction_type', ['subscription', 'level_upgrade'])->where('status' , 'success')->sum('amount');
        $totalSubscriptionIncome  = Transaction::where('transaction_type', 'subscription')->where('status' , 'success')->sum('amount');
        $totalLevelUpgradeIncome  = Transaction::where('transaction_type', 'level_upgrade')->where('status' , 'success')->sum('amount');
        $totalPayout  = Transaction::where('transaction_type', 'payout')->where('status' , 'success')->sum('amount');
        $totalIncomeTransaction  = Transaction::whereIn('transaction_type', ['subscription', 'level_upgrade'])->where('status' , 'success')->count();
        $totalPayoutTransaction  = Transaction::where('transaction_type', 'payout')->where('status' , 'success')->count();
        $adminBalance = Wallet::where('user_id', 0)->first();

        return view('livewire.admin.transaction.list-transactions', [
            'transactions' => $transactions,
            'totalIncome'  => $totalIncome,
            'totalSubscriptionIncome'  => $totalSubscriptionIncome,
            'totalLevelUpgradeIncome'  => $totalLevelUpgradeIncome,
            'totalPayout'  => $totalPayout,
            'totalIncomeTransaction'  => $totalIncomeTransaction,
            'totalPayoutTransaction'  => $totalPayoutTransaction,
            'adminBalance' => $adminBalance->balance,
        ]);
    }
}
