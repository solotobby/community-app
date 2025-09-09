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

    <!-- Header Actions -->
    <div class="container-fluid p-0 m-0 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <a href="{{ route('user.gift.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Back to Gifts
                </a>
            </div>
            <div class="d-flex align-items-center gap-2">

                <span class="badge fs-6 {{ $gift->status === 'active'
    ? 'bg-success'
    : ($gift->status === 'completed'
        ? 'bg-primary'
        : ($gift->status === 'paused'
            ? 'bg-warning text-dark'
            : 'bg-secondary')) }}">
                    {{ ucfirst($gift->status) }}
                </span>
            </div>
        </div>
    </div>

    <!-- Gift Details Card -->
    <div class="container-fluid p-0 m-0 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="row g-0">
                <!-- Gift Image -->
                <div class="col-md-4">
                    @if ($gift->gift_image)
                        <img src="{{ Storage::url($gift->gift_image) }}" class="img-fluid rounded-start h-100"
                            style="object-fit: cover; min-height: 300px;">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center rounded-start h-100"
                            style="min-height: 300px;">
                            <i class="fas fa-gift fa-5x text-muted"></i>
                        </div>
                    @endif
                </div>

                <!-- Gift Info -->
                <div class="col-md-8">
                    <div class="card-body h-100 d-flex flex-column">
                        <div class="flex-grow-1">
                            <h2 class="card-title mb-3">{{ $gift->title }}</h2>
                            <h6 class="text-muted mb-3">
                                <i class="fas fa-calendar-alt me-1"></i>
                                {{ ucfirst($gift->reason) }}
                            </h6>
                            <p class="text-muted">{{ $gift->description }}</p>

                            <!-- Progress Section -->
                            <div class="mb-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <h4 class="text-success mb-0">₦{{ number_format($gift->current_amount, 2) }}</h4>
                                    <span class="text-muted">of ₦{{ number_format($gift->target_amount, 2) }}</span>
                                </div>
                                <div class="progress mb-2" style="height: 12px;">
                                    <div class="progress-bar bg-success"
                                        style="width: {{ $stats['progress_percentage'] }}%"></div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <small class="text-muted">{{ round($stats['progress_percentage']) }}%
                                        funded</small>
                                    <small class="text-muted">{{ $stats['total_contributors'] }} contributors</small>
                                </div>
                            </div>

                            <!-- Gift Meta Info -->
                            <div class="row mb-4">
                                <div class="col-sm-6 text-muted mb-2">
                                    <strong>Created:</strong> {{ $gift->created_at->format('M d, Y') }}
                                </div>
                                @if ($gift->deadline)
                                    <div class="col-sm-6 text-muted mb-2">
                                        <strong>Deadline:</strong> {{ $gift->deadline->format('M d, Y') }}
                                        @if ($gift->deadline->isPast())
                                            <span class="badge bg-danger ms-1">Expired</span>
                                        @endif
                                    </div>
                                @endif
                                <div class="col-sm-6 text-muted mb-2">
                                    <strong>Visibility:</strong> {{ $gift->is_public ? 'Public' : 'Private' }}
                                </div>
                                <div class="col-sm-6 text-muted mb-2">
                                    <strong>Total Contributions:</strong> {{ $stats['total_contributions'] }}
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        @php
                            $isDisabled = in_array($gift->status, ['completed', 'expired', 'canceled']);
                        @endphp

                        <div class="mt-auto">
                            <div class="row g-2">
                                <div class="col-12 col-md-3">
                                    <button class="btn btn-primary w-100 mb-2 mb-md-0" wire:click="openEditModal"
                                        @disabled($isDisabled)>
                                        <i class="fa-solid fa-pen-to-square me-1"></i> Edit
                                    </button>
                                </div>
                                <div class="col-12 col-md-3">
                                    <button
                                        class="btn btn-{{ $gift->is_public ? 'warning' : 'success' }} w-100 mb-2 mb-md-0"
                                        wire:click="toggleStatus" @disabled($isDisabled)>
                                        <i class="fa-solid fa-{{ $gift->is_public ? 'pause' : 'play' }} me-1"></i>
                                        {{ $gift->is_public ? 'Pause' : 'Resume' }}
                                    </button>
                                </div>
                                <div class="col-12 col-md-3">
                                    <div class="dropdown w-100 mb-2 mb-md-0">
                                        <button class="btn btn-primary w-100 dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown" @disabled($isDisabled)>
                                            <i class="fa-solid fa-share me-2"></i> Share
                                        </button>
                                        <ul class="dropdown-menu w-100">
                                            <li><a class="dropdown-item" href="#" wire:click="shareGift('facebook')"><i
                                                        class="fab fa-facebook me-2"></i>Facebook</a></li>
                                            <li><a class="dropdown-item" href="#" wire:click="shareGift('twitter')"><i
                                                        class="fab fa-twitter me-2"></i>Twitter</a></li>
                                            <li><a class="dropdown-item" href="#" wire:click="shareGift('whatsapp')"><i
                                                        class="fab fa-whatsapp me-2"></i>WhatsApp</a></li>
                                            <li><a class="dropdown-item" href="#" wire:click="shareGift('telegram')"><i
                                                        class="fab fa-telegram me-2"></i>Telegram</a></li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li><a class="dropdown-item" href="#" wire:click="copyLink"><i
                                                        class="fa-solid fa-copy me-2"></i>Copy Link</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-12 col-md-3">
                                    <button class="btn btn-danger w-100 mb-2 mb-md-0" wire:click="openEndModal"
                                        @disabled($isDisabled)>
                                        <i class="fa-solid fa-stop me-2"></i> End
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="container-fluid p-0 m-0 mb-4">
        <div class="row">
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card border-0 bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title mb-0">Total Raised</h6>
                                <h4 class="mb-0">₦{{ number_format($gift->current_amount, 2) }}</h4>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-money-bill-wave fa-2x opacity-75"></i>
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
                                <h6 class="card-title mb-0">Contributions</h6>
                                <h4 class="mb-0">{{ $stats['total_contributions'] }}</h4>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-users fa-2x opacity-75"></i>
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
                                <h6 class="card-title mb-0">Avg. Contribution</h6>
                                <h4 class="mb-0">₦{{ number_format($stats['average_contribution'], 2) }}</h4>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-chart-line fa-2x opacity-75"></i>
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
                                <h6 class="card-title mb-0">Progress</h6>
                                <h4 class="mb-0">{{ round($stats['progress_percentage']) }}%</h4>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-percentage fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Contributions -->
    @if ($contributions->count() > 0)
        <div class="container-fluid p-0 m-0 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Recent Contributions</h5>

                    <button class="btn btn-success btn-sm" wire:click="openSmsModal">
                        <i class="fas fa-sms me-1"></i> Send Thank You Message
                        {{-- <span class="badge bg-light text-success ms-1">
                            {{ $eligibleContributors->count() }}
                        </span> --}}
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Contributor</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Message</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($contributions as $contribution)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-2"
                                                    style="width: 32px; height: 32px;">
                                                    <i class="fas fa-user text-white small"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-bold">
                                                        {{ $contribution->is_anonymous ? 'Anonymous' : $contribution->contributor_name }}
                                                    </div>

                                                    @if ($contribution->is_anonymous)
                                                        <small class="text-muted">Anonymous</small>
                                                    @else
                                                        @php
                                                            // Mask email (keep first 2 chars + domain, replace middle with ***)
                                                            $email = $contribution->contributor_email;
                                                            $phone = $contribution->contributor_phone;
                                                            $maskedEmail = preg_replace(
                                                                '/(^.{5})(.*)(@.*)$/',
                                                                '$1***$3',
                                                                $email
                                                            );
                                                            $maskedPhone = preg_replace('/(\d{5})\d+(\d{3})/', '$1***$2', $phone);
                                                        @endphp
                                                        <small class="text-muted">
                                                            {{ $maskedEmail }}
                                                            @if(!empty($maskedPhone))
                                                                | {{ $maskedPhone }}
                                                            @endif
                                                        </small>

                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-success">₦{{ number_format($contribution->amount, 2) }}</span>
                                        </td>
                                        <td>{{ $contribution->created_at->format('M d, Y') }}</td>
                                        <td>{{ $contribution->message ?: '-' }}</td>
                                    </tr>

                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- SMS Appreciation Modal -->
    @if ($showSmsModal)
        <div class="modal fade show d-block" style="background: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content theme-sensitive border-0 shadow-lg">
                    <div class="modal-header bg-gradient-success text-white border-0">
                        <h5 class="modal-title">
                            <i class="fas fa-sms me-2"></i>Send SMS Appreciation
                        </h5>
                        <button type="button" class="btn-close btn-close-white" wire:click="closeSmsModal"></button>
                    </div>
                    <form wire:submit.prevent="sendSmsAppreciation">
                        <div class="modal-body">
                            <div class="row">
                                <!-- Left Side - Recipients -->
                                <div class="col-md-6">
                                    <h6 class="mb-3">
                                        <i class="fas fa-users me-2"></i>Recipients
                                        <span class="badge bg-primary">{{ $eligibleContributors->count() }} eligible</span>
                                    </h6>

                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Only contributors with ₦10,000+ donations are eligible.
                                    </div>

                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" wire:model.live="sendToAll"
                                            wire:click="toggleSelectAll" id="sendToAll">
                                        <label class="form-check-label fw-bold" for="sendToAll">
                                            Send to all eligible contributors
                                        </label>
                                    </div>

                                    <div class="border rounded p-3" style="max-height: 300px; overflow-y: auto;">
                                        @forelse($eligibleContributors as $contributor)
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" value="{{ $contributor->id }}"
                                                    wire:model.live="selectedContributors"
                                                    id="contributor_{{ $contributor->id }}">
                                                <label class="form-check-label" for="contributor_{{ $contributor->id }}">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <strong>{{ $contributor->is_anonymous ? 'Anonymous' : $contributor->contributor_name }}</strong>
                                                            <br>
                                                            <small class="text-muted">
                                                                ₦{{ number_format($contributor->amount, 2) }}
                                                                @if($contributor->sms_sent_at)
                                                                    <span class="badge bg-success ms-1">SMS Sent</span>
                                                                @endif
                                                            </small>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                        @empty
                                            <div class="text-center text-muted py-4">
                                                <i class="fas fa-inbox fa-3x mb-3"></i>
                                                <p>No eligible contributors found.</p>
                                            </div>
                                        @endforelse
                                    </div>

                                    @if(!$sendToAll && count($selectedContributors) > 0)
                                        <div class="mt-2">
                                            <small class="text-success">
                                                <i class="fas fa-check-circle me-1"></i>
                                                {{ count($selectedContributors) }} recipient(s) selected
                                            </small>
                                        </div>
                                    @endif

                                    @error('selectedContributors')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Right Side - Message -->
                                <div class="col-md-6">
                                    <h6 class="mb-3">
                                        <i class="fas fa-comment-dots me-2"></i>Message Template
                                    </h6>

                                    <div class="mb-3">
                                        <label class="form-label">Choose Template</label>
                                        <select class="form-select" wire:model.live="messageTemplate">
                                            @foreach($this->getMessageTemplates() as $index => $template)
                                                <option value="{{ $index }}">Template {{ $index + 1 }}</option>
                                            @endforeach
                                            {{-- <option value="custom">Custom Message</option> --}}
                                        </select>
                                    </div>

                                    @if($messageTemplate === 'custom')
                                        <div class="mb-3">
                                            <label class="form-label">Custom Message</label>
                                            <textarea class="form-control" wire:model.live="customMessage" rows="4"
                                                maxlength="160" placeholder="Write your custom message..."></textarea>
                                            <small class="text-muted">
                                                Use {name} and {amount} as placeholders
                                            </small>
                                        </div>
                                    @endif

                                    <div class="mb-3">
                                        <label class="form-label">Message Preview</label>
                                        <div class="border rounded p-3">
                                            <div class="d-flex justify-content-between mb-2">
                                                <small class="text-muted">Preview:</small>
                                                <small class="text-muted">
                                                    {{ strlen($smsMessage) }}/160 characters
                                                </small>
                                            </div>
                                            <div class="fw-bold">
                                                {{ str_replace(['{name}', '{amount}'], ['John Doe', '15,000'], $smsMessage) }}
                                            </div>
                                        </div>
                                        @error('smsMessage')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- <div class="alert alert-warning">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        <strong>SMS Charges Apply:</strong> Standard SMS rates will be charged for each
                                        message sent.
                                    </div> --}}
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="closeSmsModal">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-success" @if($eligibleContributors->count() === 0 || (!$sendToAll && count($selectedContributors) === 0) || empty($smsMessage)) disabled @endif>
                                <i class="fas fa-paper-plane me-1"></i>
                                Send SMS
                                @if($sendToAll)
                                    ({{ $eligibleContributors->count() }} recipients)
                                @elseif(count($selectedContributors) > 0)
                                    ({{ count($selectedContributors) }} recipients)
                                @endif
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Edit Modal -->
    @if ($showEditModal)
        <div class="modal fade show d-block" style="background: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content theme-sensitive border-0 shadow-lg">
                    <div
                        class="modal-header bg-gradient-success text-white text-center border-0 position-relative overflow-hidden">
                        <h5 class="modal-title">Edit Gift</h5>
                        <button type="button" class="btn-close" wire:click="closeEditModal"></button>
                    </div>
                    <form wire:submit.prevent="updateGift">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><strong>Title *</strong></label>
                                    <input type="text" class="form-control" wire:model="title" disabled>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><strong>Reason *</strong></label>
                                    <select class="form-select" wire:model="reason" disabled>
                                        <option value="">Select Reason</option>
                                        <option value="Birthday">Birthday</option>
                                        <option value="Anniversary">Anniversary</option>
                                        <option value="Health">Health Recovery</option>
                                        <option value="Achievement">Achievement</option>
                                        <option value="Appreciation">Appreciation</option>
                                        <option value="Wedding">Wedding</option>
                                        <option value="New Baby">New Baby</option>
                                        <option value="Condolence">Condolence</option>
                                        <option value="Retirement">Retirement</option>
                                        <option value="Others">Others</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label"><strong>Description *</strong></label>
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                    wire:model="description" rows="4"></textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><strong>Target Amount (₦) *</strong></label>
                                    <input type="number" class="form-control" wire:model="target_amount" disabled>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><strong>Deadline</strong></label>
                                    <input type="date" class="form-control @error('deadline') is-invalid @enderror"
                                        wire:model="deadline" min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                                    @error('deadline')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label"><strong>Image</strong></label>
                                @if ($current_image && !$remove_image)
                                    <div class="mb-2">
                                        <img src="{{ Storage::url($current_image) }}" class="img-thumbnail"
                                            style="max-height: 100px;">
                                        <button type="button" class="btn btn-sm btn-danger ms-2"
                                            wire:click="$set('remove_image', true)">
                                            Remove Image
                                        </button>
                                    </div>
                                @endif

                                @if ($remove_image)
                                    <div class="alert alert-warning">
                                        Image will be removed when you save.
                                        <button type="button" class="btn btn-sm btn-link"
                                            wire:click="$set('remove_image', false)">
                                            Keep Image
                                        </button>
                                    </div>
                                @endif

                                <input type="file" class="form-control @error('gift_image') is-invalid @enderror"
                                    wire:model="gift_image" accept="image/*">
                                @error('gift_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                @if ($gift_image)
                                    <div class="mt-2">
                                        <img src="{{ $gift_image->temporaryUrl() }}" class="img-thumbnail"
                                            style="max-height: 100px;">
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="closeEditModal">Cancel</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Update Gift
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- End Confirmation Modal -->
    @if ($showEndModal)
        <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content shadow theme-sensitive">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirm Gift Ending</h5>
                        <button type="button" class="btn-close" wire:click="closeEndModal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                            <h5>Are you sure you want to end this gift?</h5>
                            <p class="text-muted">This action cannot be undo. As your link will no long be public and amount
                                raised will be moved to your withdrawable balance</p>
                            <div class="alert alert-info">
                                <strong>{{ $gift->title }}</strong><br>
                                Target: ₦{{ number_format($gift->target_amount, 2) }}<br>
                                Current: ₦{{ number_format($gift->current_amount, 2) }}
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeEndModal">Cancel</button>
                        <button type="button" class="btn btn-danger" wire:click="endGift">
                            <i class="fas fa-stop me-1"></i> Yes, End Gift
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <script>
        // Handle copy to clipboard
        document.addEventListener('livewire:init', () => {
            Livewire.on('copy-to-clipboard', (event) => {
                navigator.clipboard.writeText(event.text).then(() => {
                    // Success handled by session flash message
                }).catch(() => {
                    alert('Failed to copy to clipboard');
                });
            });

            Livewire.on('openWindow', (url) => {
                window.open(url, '_blank', 'width=600,height=400');
            });
        });
    </script>

    <style>
        .modal.show {
            display: block !important;
        }

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

        .table-success {
            --bs-table-accent-bg: rgba(25, 135, 84, 0.05);
        }
    </style>
</div>
