<?php

namespace App\Livewire\Admin\Transaction;

use App\Models\Transaction;
use App\Models\Wallet;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Response;

class ListTransactions extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $filterByType = '';
    public $filterByStatus = '';
    public $dateFrom = '';
    public $dateTo = '';

    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 10],
        'filterByType' => ['except' => ''],
        'filterByStatus' => ['except' => ''],
        'dateFrom' => ['except' => ''],
        'dateTo' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    // Reset page when any filter changes
    public function updatingSearch() { $this->resetPage(); }
    public function updatedSearch() { $this->resetPage(); }
    public function updatingPerPage() { $this->resetPage(); }
    public function updatingFilterByType() { $this->resetPage(); }
    public function updatingFilterByStatus() { $this->resetPage(); }
    public function updatingDateFrom() { $this->resetPage(); }
    public function updatingDateTo() { $this->resetPage(); }

    public function downloadCsv()
    {
        $transactions = $this->getFilteredTransactionsQuery()->get();

        $filename = 'transactions_' . now()->format('Y-m-d_H-i-s') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($transactions) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'ID', 'User Name', 'Email', 'Level', 'Type', 'Reason', 'Amount', 'Status', 'Date'
            ]);

            foreach ($transactions as $transaction) {
                fputcsv($file, [
                    $transaction->id,
                    $transaction->user->name ?? 'N/A',
                    $transaction->user->email ?? 'N/A',
                    $transaction->level->name ?? ($transaction->user->level?->name ?? 'N/A'),
                    ucfirst($transaction->transaction_type),
                    ucfirst($transaction->transaction_reason),
                    $transaction->amount,
                    ucfirst($transaction->status),
                    $transaction->created_at->format('d M, Y H:i'),
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    private function getFilteredTransactionsQuery()
    {
        return Transaction::with(['user.level'])
            ->when($this->search, function ($q) {
                $q->whereHas('user', fn($u) =>
                    $u->where('name', 'like', "%{$this->search}%")
                      ->orWhere('email', 'like', "%{$this->search}%"))
                  ->orWhere('transaction_type', 'like', "%{$this->search}%")
                  ->orWhere('transaction_reason', 'like', "%{$this->search}%")
                  ->orWhere('status', 'like', "%{$this->search}%");
            })
            ->when($this->filterByType, function ($q) {
                $q->where('transaction_type', $this->filterByType);
            })
            ->when($this->filterByStatus, function ($q) {
                $q->where('status', $this->filterByStatus);
            })
            ->when($this->dateFrom, function ($q) {
                $q->whereDate('created_at', '>=', $this->dateFrom);
            })
            ->when($this->dateTo, function ($q) {
                $q->whereDate('created_at', '<=', $this->dateTo);
            })
            ->latest();
    }

    public function render()
    {
        $transactions = $this->getFilteredTransactionsQuery()->paginate($this->perPage);

        // Get unique values for filters
        $transactionTypes = Transaction::distinct()->pluck('transaction_type')->filter();
        $transactionReasons = Transaction::distinct()->pluck('transaction_reason')->filter();
        $statuses = Transaction::distinct()->pluck('status')->filter();

        // Stats - only for successful transactions
        $totalIncome = Transaction::whereIn('transaction_type', ['subscription', 'level_upgrade'])
            ->where('status', 'success')->sum('amount');
        $totalSubscriptionIncome = Transaction::where('transaction_type', 'subscription')
            ->where('status', 'success')->sum('amount');
        $totalLevelUpgradeIncome = Transaction::where('transaction_type', 'level_upgrade')
            ->where('status', 'success')->sum('amount');
        $totalPayout = Transaction::whereIn('transaction_type', ['payout', 'wallet_withdrawal'])
            ->where('status', 'success')->sum('amount');
        $totalIncomeTransaction = Transaction::whereIn('transaction_type', ['subscription', 'level_upgrade'])
            ->where('status', 'success')->count();
        $totalPayoutTransaction = Transaction::where('transaction_type', 'payout')
            ->where('status', 'success')->count();

        $adminBalance = Wallet::firstOrCreate(
            ['user_id' => 0],
            ['balance' => 0, 'user_role' => 'admin']
        );

        return view('livewire.admin.transaction.list-transactions', [
            'transactions' => $transactions,
            'transactionTypes' => $transactionTypes,
            'transactionReasons' => $transactionReasons,
            'statuses' => $statuses,
            'totalIncome' => $totalIncome,
            'totalSubscriptionIncome' => $totalSubscriptionIncome,
            'totalLevelUpgradeIncome' => $totalLevelUpgradeIncome,
            'totalPayout' => $totalPayout,
            'totalIncomeTransaction' => $totalIncomeTransaction,
            'totalPayoutTransaction' => $totalPayoutTransaction,
            'adminBalance' => $adminBalance->balance,
        ]);
    }
}
