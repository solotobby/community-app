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

    <!-- Stats Cards -->
    <div class="container-fluid p-0 m-0 mb-4">
        <div class="row">
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card border-0 bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title mb-0">Total Gifts</h6>
                                <h4 class="mb-0">{{ $stats['total'] }}</h4>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-gift fa-2x opacity-75"></i>
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
                                <h6 class="card-title mb-0">Active</h6>
                                <h4 class="mb-0">{{ $stats['active'] }}</h4>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-play-circle fa-2x opacity-75"></i>
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
                                <h6 class="card-title mb-0">Completed</h6>
                                <h4 class="mb-0">{{ $stats['completed'] }}</h4>
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
                                <h6 class="card-title mb-0">Total Raised</h6>
                                <h4 class="mb-0">₦{{ number_format($stats['total_raised'], 2) }}</h4>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-money-bill-wave fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Controls -->
    <div class="container-fluid p-0 m-0 mb-4">
        <div class="card border-0">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h5 class="mb-0">
                            {{ $showMyGifts ? 'My Gifts' : 'All Gifts' }}
                            @auth
                                <span class="badge bg-secondary ms-2">{{ $gifts->total() }}</span>
                            @endauth
                        </h5>
                    </div>
                    <div class="col-md-6 text-end">
                        @auth
                            <a href="{{ route('user.gift.create-gift') }}" class="btn btn-success btn-sm">
                                <i class="fas fa-plus me-1"></i>Create New Gift
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-3 mb-2">
                        <input type="text" class="form-control" placeholder="Search gifts..."
                            wire:model.live.debounce.300ms="search">
                    </div>
                    <div class="col-md-2 mb-2">
                        <select class="form-select" wire:model.live="statusFilter">
                            <option value="all">All Status</option>
                            <option value="active">Active</option>
                            <option value="completed">Completed</option>
                            <option value="expired">Expired</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-2">
                        <select class="form-select" wire:model.live="sortBy">
                            <option value="created_at">Date Created</option>
                            <option value="title">Title</option>
                            <option value="target_amount">Target Amount</option>
                            <option value="current_amount">Amount Raised</option>
                            <option value="deadline">Deadline</option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-2">
                        <select class="form-select" wire:model.live="sortDirection">
                            <option value="desc">Descending</option>
                            <option value="asc">Ascending</option>
                        </select>
                    </div>
                    <div class="col-md-1 mb-2">
                        <button class="btn btn-outline-secondary w-100" wire:click="resetFilters" title="Reset Filters">
                            <i class="fas fa-redo"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gifts Grid -->
    <div class="container-fluid p-0 m-0">
        @if ($gifts->count() > 0)
            <div class="row">
                @foreach ($gifts as $gift)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100 border-0 shadow-sm" style="cursor:pointer;"
                            onclick="window.location='{{ route('user.gift.detail', $gift->id) }}'">
                            @if ($gift->gift_image)
                                <img src="{{ Storage::url($gift->gift_image) }}" class="card-img-top"
                                    style="height: 200px; object-fit: cover;">
                            @else
                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center"
                                    style="height: 200px;">
                                    <i class="fas fa-gift fa-3x text-muted"></i>
                                </div>
                            @endif

                            <div class="card-body d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="card-title mb-0 flex-grow-1 me-2">{{ Str::limit($gift->title, 40) }}
                                    </h6>
                                    <span
                                        class="badge {{ $gift->status === 'active' ? 'bg-success' : ($gift->status === 'completed' ? 'bg-primary' : ($gift->status === 'expired' ? 'bg-warning text-dark' : 'bg-secondary')) }}">
                                        {{ ucfirst($gift->status) }}
                                    </span>
                                </div>

                                <p class="card-text text-muted small mb-3">{{ Str::limit($gift->description, 80) }}
                                </p>

                                <!-- Progress -->
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <small
                                            class="text-success fw-bold">₦{{ number_format($gift->current_amount, 2) }}</small>
                                        <small
                                            class="text-muted">₦{{ number_format($gift->target_amount, 2) }}</small>
                                    </div>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar bg-success"
                                            style="width: {{ $gift->progress_percentage }}%"></div>
                                    </div>
                                    <div class="d-flex justify-content-between mt-1">
                                        <small class="text-muted">{{ round($gift->progress_percentage) }}%
                                            funded</small>
                                        <small class="text-muted">{{ $gift->contributors_count }} contributors</small>
                                    </div>
                                </div>

                                <!-- Gift Info -->
                                <div class="mb-3">
                                    <div class="row text-center">
                                        @if ($gift->deadline)
                                            <div class="col-6">
                                                <small class="text-muted">Deadline</small>
                                                <div class="small fw-bold">{{ $gift->deadline->format('M d, Y') }}
                                                </div>
                                            </div>
                                        @endif
                                        <div class="col-{{ $gift->deadline ? '6' : '12' }}">
                                            <small class="text-muted">Created by</small>
                                            <div class="small fw-bold">{{ $gift->user->name ?? 'Anonymous' }}</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="mt-auto">
                                    <div class="row row-cols-2 g-2">
                                        <div class="col">
                                            <a href="{{ $gift->getPublicUrl() }}"
                                                class="btn btn-primary btn-sm w-100">
                                                <i class="fas fa-eye me-1"></i> Preview
                                            </a>
                                        </div>
                                        <div class="col">
                                            <button class="btn btn-secondary btn-sm w-100"
                                                wire:click="toggleStatus({{ $gift->id }})" title="Toggle Status">
                                                <i
                                                    class="fas fa-{{ $gift->is_public === true ? 'pause' : 'play' }}"></i>
                                                {{ $gift->is_public === true ? 'Pause' : 'Resume' }}
                                            </button>
                                        </div>
                                        <div class="col">
                                            <button class="btn btn-primary btn-sm w-100"
                                                onclick="window.location='{{ route('user.gift.detail', $gift->id) }}'">
                                                <i class="fas fa-edit me-1"></i> Gift Details
                                            </button>
                                        </div>
                                        <div class="col">
                                            <button class="btn btn-info btn-sm w-100"
                                                onclick="copyToClipboard('{{ $gift->getPublicUrl() }}')"
                                                title="Copy Link">
                                                <i class="fas fa-share me-1"></i> Share
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div>
                    <small class="text-muted">
                        Showing {{ $gifts->firstItem() }} to {{ $gifts->lastItem() }} of {{ $gifts->total() }}
                        results
                    </small>
                </div>
                <div>
                    {{ $gifts->links() }}
                </div>
            </div>
        @else
            <div class="card border-0">
                <div class="card-body text-center py-5">
                    <i class="fas fa-gift fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted mb-3">No gifts found</h5>
                    <p class="text-muted">
                        {{-- @if ($showMyGifts)
                            You haven't created any gifts yet.
                        @else
                            No gifts match your current filters.
                        @endif --}}
                    </p>

                    @if (!$showMyGifts)
                        <a href="{{ route('user.gift.create-gift') }}" class="btn btn-success">
                            <i class="fas fa-plus me-2"></i>Create Your First Gift
                        </a>
                    @else
                        <button class="btn btn-outline-secondary" wire:click="resetFilters">
                            <i class="fas fa-redo me-2"></i>Clear Filters
                        </button>
                    @endif

                </div>
            </div>
        @endif
    </div>

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                alert('Link copied to clipboard!');
            });
        }
    </script>

    <style>
        .card:hover {
            transform: translateY(-2px);
            transition: transform 0.2s ease-in-out;
        }

        .progress {
            border-radius: 10px;
        }

        .progress-bar {
            border-radius: 10px;
        }
    </style>

</div>
