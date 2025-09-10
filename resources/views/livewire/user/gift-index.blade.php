<div class="content">
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 9999">
        @if (session()->has('message'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition
                class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition
                class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
    </div>

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
                        <button wire:click="createGift" class="btn btn-success btn-sm">
                            <i class="fas fa-plus me-1"></i>Raise Money
                        </button>
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
                        <div class="card h-100 border-0 shadow-sm">
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
                                        <small class="text-muted">₦{{ number_format($gift->target_amount, 2) }}</small>
                                    </div>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar bg-success" style="width: {{ $gift->progress_percentage }}%">
                                        </div>
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
                                            <a href="{{ route('gift.public', $gift->slug) }}"
                                                class="btn btn-outline-primary btn-sm w-100" target="_blank"
                                                rel="noopener noreferrer">
                                                <i class="fas fa-eye me-1"></i> Preview
                                            </a>
                                        </div>
                                        <div class="col">
                                            <a href="{{ route('user.gift.detail', $gift->id) }}"
                                                class="btn btn-primary btn-sm w-100">
                                                <i class="fas fa-edit me-1"></i> Edit
                                            </a>
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
                        <button wire:click="createGift" class="btn btn-success">
                            <i class="fas fa-plus me-2"></i>Raise Money
                        </button>
                    @else
                        <button class="btn btn-outline-secondary" wire:click="resetFilters">
                            <i class="fas fa-redo me-2"></i>Clear Filters
                        </button>
                    @endif

                </div>
            </div>
        @endif
    </div>

    {{-- Contact Information Modal --}}
    @if ($showContactModal)
        <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content shadow theme-sensitive">
                    <form wire:submit.prevent="saveContactInfo">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                <i class="fas fa-address-book text-primary me-2"></i>
                                Complete Your Profile
                            </h5>
                            <button type="button" class="btn-close" wire:click="closeContactModal"></button>
                        </div>
                        <div class="modal-body">
                            <p class="text-muted mb-4">Please complete your contact information to start raising money.</p>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                        wire:model.defer="phone" placeholder="e.g., +234 801 234 5678">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Date of Birth <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('dob') is-invalid @enderror"
                                        wire:model.defer="dob">
                                    @error('dob')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Address <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('address') is-invalid @enderror"
                                    wire:model.defer="address" rows="2" placeholder="Enter your full address"></textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Landmark (Optional)</label>
                                    <input type="text" class="form-control @error('landmark') is-invalid @enderror"
                                        wire:model.defer="landmark" placeholder="e.g., Near City Mall">
                                    @error('landmark')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Local Government Area <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('lga') is-invalid @enderror"
                                        wire:model.defer="lga" placeholder="e.g., Ikeja">
                                    @error('lga')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">State <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('state') is-invalid @enderror"
                                        wire:model.defer="state" placeholder="e.g., Lagos">
                                    @error('state')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Country <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('country') is-invalid @enderror"
                                        wire:model.defer="country" placeholder="e.g., Nigeria">
                                    @error('country')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="closeContactModal">Cancel</button>
                            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="saveContactInfo">Save & Continue</span>
                                <span wire:loading wire:target="saveContactInfo">
                                    <span class="spinner-border spinner-border-sm me-2"></span>Saving...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    {{-- Phone Verification Modal --}}
    @if ($showPhoneVerificationModal)
        <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content shadow theme-sensitive">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-mobile-alt text-primary me-2"></i>
                            Verify Your Phone
                        </h5>
                        <button type="button" class="btn-close" wire:click="closePhoneVerificationModal"></button>
                    </div>
                    <div class="modal-body">
                        @if (!$verification_code_sent)
                            <div class="text-center mb-4">
                                <i class="fas fa-sms fa-3x text-primary mb-3"></i>
                                <p class="mb-2">We'll send a verification code to:</p>
                                <strong class="text-success">{{ $phone }}</strong>
                                <p class="text-muted small mt-2">This helps us keep your account secure.</p>
                            </div>
                            <div class="d-grid">
                                <button class="btn btn-primary btn-lg" wire:click="sendVerificationCode"
                                    wire:loading.attr="disabled">
                                    <span wire:loading.remove wire:target="sendVerificationCode">
                                        <i class="fas fa-paper-plane me-2"></i>Send Code
                                    </span>
                                    <span wire:loading wire:target="sendVerificationCode">
                                        <span class="spinner-border spinner-border-sm me-2"></span>Sending...
                                    </span>
                                </button>
                            </div>
                        @else
                            <form wire:submit.prevent="verifyPhoneNumber">
                                <div class="text-center mb-4">
                                    <i class="fas fa-key fa-3x text-success mb-3"></i>
                                    <p class="mb-2">Enter the 6-digit code sent to:</p>
                                    <strong class="text-success">{{ $phone }}</strong>
                                </div>

                                <div class="mb-4">
                                    <input type="text"
                                        class="form-control form-control-lg text-center @error('verification_code') is-invalid @enderror"
                                        wire:model.defer="verification_code" placeholder="000000" maxlength="6"
                                        style="letter-spacing: 0.5em; font-size: 1.5rem;">
                                    @error('verification_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-success btn-lg" wire:loading.attr="disabled">
                                        <span wire:loading.remove wire:target="verifyPhoneNumber">
                                            <i class="fas fa-check me-2"></i>Verify & Continue
                                        </span>
                                        <span wire:loading wire:target="verifyPhoneNumber">
                                            <span class="spinner-border spinner-border-sm me-2"></span>Verifying...
                                        </span>
                                    </button>

                                    <button type="button" class="btn btn-outline-secondary" wire:click="resendVerificationCode"
                                        wire:loading.attr="disabled">
                                        <span wire:loading.remove wire:target="resendVerificationCode">
                                            <i class="fas fa-redo me-2"></i>Resend Code
                                        </span>
                                        <span wire:loading wire:target="resendVerificationCode">
                                            <span class="spinner-border spinner-border-sm me-2"></span>Resending...
                                        </span>
                                    </button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function () {
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

        .modal-backdrop {
            backdrop-filter: blur(2px);
        }
    </style>
</div>
