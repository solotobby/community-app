<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Level;
use App\Models\GiftRequest;
use App\Models\Transaction;
use App\Models\RaffleDraw;
use App\Models\WithdrawalRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AdminDashboard extends Component
{
    public $userStats;
    public $walletStats;
    public $levelStats;
    public $crowdfundingStats;
    public $transactionStats;
    public $latestWithdrawals;
    public $dateFilter = 30;

    public $dateFilterOptions = [
        7 => '7 Days',
        15 => '15 Days',
        30 => '30 Days',
        60 => '60 Days',
        90 => '90 Days',
        0 => 'All Time'
    ];

    public function mount()
    {
        $this->loadDashboardData();
    }

    public function updatedDateFilter()
    {
        $this->loadDashboardData();
    }

    private function getDateQuery($query, $field = 'created_at')
    {
        if ($this->dateFilter > 0) {
            return $query->where($field, '>=', Carbon::now()->subDays($this->dateFilter));
        }
        return $query;
    }

    public function loadDashboardData()
    {
        // User Stats with date filtering
        $userQuery = User::query();
        $this->userStats = [
            'total_users' => $this->getDateQuery(clone $userQuery)->count(),
            'verified_users' => $this->getDateQuery(clone $userQuery)->whereNotNull('email_verified_at')->count(),
            'subscribed_users' => $this->getDateQuery(clone $userQuery)->where('has_subscribed', true)->count(),
            'free_users' => $this->getDateQuery(clone $userQuery)->where('free_user', true)->count(),
            'referred_users' => $this->getDateQuery(clone $userQuery)->whereNotNull('referrer_id')->count(),
        ];

        // Wallet Stats
        $this->walletStats = [
            'total_wallets' => Wallet::count(),
            'total_balance' => Wallet::sum('balance'),
            'total_withdrawable_balance' => Wallet::sum('withdrawable_balance'),
            'total_processing_balance' => Wallet::sum('processing_balance'),
            'admin_balance' => Wallet::where('user_role', 'admin')->where('user_id', 0)->sum('balance'),
        ];

        // Level Stats - Show current distribution but new level assignments in period
        $this->levelStats = [
            'total_levels' => Level::count(),
            'users_per_level' => User::select('level', DB::raw('count(*) as count'))
                ->groupBy('level')
                ->whereNotNull('level')
                ->with('levelInfo')
                ->get()
                ->keyBy('level'),
            'new_level_upgrades' => $this->getDateQuery(Transaction::query())
                ->where('transaction_type', 'level_upgrade')
                ->count(),
        ];

        // Crowdfunding Stats with date filtering
        $giftRequestQuery = GiftRequest::query();
        $this->crowdfundingStats = [
            'total_gift_requests' => $this->getDateQuery(clone $giftRequestQuery)->count(),
            'active_gift_requests' => $this->getDateQuery(clone $giftRequestQuery)->where('status', 'active')->count(),
            'completed_gift_requests' => $this->getDateQuery(clone $giftRequestQuery)->where('status', 'completed')->count(),
            'cancelled_gift_requests' => $this->getDateQuery(clone $giftRequestQuery)->where('status', 'cancelled')->count(),
            'expired_gift_requests' => $this->getDateQuery(clone $giftRequestQuery)->where('deadline', '<=', now())->count(),
            'total_amount_raised' => $this->getDateQuery(clone $giftRequestQuery)->sum('current_amount'),
        ];

        // Transaction Stats with date filtering
        $transactionQuery = Transaction::query();
        $this->transactionStats = [
            'total_transactions' => $this->getDateQuery(clone $transactionQuery)->count(),
            'level_upgrade_transactions' => $this->getDateQuery(clone $transactionQuery)->where('transaction_type', 'level_upgrade')->count(),
            'registration_transactions' => $this->getDateQuery(clone $transactionQuery)->where('transaction_type', 'subscription')->count(),
            'withdrawal_transactions' => $this->getDateQuery(clone $transactionQuery)->where('transaction_type', 'wallet_withdrawal')->count(),
            'payout_transactions' => $this->getDateQuery(clone $transactionQuery)->where('transaction_type', 'payout')->count(),
            // 'raffle_draw_claims' => $this->getDateQuery(RaffleDraw::query())->where('status', 'earned')->count(),
        ];

        // Latest Withdrawal Requests
        $this->latestWithdrawals = Transaction::with(['user'])
            ->where('transaction_type', 'wallet_withdrawal')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
    }

    public function refreshStats()
    {
        $this->loadDashboardData();
        $this->dispatch('stats-refreshed');
    }

    public function render()
    {
        return view('livewire.admin.admin-dashboard');
    }
}
