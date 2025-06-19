<div class="content">

    @if (session()->has('message'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    {{-- Draw Section --}}
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <h5 class="mb-0">
                    🎁 Claim Available Gifts (
                    @if ($drawType === 'registration')
                        <strong>Sign Up</strong>
                    @else
                        <strong>{{ ucfirst($drawType) }}</strong>
                    @endif
                    )
                </h5>
                <span class="badge bg-info ms-3">Select up to 7 items</span>
            </div>


            <div class="d-flex align-items-center gap-2">
                <!-- Current Level Display -->
                <div class="me-3">
                    <small class="text-muted d-block">Current Level</small>
                    <span class="badge bg-secondary">
                        {{ $userLevel->name ?? 'No Level' }}
                    </span>
                </div>

                <!-- Upgrade Account Button -->
                <button type="button" class="btn btn-success btn-sm" wire:click="openUpgradeModal"
                    title="Upgrade your account to access higher levels">
                    <i class="fas fa-arrow-up me-1"></i>
                    Upgrade Account
                </button>
            </div>
        </div>

        <div class="card-body">
            {{-- <p class="card-title text-light">Only 4 items will be randomly selected as rewards.</p> --}}

            {{-- Items Grid --}}
            <div class="row">
                @foreach ($availableItems as $item)
                    @php
                        $isSelected = in_array($item->id, $selectedItems);
                        $isDisabled = !$isSelected && count($selectedItems) >= 7;
                    @endphp
                    <div class="col-md-3 mb-3">
                        <div class="card h-100 {{ $isSelected ? 'border-success' : '' }}">
                            <img src="{{ $item->item_url }}" class="card-img-top"
                                style="height: 150px; object-fit: cover;">
                            <div class="card-body text-center">
                                <h6 class="card-title">{{ $item->item_name }}</h6>
                                <button wire:click="selectItem({{ $item->id }})"
                                    class="btn btn-sm {{ $isSelected ? 'btn-danger' : 'btn-outline-primary' }}"
                                    @if ($isDisabled) disabled @endif>
                                    {{ $isSelected ? 'Remove' : 'Select' }}
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Confirm Button --}}
            <div class="mt-4 text-end">
                <button wire:click="confirmSelection" class="btn btn-success"
                    @if (count($selectedItems) < 4) disabled @endif>
                    🎁 Confirm Selection ({{ count($selectedItems) }}/7)
                </button>
            </div>
        </div>
    </div>

    {{-- Confirmation Modal --}}
    @if ($showConfirmation)
        <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">🎁 Confirm Your Gift Items</h5>
                        <button type="button" class="btn-close" wire:click="$set('showConfirmation', false)"></button>
                    </div>
                    <div class="modal-body">
                        <p>You selected {{ count($selectedItems) }} items. Items from your selection will be picked
                            randomly as your gift.</p>
                        <ul>
                            @foreach ($availableItems->whereIn('id', $selectedItems) as $item)
                                <li>{{ $item->item_name }}</li>
                            @endforeach
                        </ul>
                        <p class="mt-3">
                            <strong>Gift Type:
                                @if ($drawType === 'registration')
                                    Sign Up
                                @else
                                    {{ ucfirst($drawType) }}
                                @endif
                            </strong>
                        </p>

                    </div>
                    <div class="modal-footer">
                        <button wire:click="processRaffleDraw" class="btn btn-primary" wire:loading.attr="disabled"
                            wire:target="processRaffleDraw">
                            <span wire:loading.remove wire:target="processRaffleDraw">✅ Confirm & Claim</span>
                            <span wire:loading wire:target="processRaffleDraw">
                                <span class="spinner-border spinner-border-sm me-2"></span>
                                Processing Draw...
                            </span>
                        </button>

                        <button class="btn btn-secondary" wire:click="$set('showConfirmation', false)">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Upgrade Account Modal --}}
    @if ($showUpgradeModal)
        <div class="modal fade show" style="display: block;" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">
                            <i class="fas fa-arrow-up me-2"></i>
                            Upgrade Your Account
                        </h5>
                        <button type="button" class="btn-close btn-close-white"
                            wire:click="closeUpgradeModal"></button>
                    </div>

                    <div class="modal-body">
                        <!-- Current Level Info -->
                        <div class="alert alert-info mb-4">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-info-circle me-2"></i>
                                <div>
                                    <strong>Current Level:</strong> {{ $userLevel->name ?? 'No Level' }}
                                    <br>
                                    <small>Registration Amount: NGN
                                        {{ number_format($userLevel->registration_amount ?? 0, 2) }}</small>
                                </div>
                            </div>
                        </div>

                        @if ($availableLevels->count() > 0)
                            <h6 class="mb-3">Available Upgrades:</h6>

                            <div class="row">
                                @foreach ($availableLevels as $level)
                                    @php
                                        $upgradeAmount = $level->registration_amount;
                                        $isSelectable = $upgradeAmount > ($userLevel->registration_amount ?? 0);
                                    @endphp
                                    <div class="col-md-6 mb-3">
                                        <div class="card level-card {{ $selectedLevel && $selectedLevel->id === $level->id ? 'border-primary' : '' }} {{ !$isSelectable ? 'opacity-50' : '' }}"
                                            style="cursor: {{ $isSelectable ? 'pointer' : 'not-allowed' }};"
                                            @if ($isSelectable) wire:click="selectLevel({{ $level->id }})" @endif>
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-start mb-2">
                                                    <h6 class="card-title mb-0">{{ $level->name }}</h6>
                                                    @if ($selectedLevel && $selectedLevel->id === $level->id)
                                                        <i class="fas fa-check-circle text-primary"></i>
                                                    @endif
                                                </div>

                                                {{-- <div class="mb-2">
                                                    <small class="text-muted">Level Amount:</small>
                                                    <div class="fw-bold text-light">NGN
                                                        {{ number_format($level->registration_amount, 2) }}</div>
                                                </div> --}}

                                                <div class="mb-3">
                                                    <small class="text-muted">Upgrade Cost:</small>
                                                    <div
                                                        class="fw-bold {{ $isSelectable ? 'text-primary' : 'text-muted' }}">
                                                        NGN {{ number_format($upgradeAmount, 2) }}
                                                    </div>
                                                    @unless ($isSelectable)
                                                        <div class="small text-danger">Upgrade not available</div>
                                                    @endunless
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            @if ($selectedLevel)
                                <div class="alert alert-success mt-3">
                                    <h6 class="alert-heading">
                                        <i class="fas fa-check me-2"></i>
                                        Upgrade Summary
                                    </h6>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>From:</strong> {{ $userLevel->name ?? 'No Level' }}<br>
                                            <strong>To:</strong> {{ $selectedLevel->name }}<br>
                                        </div>
                                        <div class="col-md-6">
                                            <strong>Upgrade Cost:</strong> NGN
                                            {{ number_format($selectedLevel->registration_amount) }}<br>
                                            <strong>Payment Method:</strong> Paystack
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @else
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                You are already at the highest level available, or no higher levels are available for
                                upgrade.
                            </div>
                        @endif
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeUpgradeModal">
                            <i class="fas fa-times me-1"></i>
                            Cancel
                        </button>

                        @if ($selectedLevel)
                            <button type="button" class="btn btn-primary" wire:click="initiateUpgrade"
                                wire:loading.attr="disabled" wire:target="initiateUpgrade">
                                <span wire:loading.remove wire:target="initiateUpgrade">
                                    <i class="fas fa-credit-card me-1"></i>
                                    Pay NGN
                                    {{ number_format($selectedLevel->registration_amount, 2) }}
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

    {{-- Success Message --}}
    @if ($showSuccess && $raffleDraw)
        <!-- Celebration Ribbon Overlay -->
        <div class="celebration-ribbon-overlay position-fixed w-100 h-100"
            style="top: 0; left: 0; z-index: 9999; pointer-events: none;">
            <div class="ribbon-container">
                <div class="ribbon ribbon-left"></div>
                <div class="ribbon ribbon-right"></div>
            </div>
            <div class="confetti-container">
                @for ($i = 0; $i < 20; $i++)
                    <div class="confetti confetti-{{ $i }}"></div>
                @endfor
            </div>
        </div>

        <!-- Success Modal -->
        <div class="modal fade show" id="raffleSuccessModal" tabindex="-1"
            style="display: block; background-color: rgba(0,0,0,0.5);" aria-labelledby="raffleSuccessModalLabel"
            aria-hidden="false">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content border-0 shadow-lg">
                    <div
                        class="modal-header bg-gradient-success text-white text-center border-0 position-relative overflow-hidden">
                        <div class="w-100">
                            <h4 class="modal-title fw-bold mb-0" id="raffleSuccessModalLabel">
                                🎉 Congratulations! 🎉
                            </h4>
                            <p class="mb-0 mt-2 opacity-90">Gift Draw Complete!</p>
                        </div>
                        <!-- Decorative elements -->
                        <div class="position-absolute top-0 start-0 w-100 h-100 opacity-10">
                            <div class="d-flex justify-content-around align-items-center h-100">
                                <span style="font-size: 3rem;">🎊</span>
                                <span style="font-size: 2.5rem;">✨</span>
                                <span style="font-size: 3rem;">🎉</span>
                                <span style="font-size: 2.5rem;">🌟</span>
                                <span style="font-size: 3rem;">🎊</span>
                            </div>
                        </div>
                    </div>

                    <div class="modal-body text-center py-4">
                        <div class="mb-4">
                            <div class="display-1 text-warning mb-3">🏆</div>
                            <h5 class="text-success fw-bold mb-3">
                                {{ count(json_decode($raffleDraw->reward, true)) }} Gifts Won!
                            </h5>
                        </div>

                        <div class="winner-list bg-light rounded-3 p-4 mb-4">
                            <h6 class="text-muted mb-3">🎁 Winning Items:</h6>
                            <div class="row g-2">
                                @foreach (json_decode($raffleDraw->reward, true) as $index => $reward)
                                    <div class="col-md-6">
                                        <div class="card border-success border-2 h-100 winner-item"
                                            style="animation-delay: {{ $index * 0.2 }}s;">
                                            <div class="card-body text-center py-3">
                                                <div class="text-success mb-2">🎁</div>
                                                <h6 class="card-title mb-0 text-success fw-bold">{{ $reward['name'] }}
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer justify-content-center border-0 pb-4">
                        <button type="button" class="btn btn-outline-secondary me-3" data-bs-dismiss="modal">
                            Close
                        </button>
                        <a href="{{ route('user.raffle.draw') }}" class="btn btn-primary btn-lg px-5 claim-button">
                            <i class="fas fa-gift me-2"></i>
                            Claim Your Prize
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <style>
            .level-card {
                transition: all 0.3s ease;
            }

            .level-card:hover {
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                transform: translateY(-2px);
            }

            .level-card.border-primary {
                border-width: 2px !important;
                box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
            }
        </style>
    @endif
    <style>
        /* Celebration Ribbon Styles */
        .celebration-ribbon-overlay {
            animation: fadeIn 0.5s ease-in-out;
        }

        .ribbon-container {
            position: relative;
            width: 100%;
            height: 100px;
        }

        .ribbon {
            position: absolute;
            top: 20px;
            width: 100%;
            height: 60px;
            background: linear-gradient(45deg, #ff6b6b, #4ecdc4, #45b7d1, #f9ca24, #f0932b);
            background-size: 400% 400%;
            animation: gradientShift 3s ease infinite;
            opacity: 0.9;
        }

        .ribbon-left {
            transform: rotate(-3deg);
            transform-origin: center;
        }

        .ribbon-right {
            transform: rotate(3deg);
            transform-origin: center;
            animation-delay: 0.5s;
        }

        .ribbon::before {
            content: '🎉 CONGRATULATIONS! 🎉';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-weight: bold;
            font-size: 1.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            white-space: nowrap;
        }

        /* Confetti Animation */
        .confetti-container {
            position: relative;
            width: 100%;
            height: 100%;
        }

        .confetti {
            position: absolute;
            width: 10px;
            height: 10px;
            background: #ff6b6b;
            animation: confettiFall 3s infinite linear;
        }

        .confetti:nth-child(odd) {
            background: #4ecdc4;
        }

        .confetti:nth-child(3n) {
            background: #f9ca24;
        }

        .confetti:nth-child(4n) {
            background: #45b7d1;
        }

        .confetti:nth-child(5n) {
            background: #f0932b;
        }

        /* Individual confetti positioning will be set by JavaScript */

        /* Modal Animations */
        .modal.show {
            animation: modalSlideIn 0.5s ease-out;
        }

        .winner-item {
            animation: bounceIn 0.8s ease-out forwards;
            opacity: 0;
            transform: scale(0.3);
        }

        .claim-button {
            animation: pulse 2s infinite;
            background: linear-gradient(45deg, #28a745, #20c997);
            border: none;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
            transition: all 0.3s ease;
        }

        .claim-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(40, 167, 69, 0.4);
        }

        /* Keyframe Animations */
        @keyframes gradientShift {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        @keyframes confettiFall {
            0% {
                transform: translateY(-100vh) rotate(0deg);
                opacity: 1;
            }

            100% {
                transform: translateY(100vh) rotate(360deg);
                opacity: 0;
            }
        }

        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: scale(0.8);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes bounceIn {
            0% {
                opacity: 0;
                transform: scale(0.3);
            }

            50% {
                opacity: 1;
                transform: scale(1.05);
            }

            70% {
                transform: scale(0.9);
            }

            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
            }

            50% {
                box-shadow: 0 8px 25px rgba(40, 167, 69, 0.6);
            }

            100% {
                box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .ribbon::before {
                font-size: 1rem;
            }

            .modal-dialog {
                margin: 1rem;
            }

            .winner-item {
                margin-bottom: 0.5rem;
            }
        }
    </style>

    <script>
        // Auto-show modal and handle backdrop clicks
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('raffleSuccessModal');

            // Prevent modal from closing when clicking backdrop
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    e.stopPropagation();
                }
            });

            // Remove celebration ribbon after 5 seconds
            setTimeout(function() {
                const ribbon = document.querySelector('.celebration-ribbon-overlay');
                if (ribbon) {
                    ribbon.style.opacity = '0';
                    ribbon.style.transition = 'opacity 1s ease-out';
                    setTimeout(() => ribbon.remove(), 1000);
                }
            }, 5000);

        });
    </script>

</div>
