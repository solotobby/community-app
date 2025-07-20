<div class="content">
    <div class="content-side content-side-full">
        <!-- Header with Date Filter and Refresh Button -->
        <div class="row mb-4">
            <div class="col-md-6">
                <h4 class="mb-0">Dashboard Statistics</h4>
                <small class="text-muted">
                    Showing data for: {{ $dateFilter > 0 ? $dateFilterOptions[$dateFilter] : 'All Time' }}
                </small>
            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-end gap-2">
                    <select wire:model.live="dateFilter" class="form-select" style="width: auto;">
                        @foreach($dateFilterOptions as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    <button wire:click="refreshStats" class="btn btn-primary">
                        <i class="fa fa-refresh"></i> Refresh
                    </button>
                </div>
            </div>
        </div>

        <!-- User Statistics -->
        <div class="row mb-4">
            <div class="col-15">
                <h5 class="mb-3">
                    <i class="fa fa-users text-primary me-2"></i>User Statistics
                </h5>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                <div class="block block-rounded text-center h-100">
                    <div class="block-content py-3">
                        <p class="fs-2 fw-bold text-primary mb-1">{{ number_format($userStats['total_users']) }}</p>
                        <p class="fw-medium text-muted mb-0">Total Users</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                <div class="block block-rounded text-center h-100">
                    <div class="block-content py-3">
                        <p class="fs-2 fw-bold text-success mb-1">{{ number_format($userStats['verified_users']) }}</p>
                        <p class="fw-medium text-muted mb-0">Verified Users</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                <div class="block block-rounded text-center h-100">
                    <div class="block-content py-3">
                        <p class="fs-2 fw-bold text-info mb-1">{{ number_format($userStats['subscribed_users']) }}</p>
                        <p class="fw-medium text-muted mb-0">Subscribed Users</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                <div class="block block-rounded text-center h-100">
                    <div class="block-content py-3">
                        <p class="fs-2 fw-bold text-warning mb-1">{{ number_format($userStats['free_users']) }}</p>
                        <p class="fw-medium text-muted mb-0">Free Users</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                <div class="block block-rounded text-center h-100">
                    <div class="block-content py-3">
                        <p class="fs-2 fw-bold text-dark mb-1">{{ number_format($userStats['referred_users']) }}</p>
                        <p class="fw-medium text-muted mb-0">Referred Users</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Wallet Statistics -->
        <div class="row mb-4">
            <div class="col-12">
                <h5 class="mb-3">
                    <i class="fa fa-wallet text-success me-2"></i>Wallet Statistics
                </h5>
            </div>

            <div class="col-lg-4 col-md-6 mb-3">
                <div class="block block-rounded text-center h-100">
                    <div class="block-content py-3">
                        <p class="fs-2 fw-bold text-success mb-1">₦{{ number_format($walletStats['total_balance'], 2) }}</p>
                        <p class="fw-medium text-muted mb-0">Total Balance</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-3">
                <div class="block block-rounded text-center h-100">
                    <div class="block-content py-3">
                        <p class="fs-2 fw-bold text-info mb-1">₦{{ number_format($walletStats['total_withdrawable_balance'], 2) }}</p>
                        <p class="fw-medium text-muted mb-0">Withdrawable Balance</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-3">
                <div class="block block-rounded text-center h-100">
                    <div class="block-content py-3">
                        <p class="fs-2 fw-bold text-warning mb-1">₦{{ number_format($walletStats['total_processing_balance'], 2) }}</p>
                        <p class="fw-medium text-muted mb-0">Processing Balance</p>
                    </div>
                </div>
            </div>
             <div class="col-lg-6 col-md-6 mb-3">
                <div class="block block-rounded text-center h-100">
                    <div class="block-content py-3">
                        <p class="fs-2 fw-bold text-primary mb-1">{{ number_format($walletStats['total_wallets']) }}</p>
                        <p class="fw-medium text-muted mb-0">Total Wallets</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 mb-3">
                <div class="block block-rounded text-center h-100">
                    <div class="block-content py-3">
                        <p class="fs-2 fw-bold text-danger mb-1">₦{{ number_format($walletStats['admin_balance'], 2) }}</p>
                        <p class="fw-medium text-muted mb-0">Admin Balance</p>
                    </div>
                </div>
            </div>
            {{-- <div class="col-lg-3 col-md-6 mb-3">
                <div class="block block-rounded text-center h-100">
                    <div class="block-content py-3">
                        <p class="fs-2 fw-bold text-secondary mb-1">{{ number_format($walletStats['new_wallets']) }}</p>
                        <p class="fw-medium text-muted mb-0">New Wallets</p>
                    </div>
                </div>
            </div> --}}
        </div>

        <!-- Level Statistics -->
        <div class="row mb-4">
            <div class="col-12">
                <h5 class="mb-3">
                    <i class="fa fa-layer-group text-info me-2"></i>Level Statistics
                </h5>
            </div>
            <div class="col-lg-3  col-md-6 mb-3">
                <div class="block block-rounded text-center h-100">
                    <div class="block-content py-3">
                        <p class="fs-2 fw-bold text-primary mb-1">{{ number_format($levelStats['total_levels']) }}</p>
                        <p class="fw-medium text-muted mb-0">Total Levels</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="block block-rounded text-center h-100">
                    <div class="block-content py-3">
                        <p class="fs-2 fw-bold text-success mb-1">{{ number_format($levelStats['new_level_upgrades']) }}</p>
                        <p class="fw-medium text-muted mb-0">New Upgrades</p>
                    </div>
                </div>
            </div>
            @foreach($levelStats['users_per_level'] as $userLevel)
            <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                <div class="block block-rounded text-center h-100">
                    <div class="block-content py-3">
                        <p class="fs-3 fw-bold text-secondary mb-1">{{ number_format($userLevel->count) }}</p>
                        <p class="fw-medium text-muted mb-0">Level: {{ $userLevel->levelInfo?->name ?? 'Level ' . $userLevel->level }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Crowdfunding Statistics -->
        <div class="row mb-4">
            <div class="col-12">
                <h5 class="mb-3">
                    <i class="fa fa-gift text-warning me-2"></i>Crowdfunding Statistics
                </h5>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 mb-3">
                <div class="block block-rounded text-center h-100">
                    <div class="block-content py-3">
                        <p class="fs-3 fw-bold text-primary mb-1">{{ number_format($crowdfundingStats['total_gift_requests']) }}</p>
                        <p class="fw-medium text-muted mb-0">Total Gift Requests</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 mb-3">
                <div class="block block-rounded text-center h-100">
                    <div class="block-content py-3">
                        <p class="fs-3 fw-bold text-success mb-1">{{ number_format($crowdfundingStats['active_gift_requests']) }}</p>
                        <p class="fw-medium text-muted mb-0">Active Gift Requests</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 mb-3">
                <div class="block block-rounded text-center h-100">
                    <div class="block-content py-3">
                        <p class="fs-3 fw-bold text-info mb-1">{{ number_format($crowdfundingStats['completed_gift_requests']) }}</p>
                        <p class="fw-medium text-muted mb-0">Completed Gift Requests</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 mb-3">
                <div class="block block-rounded text-center h-100">
                    <div class="block-content py-3">
                        <p class="fs-3 fw-bold text-warning mb-1">{{ number_format($crowdfundingStats['cancelled_gift_requests']) }}</p>
                        <p class="fw-medium text-muted mb-0">Cancelled Gift Requests</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 mb-3">
                <div class="block block-rounded text-center h-100">
                    <div class="block-content py-3">
                        <p class="fs-3 fw-bold text-danger mb-1">{{ number_format($crowdfundingStats['expired_gift_requests']) }}</p>
                        <p class="fw-medium text-muted mb-0">Expired Gift Requests</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 mb-3">
                <div class="block block-rounded text-center h-100">
                    <div class="block-content py-3">
                        <p class="fs-3 fw-bold text-dark mb-1">₦{{ number_format($crowdfundingStats['total_amount_raised'], 2) }}</p>
                        <p class="fw-medium text-muted mb-0">Total Raised</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Transaction Statistics -->
        <div class="row mb-4">
            <div class="col-12">
                <h5 class="mb-3">
                    <i class="fa fa-exchange-alt text-secondary me-2"></i>Transaction Statistics
                </h5>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="block block-rounded text-center h-100">
                    <div class="block-content py-3">
                        <p class="fs-2 fw-bold text-primary mb-1">{{ number_format($transactionStats['total_transactions']) }}</p>
                        <p class="fw-medium text-muted mb-0">Total Transactions</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="block block-rounded text-center h-100">
                    <div class="block-content py-3">
                        <p class="fs-2 fw-bold text-success mb-1">{{ number_format($transactionStats['level_upgrade_transactions']) }}</p>
                        <p class="fw-medium text-muted mb-0">Level Upgrades</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="block block-rounded text-center h-100">
                    <div class="block-content py-3">
                        <p class="fs-2 fw-bold text-info mb-1">{{ number_format($transactionStats['registration_transactions']) }}</p>
                        <p class="fw-medium text-muted mb-0">Registrations</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="block block-rounded text-center h-100">
                    <div class="block-content py-3">
                        <p class="fs-2 fw-bold text-warning mb-1">{{ number_format($transactionStats['withdrawal_transactions']) }}</p>
                        <p class="fw-medium text-muted mb-0">Withdrawals</p>
                    </div>
                </div>
            </div>
              <div class="col-lg-3 col-md-6 mb-3">
                <div class="block block-rounded text-center h-100">
                    <div class="block-content py-3">
                        <p class="fs-2 fw-bold text-warning mb-1">{{ number_format($transactionStats['payout_transactions']) }}</p>
                        <p class="fw-medium text-muted mb-0">Raffle Payouts</p>
                    </div>
                </div>
            </div>
            {{-- <div class="col-lg-3 col-md-6 mb-3">
                <div class="block block-rounded text-center h-100">
                    <div class="block-content py-3">
                        <p class="fs-2 fw-bold text-secondary mb-1">{{ number_format($transactionStats['raffle_draw_claims']) }}</p>
                        <p class="fw-medium text-muted mb-0">Raffle Claims</p>
                    </div>
                </div>
            </div> --}}
        </div>

        <!-- Latest Withdrawal Requests -->
        <div class="row">
            <div class="col-12">
                <div class="block block-rounded">
                    <div class="block-header">
                        <h3 class="block-title">
                            <i class="fa fa-money-bill-wave text-success me-2"></i>
                            Recent Withdrawal Requests
                        </h3>
                    </div>
                    <div class="block-content">
                        <div wire:loading.delay wire:target="refreshStats,dateFilter">
                            <div class="text-center py-4">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="mt-2 text-muted">Refreshing data...</p>
                            </div>
                        </div>
                        <div wire:loading.remove wire:target="refreshStats,dateFilter">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>User</th>
                                            <th>Amount</th>
                                            <th>Reference</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            {{-- <th class="text-center">Actions</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($latestWithdrawals as $withdrawal)
                                        <tr>
                                            <td>
                                                <div>
                                                    <strong class="d-block">{{ $withdrawal->user->name }}</strong>
                                                    <small class="text-muted">{{ $withdrawal->user->email }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                <strong>₦{{ number_format($withdrawal->amount, 2) }}</strong>
                                            </td>
                                            <td>
                                                <code class="bg-light p-1 rounded">{{ $withdrawal->reference }}</code>
                                            </td>
                                            <td>
                                                <span class="badge rounded-pill
                                                    @if($withdrawal->status == 'pending') bg-warning
                                                    @elseif($withdrawal->status == 'success') bg-success
                                                    @elseif($withdrawal->status == 'failed') bg-danger
                                                    @else bg-secondary
                                                    @endif
                                                ">
                                                    {{ ucfirst($withdrawal->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <div>
                                                    <span class="d-block">{{ $withdrawal->created_at->format('M d, Y') }}</span>
                                                    <small class="text-muted">{{ $withdrawal->created_at->format('H:i') }}</small>
                                                </div>
                                            </td>
                                            {{-- <td class="text-center">
                                                <button wire:click="viewTransaction('{{ $withdrawal->id }}')"
                                                       class="btn btn-sm btn-outline-primary">
                                                    <i class="fa fa-eye"></i> View
                                                </button>
                                            </td> --}}
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">
                                                <i class="fa fa-inbox fa-2x mb-2 text-muted"></i>
                                                <p class="mb-0">No withdrawal requests found for the selected period</p>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Auto-refresh indicator -->
    <div wire:loading.remove wire:target="refreshStats" wire:poll.30s="loadDashboardData" class="d-none">
        <!-- Auto-refresh every 30 seconds -->
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('stats-refreshed', () => {
            // Show success notification
            if (typeof toastr !== 'undefined') {
                toastr.success('Dashboard statistics refreshed successfully!');
            } else {
                console.log('Dashboard stats refreshed');
            }
        });
    });
</script>
@endpush
