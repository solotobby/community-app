@php
    use App\Models\Level;
@endphp

<div class="content">
    @if (session()->has('message'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <!-- Wallet Stats Section -->
    <div class="container-fluid p-0 m-0 mb-4">
        <div class="row">
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card border-0 bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title mb-0">Total Balance</h6>
                                <h4 class="mb-0">₦{{ number_format($totalBalance, 2) }}</h4>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-wallet fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card border-0 bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title mb-0">Completed</h6>
                                <h4 class="mb-0">{{ $completedTransactions }}</h4>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-check-circle fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card border-0 bg-warning text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title mb-0">Pending</h6>
                                <h4 class="mb-0">{{ $pendingTransactions }}</h4>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-clock fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card border-0 bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title mb-0">Total Transactions</h6>
                                <h4 class="mb-0">{{ $totalTransactions }}</h4>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-exchange-alt fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Transactions Table Section -->
    <div class="container-fluid p-0 m-0">
        <div class="card border-0">
            <div class="card-header">
                <h5 class="mb-0">My Transaction(s)</h5>
            </div>
            <div class="card-body p-2 table-responsive">
                <table class="table table-bordered table-hover" style="background-color: transparent;">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;">S/N</th>
                            <th>Reference</th>
                            <th>Type</th>
                            <th>Reason</th>
                            <th>Level</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $transaction)
                            <tr>
                                <th class="text-center" scope="row">
                                    {{ $loop->iteration + ($transactions->currentPage() - 1) * $transactions->perPage() }}
                                </th>
                                <td>{{ $transaction->reference ?? '-' }}</td>
                                <td>{{ ucfirst($transaction->transaction_type) }}</td>
                                <td>{{ ucwords(str_replace('_', ' ', $transaction->transaction_reason)) }}</td>
                                <td>
                                    @if ($transaction->level)
                                        {{ $transaction->level->name }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>₦{{ number_format($transaction->amount, 2) }}</td>
                                <td>
                                    @php
                                        $status = $transaction->status;
                                        $badgeClass = match ($status) {
                                            'success' => 'bg-success',
                                            'pending' => 'bg-warning text-dark',
                                            'failed' => 'bg-danger',
                                            'cancelled' => 'bg-secondary',
                                            default => 'bg-info',
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">
                                        {{ ucfirst($status) }}
                                    </span>
                                </td>
                                <td>{{ $transaction->created_at->format('M d, Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No transactions found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-3 d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted">
                            Page {{ $transactions->currentPage() }} of {{ $transactions->lastPage() }}
                        </small>
                    </div>
                    <div>
                        {{ $transactions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
