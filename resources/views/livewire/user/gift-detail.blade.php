<div class="content">
    @if (session()->has('message'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition class="alert alert-success mb-4">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition class="alert alert-danger mb-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- Header Actions -->
    <div class="container-fluid p-0 m-0 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <a href="{{ route('user.gift.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Back to Gifts
                </a>
            </div>
            <div>
                <span class="badge fs-6 {{ $gift->status === 'active' ? 'bg-success' :
                    ($gift->status === 'completed' ? 'bg-primary' :
                    ($gift->status === 'paused' ? 'bg-warning text-dark' : 'bg-secondary')) }}">
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
                            <p class="card-text mb-4">{{ $gift->description }}</p>

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
                                    <small class="text-muted">{{ round($stats['progress_percentage']) }}% funded</small>
                                    <small class="text-muted">{{ $stats['total_contributors'] }} contributors</small>
                                </div>
                            </div>

                            <!-- Gift Meta Info -->
                            <div class="row mb-4">
                                <div class="col-sm-6 mb-2">
                                    <strong>Created:</strong> {{ $gift->created_at->format('M d, Y') }}
                                </div>
                                @if ($gift->deadline)
                                    <div class="col-sm-6 mb-2">
                                        <strong>Deadline:</strong> {{ $gift->deadline->format('M d, Y') }}
                                        @if ($gift->deadline->isPast())
                                            <span class="badge bg-danger ms-1">Expired</span>
                                        @endif
                                    </div>
                                @endif
                                <div class="col-sm-6 mb-2">
                                    <strong>Visibility:</strong> {{ $gift->is_public ? 'Public' : 'Private' }}
                                </div>
                                <div class="col-sm-6 mb-2">
                                    <strong>Total Contributions:</strong> {{ $stats['total_contributions'] }}
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-auto">
                            <div class="row g-2">
                                <div class="col-md-3 col-6">
                                    <button class="btn btn-primary w-100" wire:click="openEditModal">
                                        <i class="fas fa-edit me-1"></i> Edit
                                    </button>
                                </div>
                                <div class="col-md-3 col-6">
                                    <button class="btn btn-{{ $gift->status === 'active' ? 'warning' : 'success' }} w-100"
                                            wire:click="toggleStatus">
                                        <i class="fas fa-{{ $gift->status === 'active' ? 'pause' : 'play' }} me-1"></i>
                                        {{ $gift->status === 'active' ? 'Pause' : 'Resume' }}
                                    </button>
                                </div>
                                <div class="col-md-3 col-6">
                                    <button class="btn btn-info w-100" wire:click="copyGiftLink">
                                        <i class="fas fa-share me-1"></i> Share
                                    </button>
                                </div>
                                <div class="col-md-3 col-6">
                                    <button class="btn btn-danger w-100" wire:click="openDeleteModal">
                                        <i class="fas fa-trash me-1"></i> Delete
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
                                <h6 class="card-title mb-0">Contributors</h6>
                                <h4 class="mb-0">{{ $stats['total_contributors'] }}</h4>
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
            <div class="card border-0">
                <div class="card-header">
                    <h5 class="mb-0">Recent Contributions</h5>
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
                                                   <div class="fw-bold">{{ $contribution->is_anonymous ? 'Anonymous' : $contribution->contributor_name }}</div>

                                                    <small class="text-muted">{{ $contribution->is_anonymous ? 'Anonymous' : $contribution->contributor_email }}</small>
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

    <!-- Edit Modal -->
    @if ($showEditModal)
        <div class="modal fade show d-block" style="background: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Gift</h5>
                        <button type="button" class="btn-close" wire:click="closeEditModal"></button>
                    </div>
                    <form wire:submit.prevent="updateGift">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><strong>Title *</strong></label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                           wire:model="title">
                                    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><strong>Reason *</strong></label>
                                    <select class="form-select @error('reason') is-invalid @enderror" wire:model="reason">
                                        <option value="">Select Reason</option>
                                        <option value="Birthday">Birthday</option>
                                        <option value="Anniversary">Anniversary</option>
                                        <option value="Health">Health Recovery</option>
                                        <option value="Achievement">Achievement</option>
                                        <option value="Appreciation">Appreciation</option>
                                        <option value="Wedding">Wedding</option>
                                        <option value="New Baby">New Baby</option>
                                        <option value="Condolence">Condolence</option>
                                    </select>
                                    @error('reason') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label"><strong>Description *</strong></label>
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                          wire:model="description" rows="4"></textarea>
                                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><strong>Target Amount (₦) *</strong></label>
                                    <input type="number" class="form-control @error('target_amount') is-invalid @enderror"
                                           wire:model="target_amount" min="1" step="0.01">
                                    @error('target_amount') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><strong>Deadline</strong></label>
                                    <input type="date" class="form-control @error('deadline') is-invalid @enderror"
                                           wire:model="deadline" min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                                    @error('deadline') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label"><strong>Image</strong></label>
                                @if ($current_image && !$remove_image)
                                    <div class="mb-2">
                                        <img src="{{ Storage::url($current_image) }}" class="img-thumbnail" style="max-height: 100px;">
                                        <button type="button" class="btn btn-sm btn-danger ms-2" wire:click="$set('remove_image', true)">
                                            Remove Image
                                        </button>
                                    </div>
                                @endif

                                @if ($remove_image)
                                    <div class="alert alert-warning">
                                        Image will be removed when you save.
                                        <button type="button" class="btn btn-sm btn-link" wire:click="$set('remove_image', false)">
                                            Keep Image
                                        </button>
                                    </div>
                                @endif

                                <input type="file" class="form-control @error('gift_image') is-invalid @enderror"
                                       wire:model="gift_image" accept="image/*">
                                @error('gift_image') <div class="invalid-feedback">{{ $message }}</div> @enderror

                                @if ($gift_image)
                                    <div class="mt-2">
                                        <img src="{{ $gift_image->temporaryUrl() }}" class="img-thumbnail" style="max-height: 100px;">
                                    </div>
                                @endif
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><strong>Minimum Contribution (₦)</strong></label>
                                    <input type="number" class="form-control @error('min_contribution') is-invalid @enderror"
                                           wire:model="min_contribution" min="1" step="0.01">
                                    @error('min_contribution') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" wire:model="is_public">
                                    <label class="form-check-label">Make this gift request public</label>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" wire:model="allow_messages">
                                    <label class="form-check-label">Allow contributors to leave messages</label>
                                </div>
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

    <!-- Delete Confirmation Modal -->
    @if ($showDeleteModal)
        <div class="modal fade show d-block" style="background: rgba(0,0,0,0.5);">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirm Delete</h5>
                        <button type="button" class="btn-close" wire:click="closeDeleteModal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                            <h5>Are you sure you want to delete this gift?</h5>
                            <p class="text-muted">This action cannot be undone. All data associated with this gift will be permanently removed.</p>
                            <div class="alert alert-info">
                                <strong>{{ $gift->title }}</strong><br>
                                Target: ₦{{ number_format($gift->target_amount, 2) }}<br>
                                Current: ₦{{ number_format($gift->current_amount, 2) }}
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeDeleteModal">Cancel</button>
                        <button type="button" class="btn btn-danger" wire:click="deleteGift">
                            <i class="fas fa-trash me-1"></i> Yes, Delete Gift
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
    </style>
</div>
