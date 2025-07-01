<div class="container py-4">
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

    @if (!$gift || !$gift->is_public)
        <!-- Gift Not Found/Cancelled Section -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm text-center">
                    <div class="card-body py-5">
                        <i class="fas fa-exclamation-triangle fa-4x text-warning mb-4"></i>
                        <h2 class="h3 mb-3">Crowdfunding Not Available</h2>
                        <p class="text-muted mb-4">
                            This crowdfunding campaign cannot be found or has been cancelled by the owner.
                            The campaign may have been removed, made private, or the link may be incorrect.
                        </p>
                        <a href="{{ route('homepage') }}" class="btn btn-primary">
                            <i class="fas fa-home me-2"></i>Go to Homepage
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <!-- Main Card -->
            <div class="col-lg-7 mb-2">
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

                        <!-- Progress Section -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span
                                    class="h5 mb-0 text-success">₦{{ number_format($gift->current_amount, 2) }}</span>
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
                                <!-- Only show share button when contributions are active -->
                                <div class="col-12 mb-2">
                                    <div class="dropdown">
                                        <button class="btn btn-outline-primary btn-lg w-100 dropdown-toggle"
                                            type="button" data-bs-toggle="dropdown">
                                            <i class="fas fa-share me-2"></i>Share This Campaign
                                        </button>
                                        <ul class="dropdown-menu w-100">
                                            <li><a class="dropdown-item" href="#"
                                                    wire:click="shareGift('facebook')">
                                                    <i class="fab fa-facebook me-2"></i>Facebook
                                                </a></li>
                                            <li><a class="dropdown-item" href="#"
                                                    wire:click="shareGift('twitter')">
                                                    <i class="fab fa-twitter me-2"></i>Twitter
                                                </a></li>
                                            <li><a class="dropdown-item" href="#"
                                                    wire:click="shareGift('whatsapp')">
                                                    <i class="fab fa-whatsapp me-2"></i>WhatsApp
                                                </a></li>
                                            <li><a class="dropdown-item" href="#"
                                                    wire:click="shareGift('telegram')">
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
                            @else
                                <!-- Show status button and share button when not active -->
                                <div class="col-md-6 mb-2">
                                    <button class="btn btn-secondary btn-lg w-100" disabled>
                                        @if ($gift->isTargetReached())
                                            <i class="fas fa-check me-2"></i>Target Reached!
                                        @elseif($gift->isExpired())
                                            <i class="fas fa-clock me-2"></i>Expired
                                        @else
                                            <i class="fas fa-pause me-2"></i>Paused
                                        @endif
                                    </button>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <div class="dropdown">
                                        <button class="btn btn-outline-primary btn-lg w-100 dropdown-toggle"
                                            type="button" data-bs-toggle="dropdown">
                                            <i class="fas fa-share me-2"></i>Share
                                        </button>
                                        <ul class="dropdown-menu w-100">
                                            <li><a class="dropdown-item" href="#"
                                                    wire:click="shareGift('facebook')">
                                                    <i class="fab fa-facebook me-2"></i>Facebook
                                                </a></li>
                                            <li><a class="dropdown-item" href="#"
                                                    wire:click="shareGift('twitter')">
                                                    <i class="fab fa-twitter me-2"></i>Twitter
                                                </a></li>
                                            <li><a class="dropdown-item" href="#"
                                                    wire:click="shareGift('whatsapp')">
                                                    <i class="fab fa-whatsapp me-2"></i>WhatsApp
                                                </a></li>
                                            <li><a class="dropdown-item" href="#"
                                                    wire:click="shareGift('telegram')">
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
                            @endif

                        </div>
                    </div> <!-- End card-body -->
                    {{-- Trust Indicators --}}
                    <div class="mt-3 pt-4 border-top px-3 px-md-5">
                        <div class="row align-items-center text-center text-md-start">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <small class="text-muted d-block mb-2">Secured by</small>
                                <div
                                    class="d-flex justify-content-center justify-content-md-start align-items-center gap-3">
                                    <img src="{{ asset('assets/media/photos/paystack.png') }}" alt="Paystack"
                                        style="height: 40px;">
                                    <img src="{{ asset('assets/media/photos/visa.png') }}" alt="Visa"
                                        style="height: 40px;">
                                    <img src="{{ asset('assets/media/photos/mastercard.png') }}" alt="Mastercard"
                                        style="height: 40px;">
                                </div>
                            </div>
                            <div class="col-md-6 text-center text-md-end">
                                <div class="d-flex justify-content-center justify-content-md-end align-items-center">
                                    <i class="fas fa-shield-alt text-success me-2"></i>
                                    <small class="text-muted">SSL Encrypted &amp; PCI Compliant</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>

                </div>
            </div>

            {{-- Enhanced Contribution Sidebar --}}

            <div class="col-lg-5">
                <div class="sticky-top" style="top: 2rem;" id="contribution-section">
                    @if (!$virtual_account || ($payment_method === 'bank_transfer' && $virtual_account))
                        <div class="card shadow border-0 @if ($payment_method === 'bank_transfer' && $virtual_account) d-none @endif"
                            id="contribution-form">
                            <div class="card-header bg-gradient text-white text-center py-3"
                                style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                <h5 class="mb-0">
                                    <i class="fas fa-heart me-2"></i>Make a Contribution
                                </h5>
                            </div>


                            <div class="card-body p-4">
                                {{-- Payment Method Selection --}}
                                <div class="mb-4">
                                    <label class="form-label fw-bold mb-3">Choose Payment Method</label>
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <input class="form-check-input d-none" type="radio"
                                                name="payment_method" id="payment_card" value="card"
                                                wire:model.live="payment_method">
                                            <label class="form-check-label w-100" for="payment_card">
                                                <div
                                                    class="text-center p-3 border rounded-3 h-100 payment-method-option">
                                                    <i class="fas fa-credit-card fa-2x mb-2 text-primary"></i>
                                                    <div class="fw-bold small">Card Payment</div>
                                                    <small class="text-muted">Instant</small>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="col-6">
                                            <input class="form-check-input d-none" type="radio"
                                                name="payment_method" id="payment_transfer" value="bank_transfer"
                                                wire:model.live="payment_method">
                                            <label class="form-check-label w-100" for="payment_transfer">
                                                <div
                                                    class="text-center p-3 border rounded-3 h-100 payment-method-option">
                                                    <i class="fas fa-university fa-2x mb-2 text-success"></i>
                                                    <div class="fw-bold small">Bank Transfer</div>
                                                    <small class="text-muted">Secure</small>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                {{-- Contribution Form --}}
                                <form wire:submit.prevent="contribute">
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label for="contributor_name" class="form-label">Full Name *</label>
                                            <input type="text"
                                                class="form-control @error('contributor_name') is-invalid @enderror"
                                                id="contributor_name" wire:model="contributor_name" required>
                                            @error('contributor_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-12">
                                            <label for="contributor_email" class="form-label">Email Address
                                                *</label>
                                            <input type="email"
                                                class="form-control @error('contributor_email') is-invalid @enderror"
                                                id="contributor_email" wire:model="contributor_email" required>
                                            @error('contributor_email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-12">
                                            <label for="amount" class="form-label">
                                                Contribution Amount (₦) *
                                                @if (isset($gift->settings['min_contribution']))
                                                    <small class="text-muted">(Min:
                                                        ₦{{ number_format($gift->settings['min_contribution'], 0) }})</small>
                                                @endif
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text">₦</span>
                                                <input type="number"
                                                    class="form-control @error('amount') is-invalid @enderror"
                                                    id="amount" wire:model="amount" min="1" step="0.01"
                                                    required>
                                            </div>
                                            @error('amount')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-12">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="is_anonymous"
                                                    wire:model="is_anonymous">
                                                <label class="form-check-label" for="is_anonymous">
                                                    Keep my contribution anonymous
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-12 mt-4">
                                            <button type="submit" class="btn btn-success btn-lg w-100"
                                                wire:loading.attr="disabled"
                                                @if (!$gift->canReceiveContributions()) disabled @endif>

                                                <span wire:loading.remove>
                                                    <i class="fas fa-heart me-2"></i>
                                                    @if ($payment_method === 'bank_transfer')
                                                        Generate Transfer Details
                                                    @else
                                                        Gift Now
                                                    @endif
                                                </span>

                                                <span wire:loading>
                                                    <span class="spinner-border spinner-border-sm me-2"></span>
                                                    Processing...
                                                </span>
                                            </button>
                                        </div>

                                    </div>

                                </form>

                                {{-- Security Notice --}}
                                <div class="alert alert-light border mt-3">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-shield-alt text-primary me-2"></i>
                                        <small class="text-muted">
                                            Your payment is processed securely by our licensed payment partners.
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Bank Transfer Details Card --}}
                        @if ($payment_method === 'bank_transfer' && $virtual_account)
                            <div class="card shadow border-0" id="bank-details">
                                <div class="card-header bg-gradient text-white text-center py-3"
                                    style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                                    <h5 class="mb-0">
                                        <i class="fas fa-university me-2"></i>Transfer Details
                                    </h5>
                                </div>

                                <div class="card-body p-4">
                                    <div class="alert alert-success border-0 mb-4">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-check-circle me-2"></i>
                                            <small><strong>Account Ready!</strong> Complete your transfer using the
                                                details below.</small>
                                        </div>
                                    </div>

                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label class="form-label fw-bold">Account Number</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control fw-bold"
                                                    value="{{ $virtual_account['account_number'] }}" readonly>
                                                <button class="btn btn-outline-primary" type="button"
                                                    onclick="copyToClipboard('{{ $virtual_account['account_number'] }}', this)">
                                                    <i class="fas fa-copy"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label fw-bold">Bank Name</label>
                                            <input type="text" class="form-control"
                                                value="{{ $virtual_account['bank_name'] }}" readonly>
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label fw-bold">Account Name</label>
                                            <input type="text" class="form-control"
                                                value="{{ $virtual_account['account_name'] }}" readonly>
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label fw-bold">Amount to Transfer</label>
                                            <div class="input-group">
                                                <span class="input-group-text">₦</span>
                                                <input type="text" class="form-control fw-bold text-success"
                                                    value="{{ number_format($amount, 2) }}" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="alert alert-warning border-0 my-4">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-clock me-2"></i>
                                            <small><strong>Expires in:</strong> <span id="countdown"
                                                    class="fw-bold">30:00</span> minutes</small>
                                        </div>
                                    </div>

                                    <div class="d-grid gap-2">
                                        <button class="btn btn-success btn-lg" wire:click="verifyBankTransfer">
                                            <i class="fas fa-check me-2"></i>I've Completed the Transfer
                                        </button>
                                        <button class="btn btn-outline-secondary" onclick="window.location.reload()">
                                            <i class="fas fa-arrow-left me-2"></i>Back to Payment Options
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif
                </div>
            </div>
    @endif
    @endif


    <style>
        .bg-gradient {
            background: linear-gradient(135deg, #40af63 0%, #769b82 100%) !important;
        }

        .payment-method-option {
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid #e9ecef !important;
        }

        .payment-method-option:hover {
            border-color: #769b82 !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(96, 153, 110, 0.15);
        }

        input[type="radio"]:checked+label .payment-method-option {
            border-color: #769b82 !important;
            background: linear-gradient(135deg, #f8f9ff 0%, #e3f2fd 100%);
        }

        .progress-bar {
            background: linear-gradient(45deg, #28a745, #20c997) !important;
        }

        .card {
            transition: all 0.3s ease;
            border-radius: 1rem;
        }

        .form-control,
        .input-group-text {
            border-radius: 0.5rem;
        }

        .btn {
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .btn:hover:not(:disabled) {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .sticky-top {
            z-index: 1020;
        }
    </style>


    {{-- <!-- JavaScript for sharing functionality -->
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('openWindow', (url) => {
                window.open(url, '_blank', 'width=600,height=400');
                });

                Livewire.on('copyToClipboard', (text) => {
                    navigator.clipboard.writeText(text).then(() => {
                        // Optional: Show toast notification
                        });
                        });
                        });
                    </script> --}}



</div>
