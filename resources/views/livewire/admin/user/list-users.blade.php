<div class="content">
    @if (session()->has('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition
            class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Users</h3>

            <div class="d-flex align-items-center gap-2">
                <!-- Download CSV Button -->
                <button wire:click="downloadCsv" class="btn btn-success btn-sm">
                    <i class="fa fa-download me-1"></i> Download CSV
                </button>

                <!-- Per-page selector -->
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

        <div class="block-content">
            <!-- Filters Row -->
            <div class="row mb-3">
                <!-- Search -->
                <div class="col-md-3 mb-2">
                    <input type="text" class="form-control" placeholder="Search user with email or name..."
                        wire:model.live.debounce.300ms="search">
                </div>

                <!-- Level Filter -->
                <div class="col-md-2">
                    <select wire:model.live="filterByLevel" class="form-select">
                        <option value="">All Levels</option>
                        @foreach($levels as $level)
                            <option value="{{ $level->id }}">{{ $level->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Filter -->
                <div class="col-md-2">
                    <select wire:model.live="filterByStatus" class="form-select">
                        <option value="">All Status</option>
                        <option value="1">Subscribed</option>
                        <option value="0">Unsubscribed</option>
                        <option value="2">Free Account</option>
                        <option value="3">Blocked</option>
                    </select>
                </div>

                <!-- Clear Filters -->
                <div class="col-md-2">
                    <button class="btn btn-outline-secondary w-100" wire:click="resetFilters" title="Reset Filters">
                            <i class="fas fa-redo"></i>
                        </button>
                </div>
            </div>

            <!-- Results Table -->
            <div class="card-body p-2 table-responsive">
                <table class="table table-bordered table-hover" style="background-color: transparent;">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;">#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Level</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <th class="text-center">
                                    {{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}
                                </th>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->levelInfo?->name ?? 'N/A' }}</td>
                                <td>
                                    @php
                                        if (!$user->status) {
                                            $status = 'Blocked';
                                            $badge = 'bg-danger';
                                        } elseif ($user->has_subscribed) {
                                            $status = 'Subscribed';
                                            $badge = 'bg-success';
                                        } elseif ($user->free_user) {
                                            $status = 'Free Account';
                                            $badge = 'bg-info';
                                        } else {
                                            $status = 'Unsubscribed';
                                            $badge = 'bg-warning';
                                        }
                                    @endphp
                                    <span class="badge {{ $badge }}">{{ $status }}</span>
                                </td>

                                <td>{{ $user->created_at->format('d M, Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.users.details', ['id' => $user->id]) }}"
                                        class="btn btn-sm btn-primary" onclick="event.stopPropagation()">
                                        View
                                    </a>
                                    <a wire:click="confirmBlockModal({{ $user->id }})"
                                        class="btn btn-sm {{ $user->status ? 'btn-outline-danger' : 'btn-outline-success' }}">
                                        {{ $user->status ? 'Block' : 'Unblock' }}
                                        <a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">No users found.</td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>

                <!-- Pagination -->
                @if ($users->hasPages())
                    <div class="mt-3 d-flex justify-content-between align-items-center px-3">
                        <small class="text-muted">
                            Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }}
                            of {{ $users->total() }} results
                            (Page {{ $users->currentPage() }} of {{ $users->lastPage() }})
                        </small>
                        {{ $users->links() }}
                    </div>
                @endif
            </div>
            </table>
        </div>

        <!-- Block User Modal -->
        @if($showBlockModal)
            <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5);">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content shadow theme-sensitive">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                <i class="fa fa-exclamation-triangle text-danger me-2"></i>
                                {{ $isBlocking ? 'Confirm Block' : 'Confirm Unblock' }}
                            </h5>
                            <button type="button" class="btn-close" wire:click="closeBlockModal"></button>
                        </div>
                        <div class="modal-body">
                            <p>
                                Are you sure you want to {{ $isBlocking ? 'block' : 'unblock' }} this user?
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="closeBlockModal">Cancel</button>
                            <button type="button" class="btn {{ $isBlocking ? 'btn-danger' : 'btn-success' }}"
                                wire:click="toggleBlock" wire:loading.attr="disabled">
                                <span wire:loading.remove>
                                    {{ $isBlocking ? 'Block User' : 'Unblock User' }}
                                </span>
                                <span wire:loading>{{ $isBlocking ? 'Blocking...' : 'Unblocking...' }}</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-backdrop fade show"></div>
        @endif

    </div>
