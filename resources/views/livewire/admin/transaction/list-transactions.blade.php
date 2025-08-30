<div class="content">
    @if (session()->has('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition
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
        </div>
    @endif

    <div class="card border-0">
        <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-start gap-2">
            <h5 class="mb-0">User Transactions</h5>

            <div class="d-flex align-items-center gap-2">
                <!-- Download CSV Button -->
                <button wire:click="downloadCsv" class="btn btn-success btn-sm">
                    <i class="fa fa-download me-1"></i> CSV
                </button>

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
        </div>

        <!-- Filters Section -->
        <div class="card-body border-bottom">
            <div class="row g-2 align-items-end">
                <!-- Search -->
                <div class="col-md-3">
                    <input type="text" wire:model.debounce.500ms="search" class="form-control form-control-sm"
                        placeholder="Search transactions...">
                </div>

                <!-- Transaction Type Filter -->
                <div class="col-md-2">
                    <select wire:model.live="filterByType" class="form-select form-select-sm">
                        <option value="">All Types</option>
                        @foreach($transactionTypes as $type)
                            <option value="{{ $type }}">{{ ucfirst(str_replace('_', ' ', $type)) }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Filter -->
                <div class="col-md-2">
                    <select wire:model.live="filterByStatus" class="form-select form-select-sm">
                        <option value="">All Status</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status }}">{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Date Range (From & To) -->
                <div class="col-md-3">
                    <div class="d-flex gap-2">
                        <div>
                            <label for="dateFrom" class="form-label mb-0 small">From</label>
                            <input type="date" id="dateFrom" wire:model.live="dateFrom"
                                class="form-control form-control-sm">
                        </div>
                        <div>
                            <label for="dateTo" class="form-label mb-0 small">To</label>
                            <input type="date" id="dateTo" wire:model.live="dateTo"
                                class="form-control form-control-sm">
                        </div>
                    </div>
                </div>

                <!-- Clear Filters Button -->
                <div class="col-md-2">
                    <button class="btn btn-outline-secondary w-100" wire:click="resetFilters" title="Reset Filters">
                        <i class="fas fa-redo"></i>
                    </button>
                </div>
            </div>

            <!-- Table -->
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
                                <td>
                                    <span class="badge bg-info">
                                        {{ ucfirst(str_replace('_', ' ', $transaction->transaction_type)) }}
                                    </span>
                                </td>
                                <td>{{ ucfirst(str_replace('_', ' ', $transaction->transaction_reason)) }}</td>
                                <td>₦{{ number_format($transaction->amount, 2) }}</td>
                                <td>
                                    <span class="badge
                                    @if($transaction->status === 'success') bg-success
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
                                    @if ($search || $filterByType || $filterByStatus || $filterByReason || $dateFrom || $dateTo)
                                        No transactions found matching the selected filters.
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
                        Showing {{ $transactions->firstItem() ?? 0 }} to {{ $transactions->lastItem() ?? 0 }}
                        of {{ $transactions->total() }} results
                        (Page {{ $transactions->currentPage() }} of {{ $transactions->lastPage() }})
                    </small>
                    {{ $transactions->links() }}
                </div>
            @endif
        </div>

    </div>
