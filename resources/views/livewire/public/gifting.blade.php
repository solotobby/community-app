<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $gift->title }} - Gift Request</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    @livewireStyles
</head>
<body class="bg-light">
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

        <div class="row">
            <div class="col-lg-8 mb-4">
                <!-- Gift Details Card -->
                <div class="card shadow-sm">
                    @if($gift->gift_image)
                        <img src="{{ Storage::url($gift->gift_image) }}" class="card-img-top" style="height: 300px; object-fit: cover;">
                    @endif

                    <div class="card-body">
                        <h1 class="card-title h3">{{ $gift->title }}</h1>
                        <p class="card-text">{{ $gift->description }}</p>

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
                            @if($gift->canReceiveContributions())
                                <div class="col-md-6 mb-2">
                                    <button class="btn btn-success btn-lg w-100" wire:click="toggleContributeForm">
                                        <i class="fas fa-heart me-2"></i>Contribute Now
                                    </button>
                                </div>
                            @else
                                <div class="col-md-6 mb-2">
                                    <button class="btn btn-secondary btn-lg w-100" disabled>
                                        @if($gift->current_amount >= $gift->target_amount)
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
                                    <button class="btn btn-outline-primary btn-lg w-100 dropdown-toggle" type="button" data-bs-toggle="dropdown">
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
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item" href="#" wire:click="copyLink">
                                            <i class="fas fa-copy me-2"></i>Copy Link
                                        </a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Contribution Form -->
                        @if($showContributeForm)
                            <div class="mt-4 p-4 border rounded bg-light">
                                <h5 class="mb-3">Make a Contribution</h5>
                                <form wire:submit="contribute">
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
                                            <label for="contributor_email" class="form-label">Email (optional)</label>
                                            <input type="email" class="form-control @error('contributor_email') is-invalid @enderror"
                                                   id="contributor_email" wire:model="contributor_email">
                                            @error('contributor_email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="amount" class="form-label">
                                            Contribution Amount (₦) *
                                            @if(isset($gift->settings['min_contribution']) && $gift->settings['min_contribution'])
                                                <small class="text-muted">(Minimum: ₦{{ number_format($gift->settings['min_contribution'], 2) }})</small>
                                            @endif
                                        </label>
                                        <input type="number" class="form-control @error('amount') is-invalid @enderror"
                                               id="amount" wire:model="amount" min="1" step="0.01" required>
                                        @error('amount')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="message" class="form-label">Message (optional)</label>
                                        <textarea class="form-control @error('message') is-invalid @enderror"
                                                  id="message" wire:model="message" rows="3" maxlength="500"
                                                  placeholder="Leave a message of support..."></textarea>
                                        @error('message')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="is_anonymous" wire:model="is_anonymous">
                                        <label class="form-check-label" for="is_anonymous">
                                            Make this contribution anonymous
                                        </label>
                                    </div>

                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-heart me-2"></i>Contribute ₦{{ number_format($amount ?: 0, 2) }}
                                        </button>
                                        <button type="button" class="btn btn-secondary" wire:click="toggleContributeForm">
                                            Cancel
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Gift Info Card -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Gift Information</h6>
                    </div>
                    <div class="card-body">
                        @if($gift->deadline)
                            <div class="mb-2">
                                <small class="text-muted">Deadline:</small>
                                <div class="fw-bold">{{ $gift->deadline->format('M d, Y') }}</div>
                                @if($gift->deadline->isPast())
                                    <small class="text-danger">Expired</small>
                                @else
                                    <small class="text-success">{{ $gift->deadline->diffForHumans() }}</small>
                                @endif
                            </div>
                        @endif

                        <div class="mb-2">
                            <small class="text-muted">Created:</small>
                            <div>{{ $gift->created_at->format('M d, Y') }}</div>
                        </div>

                        @if(isset($gift->settings['min_contribution']) && $gift->settings['min_contribution'])
                            <div class="mb-2">
                                <small class="text-muted">Minimum Contribution:</small>
                                <div class="fw-bold">₦{{ number_format($gift->settings['min_contribution'], 2) }}</div>
                            </div>
                        @endif

                        @if(isset($gift->settings['max_contribution']) && $gift->settings['max_contribution'])
                            <div class="mb-2">
                                <small class="text-muted">Maximum Contribution:</small>
                                <div class="fw-bold">₦{{ number_format($gift->settings['max_contribution'], 2) }}</div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Recent Contributions -->
                @if($recentContributions->count() > 0)
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h6 class="mb-0"><i class="fas fa-users me-2"></i>Recent Contributors</h6>
                        </div>
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                @foreach($recentContributions as $contribution)
                                    <div class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">
                                                    @if($contribution->is_anonymous)
                                                        <i class="fas fa-user-secret me-1"></i>Anonymous
                                                    @else
                                                        {{ $contribution->contributor_name }}
                                                    @endif
                                                </h6>
                                                @if($contribution->message)
                                                    <p class="mb-1 small text-muted">{{ Str::limit($contribution->message, 60) }}</p>
                                                @endif
                                                <small class="text-muted">{{ $contribution->created_at->diffForHumans() }}</small>
                                            </div>
                                            <span class="badge bg-success">₦{{ number_format($contribution->amount, 2) }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @livewireScripts

    <script>
        // Handle sharing windows
        window.addEventListener('openWindow', event => {
            window.open(event.detail, '_blank', 'width=600,height=400');
        });

        // Handle copy to clipboard
        window.addEventListener('copyToClipboard', event => {
            navigator.clipboard.writeText(event.detail).then(() => {
                console.log('Link copied to clipboard');
            });
        });
    </script>
</body>
</html>
