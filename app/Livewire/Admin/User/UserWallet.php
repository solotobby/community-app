<?php

namespace App\Livewire\Admin\User;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\Wallet as Wallets;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class UserWallet extends Component
{
    use WithPagination;
    public $userId;
    public $user;

    protected $paginationTheme = 'bootstrap';
    public function mount($id)
    {
        $this->userId = $id;
        $this->user = User::findOrFail($id);
    }

    public function render()
    {
        $wallet = Wallets::firstOrCreate(
            ['user_id' => $this->user->id],
            [
                'balance' => 0,
                'currency' => 'NGN',
            ]
        );
        $totalBalance = $wallet ? $wallet->balance : 0;
        $totalTransactions = Transaction::where('user_id', $this->user->id)->count();
        $completedTransactions = Transaction::where('user_id', $this->user->id)
            ->where('status', 'success')
            ->count();
        $pendingTransactions = Transaction::where('user_id', $this->user->id)
            ->where('status', 'pending')
            ->count();

        // Get paginated transactions
        $transactions = Transaction::where('user_id', $this->user->id)
            ->with(['user', 'level'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.user.user-wallet', [
            'wallet' => $wallet,
            'totalBalance' => $totalBalance,
            'totalTransactions' => $totalTransactions,
            'completedTransactions' => $completedTransactions,
            'pendingTransactions' => $pendingTransactions,
            'transactions' => $transactions
        ]);
    }
}
