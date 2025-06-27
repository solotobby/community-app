<div class="container py-4 ">
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

    <div class="row">
        <!-- Main Card -->
        <div class="col-lg-8 mb-2">
            <div class="card shadow-sm">
                @if ($gift->gift_image)
                    <img src="{{ Storage::url($gift->gift_image) }}" class="card-img-top"
                        style="height: 200px; object-fit: cover;">
                @else
                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center"
                        style="height: 200px;">
                        <i class="fas fa-gift fa-3x text-muted"></i>
                    </div>
                @endif

                <div class="card-body">
                    <h1 class="card-title h3">{{ $gift->title }}</h1>

                    @php
                        $reason = ucfirst($gift->reason);
                        $icon = match ($gift->reason) {
                            'birthday' => 'fa-cake-candles',
                            'anniversary' => 'fa-heart',
                            'health' => 'fa-stethoscope',
                            'achievement' => 'fa-award',
                            'appreciation' => 'fa-hands-clapping',
                            'wedding' => 'fa-ring',
                            'new_baby' => 'fa-baby',
                            'condolence' => 'fa-cross',
                            'other' => 'fa-gift',
                            default => 'fa-star',
                        };
                    @endphp

                    <p class="card-text">
                        Gift Purpose:
                        <i class="fas {{ $icon }} me-2 text-primary"></i>
                        {{ $reason }}
                        <br> Expiring in:
                        @if ($gift->deadline->isPast())
                            <small class="text-danger">Expired</small>
                        @else
                            <small class="card-text"><strong>{{ round(now()->diffInRealDays($gift->deadline, true)) }}
                                    day(s)</strong></small>
                        @endif
                        <br> Organized by: {{ $gift->user?->name }}
                    </p>
                    <p class="card-text">{{ $gift->description }}</p>

                    {{-- @if (isset($gift->settings['min_contribution']))
                        <div class="mb-2">
                            <small class="text-muted">Minimum Contribution:</small>
                            <div class="fw-bold">₦{{ number_format($gift->settings['min_contribution'], 2) }}</div>
                        </div>
                    @endif

                    @if (isset($gift->settings['max_contribution']))
                        <div class="mb-2">
                            <small class="text-muted">Maximum Contribution:</small>
                            <div class="fw-bold">₦{{ number_format($gift->settings['max_contribution'], 2) }}</div>
                        </div>
                    @endif --}}

                    <!-- Progress Section -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="h5 mb-0 text-success">₦{{ number_format($gift->current_amount, 2) }}</span>
                            <span class="text-muted">of ₦{{ number_format($gift->target_amount, 2) }}</span>
                        </div>

                        <div class="progress mb-2" style="height: 12px;">
                            <div class="progress-bar bg-success" role="progressbar"
                                style="width: {{ $gift->progress_percentage }}%"></div>
                        </div>

                        <div class="row text-center">
                            <div class="col-4">
                                <small class="text-muted">Progress</small>
                                <div class="fw-bold">{{ round($gift->progress_percentage) }}%</div>
                            </div>
                            <div class="col-4">
                                <small class="text-muted">Contributors</small>
                                <div class="fw-bold">{{ $gift->contributors_count }}</div>
                            </div>
                            <div class="col-4">
                                <small class="text-muted">Remaining</small>
                                <div class="fw-bold">₦{{ number_format($gift->remaining_amount, 2) }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="row">
                        @if ($gift->canReceiveContributions())
                            <div class="col-md-6 mb-2">
                                <button class="btn btn-success btn-lg w-100" disabled>
                                    <i class="fas fa-heart me-2"></i>Gift Now
                                </button>
                            </div>
                        @else
                            <div class="col-md-6 mb-2">
                                <button class="btn btn-secondary btn-lg w-100" disabled>
                                    @if ($gift->current_amount >= $gift->target_amount)
                                        <i class="fas fa-check me-2"></i>Target Reached!
                                    @elseif($gift->is_expired)
                                        <i class="fas fa-clock me-2"></i>Expired
                                    @else
                                        <i class="fas fa-pause me-2"></i>Paused
                                    @endif
                                </button>
                            </div>
                        @endif

                        <div class="col-md-6 mb-2">
                            <div class="dropdown">
                                <button class="btn btn-outline-primary btn-lg w-100 dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown">
                                    <i class="fas fa-share me-2"></i>Share
                                </button>
                                <ul class="dropdown-menu w-100">
                                    <li><a class="dropdown-item" href="#" wire:click="shareGift('facebook')">
                                            <i class="fab fa-facebook me-2"></i>Facebook
                                        </a></li>
                                    <li><a class="dropdown-item" href="#" wire:click="shareGift('twitter')">
                                            <i class="fab fa-twitter me-2"></i>Twitter
                                        </a></li>
                                    <li><a class="dropdown-item" href="#" wire:click="shareGift('whatsapp')">
                                            <i class="fab fa-whatsapp me-2"></i>WhatsApp
                                        </a></li>
                                    <li><a class="dropdown-item" href="#" wire:click="shareGift('telegram')">
                                            <i class="fab fa-telegram me-2"></i>Telegram
                                        </a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="#" wire:click="copyLink">
                                            <i class="fas fa-copy me-2"></i>Copy Link
                                        </a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div> <!-- End card-body -->
            </div> <!-- End card -->
        </div>

        <!-- Sidebar Form -->
        <div class="col-lg-4">
            <div class="mt-4 p-4 border rounded bg-light">
                <h5 class="mb-3">Make a Donation</h5>
                <form wire:submit.prevent="contribute">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="contributor_name" class="form-label">Full Name *</label>
                            <input type="text" class="form-control @error('contributor_name') is-invalid @enderror"
                                id="contributor_name" wire:model="contributor_name" required>
                            @error('contributor_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="contributor_email" class="form-label">Email *</label>
                            <input type="email"
                                class="form-control @error('contributor_email') is-invalid @enderror"
                                id="contributor_email" wire:model="contributor_email" required>
                            @error('contributor_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="amount" class="form-label">
                            Gift Amount (₦) *
                            @if (isset($gift->settings['min_contribution']))
                                <small class="text-muted">(Minimum:
                                    ₦{{ number_format($gift->settings['min_contribution'], 2) }})</small>
                            @endif
                        </label>
                        <input type="number" class="form-control @error('amount') is-invalid @enderror"
                            id="amount" wire:model="amount" min="1" step="0.01" required>
                        @error('amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="is_anonymous" wire:model="is_anonymous">
                        <label class="form-check-label" for="is_anonymous">
                            Make this gift anonymous
                        </label>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            @if ($gift->canReceiveContributions())
                                <button type="submit" class="btn btn-success w-100" wire:loading.attr="disabled">
                                    <span wire:loading.remove>
                                        <i class="fas fa-heart me-2"></i> Gift Now
                                    </span>
                                    <span wire:loading>
                                        <span class="spinner-border spinner-border-sm me-2" role="status"
                                            aria-hidden="true"></span>
                                        Processing...
                                    </span>
                                </button>
                            @else
                                <button class="btn btn-secondary w-100" disabled>
                                    @if ($gift->current_amount >= $gift->target_amount)
                                        <i class="fas fa-check me-2"></i>Target Reached!
                                    @elseif($gift->is_expired)
                                        <i class="fas fa-clock me-2"></i>Expired
                                    @else
                                        <i class="fas fa-pause me-2"></i>Paused
                                    @endif
                                </button>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
