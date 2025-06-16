<div class="content">
    @if (session()->has('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition
            class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Transactions</h3>
        </div>
        <div class="block-content">
            <!-- Search -->
            <div class="block pull-t pull-x mb-3">
                <div class="block-content block-content-full block-content-sm bg-body-light">
                    <div class="input-group">
                        <input type="text" wire:model.live.debounce.500ms="search" class="form-control"
                            placeholder="Search by user name or email...">
                        <span class="input-group-text"><i class="fa fa-search"></i></span>
                    </div>
                </div>
            </div>
            <!-- END Search -->

            <!-- Results count -->
            <div class="mb-3">
                <small class="text-muted">
                    Showing {{ $transactions->firstItem() ?? 0 }} to {{ $transactions->lastItem() ?? 0 }}
                    of {{ $transactions->total() }} results
                    @if($search)
                        for "<strong>{{ $search }}</strong>"
                    @endif
                </small>
            </div>

            <div class="table-responsive">
                <table class="table table-borderless table-vcenter">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;">#</th>
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
                                <td>{{ $transaction->level->name ?? $transaction->user->level?->name ?? 'N/A' }}</td>
                                <td>{{ ucfirst($transaction->transaction_type) }}</td>
                                <td>{{ ucfirst($transaction->transaction_reason) }}</td>
                                <td>NGN{{ number_format($transaction->amount, 2) }}</td>
                                <td>
                                    @if ($transaction->status === 'success')
                                        <span class="badge bg-success">Success</span>
                                    @elseif ($transaction->status === 'failed')
                                        <span class="badge bg-danger">Failed</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @endif
                                </td>
                                <td>{{ $transaction->created_at->format('d M, Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted">
                                    @if($search)
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

            <!-- Pagination -->
            @if($transactions->hasPages())
                <div class="mt-4 d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted">
                            Page {{ $transactions->currentPage() }} of {{ $transactions->lastPage() }}
                        </small>
                    </div>
                    <div>
                        {{ $transactions->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
