 <div>
    <!-- Upgrade Account Modal -->
    @if($showUpgradeModal)
        <div class="modal fade show" style="display: block;" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">
                            <i class="fas fa-arrow-up me-2"></i>
                            Upgrade Your Account
                        </h5>
                        <button type="button" class="btn-close btn-close-white" wire:click="closeModal"></button>
                    </div>

                    <div class="modal-body">
                        <!-- Current Level Info -->
                        <div class="alert alert-info mb-4">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-info-circle me-2"></i>
                                <div>
                                    <strong>Current Level:</strong> {{ $currentUser->level->name ?? 'No Level' }}
                                    <br>
                                    <small>Registration Amount: NGN {{ number_format($currentUser->level->registration_amount ?? 0, 2) }}</small>
                                </div>
                            </div>
                        </div>

                        @if($availableLevels->count() > 0)
                            <h6 class="mb-3">Available Upgrades:</h6>

                            <div class="row">
                                @foreach($availableLevels as $level)
                                    @php
                                        $upgradeAmount = $level->registration_amount - ($currentUser->level->registration_amount ?? 0);
                                    @endphp
                                    <div class="col-md-6 mb-3">
                                        <div class="card level-card {{ $selectedLevel && $selectedLevel->id === $level->id ? 'border-primary' : '' }}"
                                             style="cursor: pointer;"
                                             wire:click="selectLevel({{ $level->id }})">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-start mb-2">
                                                    <h6 class="card-title mb-0">{{ $level->name }}</h6>
                                                    @if($selectedLevel && $selectedLevel->id === $level->id)
                                                        <i class="fas fa-check-circle text-primary"></i>
                                                    @endif
                                                </div>

                                                <div class="mb-2">
                                                    <small class="text-muted">Full Amount:</small>
                                                    <div class="fw-bold">NGN {{ number_format($level->registration_amount, 2) }}</div>
                                                </div>

                                                <div class="mb-3">
                                                    <small class="text-muted">Upgrade Cost:</small>
                                                    <div class="fw-bold text-primary">NGN {{ number_format($upgradeAmount, 2) }}</div>
                                                </div>

                                                <div class="row text-center">
                                                    <div class="col-6">
                                                        <small class="text-muted d-block">Entry Gift</small>
                                                        <strong class="text-success">NGN {{ number_format($level->entry_gift, 2) }}</strong>
                                                    </div>
                                                    <div class="col-6">
                                                        <small class="text-muted d-block">Referral Bonus</small>
                                                        <strong class="text-info">NGN {{ number_format($level->referral_bonus, 2) }}</strong>
                                                    </div>
                                                </div>

                                                <div class="mt-3 pt-2 border-top">
                                                    <small class="text-muted">Currency: {{ $level->currency }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            @if($selectedLevel)
                                <div class="alert alert-success mt-3">
                                    <h6 class="alert-heading">
                                        <i class="fas fa-check me-2"></i>
                                        Upgrade Summary
                                    </h6>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>From:</strong> {{ $currentUser->level->name ?? 'No Level' }}<br>
                                            <strong>To:</strong> {{ $selectedLevel->name }}<br>
                                        </div>
                                        <div class="col-md-6">
                                            <strong>Upgrade Cost:</strong> NGN {{ number_format($selectedLevel->registration_amount - ($currentUser->level->registration_amount ?? 0), 2) }}<br>
                                            <strong>Payment Method:</strong> Paystack
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @else
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                You are already at the highest level available, or no higher levels are available for upgrade.
                            </div>
                        @endif
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal">
                            <i class="fas fa-times me-1"></i>
                            Cancel
                        </button>

                        @if($selectedLevel)
                            <button type="button" class="btn btn-primary" wire:click="initiateUpgrade"
                                    wire:loading.attr="disabled" wire:target="initiateUpgrade">
                                <span wire:loading.remove wire:target="initiateUpgrade">
                                    <i class="fas fa-credit-card me-1"></i>
                                    Pay NGN {{ number_format($selectedLevel->registration_amount - ($currentUser->level->registration_amount ?? 0), 2) }}
                                </span>
                                <span wire:loading wire:target="initiateUpgrade">
                                    <i class="spinner-border spinner-border-sm me-1"></i>
                                    Processing...
                                </span>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    @endif

    <style>
        .level-card {
            transition: all 0.3s ease;
        }

        .level-card:hover {
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transform: translateY(-2px);
        }

        .level-card.border-primary {
            border-width: 2px !important;
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
        }
    </style>
</div>
