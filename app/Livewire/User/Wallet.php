<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Wallet as Wallets;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class Wallet extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $user = Auth::user();

        $wallet = Wallets::firstOrCreate(
            ['user_id' => $user->id],
            [
                'balance' => 0,
                'currency' => 'NGN',
            ]
        );

        $totalBalance = $wallet ? $wallet->balance : 0;
        $totalTransactions = Transaction::where('user_id', $user->id)->count();
        $completedTransactions = Transaction::where('user_id', $user->id)
            ->where('status', 'success')
            ->count();
        $pendingTransactions = Transaction::where('user_id', $user->id)
            ->where('status', 'pending')
            ->count();

        // Get paginated transactions
        $transactions = Transaction::where('user_id', $user->id)
            ->with(['user', 'level'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.user.wallet', [
            'wallet' => $wallet,
            'totalBalance' => $totalBalance,
            'totalTransactions' => $totalTransactions,
            'completedTransactions' => $completedTransactions,
            'pendingTransactions' => $pendingTransactions,
            'transactions' => $transactions
        ]);
    }
}
