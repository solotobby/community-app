<div class="content">
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div>
        <a href="{{ route('admin.users.details', ['id' => $user->id]) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i>Back to User Details
        </a>
    </div>
    <div class="card shadow-sm border-0">
        <div class="card-header bg-grey d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-gift text-primary me-2"></i>
                {{ $user->name }}'s Raffle Draw Rewards
            </h5>
            <div class="d-flex gap-2 align-items-center">
                <div class="badge bg-info">
                    Total: {{ $user->raffleDraws()->count() }}
                </div>
                <div class="badge bg-success">
                    Claimed: {{ $user->raffleDraws()->where('status', 'earned')->count() }}
                </div>
                <div class="badge bg-warning">
                    Pending: {{ $user->raffleDraws()->where('status', 'pending')->count() }}
                </div>
                <div class="badge bg-danger">
                    Expired: {{ $user->raffleDraws()->where('status', 'expired')->count() }}
                </div>
            </div>
        </div>

        <div class="card-body">
            {{-- Filters --}}
            <div class="row mb-3">
                <div class="col-md-6">
                    <input type="text" class="form-control" placeholder="Search by raffle ID..."
                        wire:model.debounce.300ms="search">
                </div>
                <div class="col-md-6">
                    <select class="form-select" wire:model="statusFilter">
                        <option value="all">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="earned">Claimed</option>
                        <option value="expired">Expired</option>
                    </select>
                </div>
            </div>

            {{-- Table --}}
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" style="width: 50px;">S/N</th>
                            <th>Raffle ID</th>
                            <th>Reward(s)</th>
                            <th>Amount</th>
                            <th>Status</th>
                            {{-- <th>Created At</th> --}}
                            <th>Claimed At</th>
                            <th>Expires At</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($draws as $draw)
                            <tr>
                                <td class="text-center">
                                    {{ $loop->iteration + ($draws->currentPage() - 1) * $draws->perPage() }}
                                </td>
                                <td>
                                    <strong>{{ $draw->name ?? 'RD-#' . $draw->id }}</strong>
                                </td>
                                <td>
                                    @if ($draw->reward)
                                        @php
                                            $rewards = is_string($draw->reward)
                                                ? json_decode($draw->reward, true)
                                                : $draw->reward;
                                        @endphp
                                        @if (is_array($rewards))
                                            <ul class="list-unstyled mb-0">
                                                @foreach ($rewards as $reward)
                                                    <li class="small">
                                                        <i class="fas fa-gift text-primary me-1"></i>
                                                        {{ is_array($reward) ? $reward['name'] ?? 'Unknown' : $reward }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <span class="text-muted">{{ $draw->reward }}</span>
                                        @endif
                                    @else
                                        <span class="text-muted">No rewards specified</span>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-light">{{ $draw->currency }}{{ $draw->price }}</small>
                                </td>
                                <td>
                                    @if ($draw->status === 'pending')
                                        <span class="badge bg-warning">
                                            <i class="fas fa-clock me-1"></i>Pending
                                        </span>
                                    @elseif ($draw->status === 'earned')
                                        <span class="badge bg-success">
                                            <i class="fas fa-check me-1"></i>Claimed
                                        </span>
                                    @else
                                        <span class="badge bg-danger">
                                            <i class="fas fa-times me-1"></i>Expired
                                        </span>
                                    @endif
                                </td>
                                {{-- <td>
                                    <small>{{ $draw->created_at->format('M d, Y') }}</small>
                                    <br>
                                    <small class="text-muted">{{ $draw->created_at->format('H:i') }}</small>
                                </td> --}}
                                <td>
                                    @if ($draw->claimed_at)
                                        <small>{{ $draw->claimed_at->format('M d, Y') }}</small>
                                        <br>
                                        <small class="text-muted">{{ $draw->claimed_at->format('H:i') }}</small>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($draw->status === 'expired' && $draw->expired_at)
                                        <small
                                            class="{{ now()->gt($draw->expired_at) ? 'text-danger' : 'text-warning' }}">
                                            {{ $draw->expired_at->format('M d, Y') }}
                                        </small>
                                        <br>
                                        <small class="text-muted">{{ $draw->expired_at->format('H:i') }}</small>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        @if ($draw->status === 'earned')
                                            <div class="badge bg-success">
                                                Completed
                                            </div>
                                        @endif
                                        @if ($draw->status === 'pending' && $draw->expired_at && now()->lt($draw->expired_at))
                                            <button wire:click="openClaimModal({{ $draw->id }})"
                                                class="btn btn-outline-success" title="Process Claim">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <button wire:click="expireDraw({{ $draw->id }})"
                                                class="btn btn-outline-danger" title="Mark as Expired"
                                                onclick="return confirm('Are you sure you want to mark this draw as expired?')">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-gift fa-3x mb-3"></i>
                                        <p class="mb-0">No raffle draws found for this user.</p>
                                        @if ($search || $statusFilter !== 'all')
                                            <small>Try adjusting your filters.</small>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($draws->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted small">
                        Showing {{ $draws->firstItem() }} to {{ $draws->lastItem() }} of {{ $draws->total() }}
                        results
                    </div>
                    {{ $draws->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- Draw Details Modal --}}
    @if ($showDrawModal && $selectedDraw)
        <div class="modal fade show" style="display: block;" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-gift me-2"></i>
                            Raffle Draw Details
                        </h5>
                        <button type="button" class="btn-close" wire:click="closeDrawModal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label text-muted">Raffle ID</label>
                                <div class="fw-medium">{{ $selectedDraw->name ?? 'RD-' . $selectedDraw->id }}</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted">Status</label>
                                <div>
                                    @if ($selectedDraw->status === 'pending')
                                        <span class="badge bg-warning">Pending</span>
                                    @elseif ($selectedDraw->status === 'earned')
                                        <span class="badge bg-success">Claimed</span>
                                    @else
                                        <span class="badge bg-danger">Expired</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label text-muted">Reward Details</label>
                                @if ($selectedDraw->reward)
                                    @php
                                        $rewards = is_string($selectedDraw->reward)
                                            ? json_decode($selectedDraw->reward, true)
                                            : $selectedDraw->reward;
                                    @endphp
                                    <div class="border rounded p-3 bg-light">
                                        @if (is_array($rewards))
                                            @foreach ($rewards as $reward)
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="fas fa-gift text-primary me-2"></i>
                                                    <span>{{ is_array($reward) ? $reward['name'] ?? 'Unknown' : $reward }}</span>
                                                </div>
                                            @endforeach
                                        @else
                                            <span>{{ $selectedDraw->reward }}</span>
                                        @endif
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted">Created At</label>
                                <div class="fw-medium">{{ $selectedDraw->created_at->format('M d, Y H:i A') }}</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted">Expires At</label>
                                <div class="fw-medium">
                                    {{ $selectedDraw->expired_at ? $selectedDraw->expired_at->format('M d, Y H:i A') : 'No expiry' }}
                                </div>
                            </div>
                            @if ($selectedDraw->claimed_at)
                                <div class="col-md-6">
                                    <label class="form-label text-muted">Claimed At</label>
                                    <div class="fw-medium">{{ $selectedDraw->claimed_at->format('M d, Y H:i A') }}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeDrawModal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    @endif

    {{-- Claim Confirmation Modal --}}
    @if ($showClaimModal && $selectedDraw)
        <div class="modal fade show" style="display: block;" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-check me-2"></i>
                            Process Claim
                        </h5>
                        <button type="button" class="btn-close" wire:click="closeClaimModal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to mark this raffle draw as claimed for
                            <strong>{{ $user->name }}</strong>?
                        </p>
                        <div class="alert alert-info">
                            <strong>Raffle ID:</strong> {{ $selectedDraw->name ?? 'RD-' . $selectedDraw->id }}<br>
                            <strong>User:</strong> {{ $user->name }} ({{ $user->email }})
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeClaimModal">Cancel</button>
                        <button type="button" class="btn btn-success" wire:click="processClaimAsAdmin">
                            <i class="fas fa-check me-1"></i>Process Claim
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    @endif
    <style>
        .table th {
            border-top: none;
            font-weight: 600;
            font-size: 0.875rem;
        }

        .btn-group-sm>.btn {
            padding: 0.25rem 0.5rem;
        }

        .modal.show {
            background: rgba(0, 0, 0, 0.5);
        }
    </style>
</div>
