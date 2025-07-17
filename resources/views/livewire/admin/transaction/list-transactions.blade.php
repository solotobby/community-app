<div class="content">
    @if (session()->has('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)"
             x-show="show" x-transition
             class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(auth()->user()->hasRole('super_admin'))
    <div class="container-fluid p-0 m-0">

        <!-- === Stats Row === -->
        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center">
                        <h6 class="text-muted mb-1">Total Income</h6>
                        <h4 class="text-success mb-0">₦{{ number_format($totalIncome, 2) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center">
                        <h6 class="text-muted mb-1">Total Subscription Income</h6>
                        <h4 class="text-success mb-0">₦{{ number_format($totalSubscriptionIncome, 2) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center">
                        <h6 class="text-muted mb-1">Total Level Upgrade Income</h6>
                        <h4 class="text-success mb-0">₦{{ number_format($totalLevelUpgradeIncome, 2) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center">
                        <h6 class="text-muted mb-1">Total Successful Income Transaction</h6>
                        <h4 class="text-success mb-0">{{ ($totalIncomeTransaction) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center">
                        <h6 class="text-muted mb-1">Total Payout</h6>
                        <h4 class="text-danger mb-0">₦{{ number_format($totalPayout, 2) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center">
                        <h6 class="text-muted mb-1">Total Successful Payout Transaction</h6>
                        <h4 class="text-danger mb-0">{{ $totalPayoutTransaction }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <!-- === /Stats Row === -->
@endif
        <div class="card border-0">
            <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-start gap-2">
                <h5 class="mb-0">User Transactions</h5>

                <!-- Per‑page selector -->
                <div class="d-flex align-items-center">
                    <label class="me-2 mb-0 small text-muted">Per Page:</label>
                    <select wire:model.live="perPage" class="form-select form-select-sm w-auto">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </div>
            </div>

            <div class="card-body p-2 table-responsive">
                <table class="table table-bordered table-hover" style="background-color: transparent;">
                    <thead>
                        <tr>
                            <th class="text-center" style="width:50px;">#</th>
                            <th>User</th>
                            <th>Email</th>
                            <th>Level</th>
                            <th>Type</th>
                            <th>Reason</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                            <tr>
                                <td class="text-center">
                                    {{ $loop->iteration + ($transactions->currentPage() - 1) * $transactions->perPage() }}
                                </td>
                                <td>{{ $transaction->user->name ?? 'N/A' }}</td>
                                <td>{{ $transaction->user->email ?? 'N/A' }}</td>
                                <td>{{ $transaction->level->name ?? ($transaction->user->level?->name ?? 'N/A') }}</td>
                                <td>{{ ucfirst($transaction->transaction_type) }}</td>
                                <td>{{ ucfirst($transaction->transaction_reason) }}</td>
                                <td>₦{{ number_format($transaction->amount, 2) }}</td>
                                <td>
                                    <span class="badge
                                        @if($transaction->status === 'success')  bg-success
                                        @elseif($transaction->status === 'failed') bg-danger
                                        @else bg-warning text-dark @endif">
                                        {{ ucfirst($transaction->status) }}
                                    </span>
                                </td>
                                <td>{{ $transaction->created_at->format('d M, Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted">
                                    @if ($search)
                                        No transactions found matching "{{ $search }}".
                                    @else
                                        No transactions found.
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($transactions->hasPages())
                <div class="mt-3 d-flex justify-content-between align-items-center px-3">
                    <small class="text-muted">
                        Page {{ $transactions->currentPage() }} of {{ $transactions->lastPage() }}
                    </small>
                    {{ $transactions->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
