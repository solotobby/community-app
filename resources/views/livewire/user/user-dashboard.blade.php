<div class="content">
    {{-- <div class="content-side content-side-full">
        <div class="row">
            <!-- Total Games Played -->
            <div class="col-md-3">
                <div class="block block-rounded block-bordered">
                    <div class="block-header bg-primary">
                        <h3 class="block-title text-white">User Referred</h3>
                    </div>
                    <div class="block-content">
                        <p class="fs-3">0</p>
                    </div>
                </div>
            </div>

            <!-- Wallet Balance -->
            <div class="col-md-3">
                <div class="block block-rounded block-bordered">
                    <div class="block-header bg-success">
                        <h3 class="block-title text-white">Total Cash Claimed</h3>
                    </div>
                    <div class="block-content">
                        <p class="fs-3">#0</p>
                    </div>
                </div>
            </div>

            <!-- Active Games -->
            <div class="col-md-3">
                <div class="block block-rounded block-bordered">
                    <div class="block-header bg-warning">
                        <h3 class="block-title text-white">Unclaimed Cash</h3>
                    </div>
                    <div class="block-content">
                        <p class="fs-3">#0</p>
                    </div>
                </div>
            </div>

            <!-- Pending Transactions -->
            <div class="col-md-3">
                <div class="block block-rounded block-bordered">
                    <div class="block-header bg-danger">
                        <h3 class="block-title text-white">Total Transactions</h3>
                    </div>
                    <div class="block-content">
                        <p class="fs-3">0</p>
                    </div>
                </div>
            </div>
        </div>

    </div> --}}

     {{-- Draw Section --}}
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">🎁 Gifting Draw — {{ ucfirst($drawType) }}</h5>
            <span class="badge bg-info">Select up to 7 items</span>
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
                    🎯 Confirm Selection ({{ count($selectedItems) }}/7)
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
                        <h5 class="modal-title">🎯 Confirm Your Gift Items</h5>
                        <button type="button" class="btn-close" wire:click="$set('showConfirmation', false)"></button>
                    </div>
                    <div class="modal-body">
                        <p>You selected {{ count($selectedItems) }} items. Items from your selection will be picked
                            randomly as your rewards.</p>
                        <ul>
                            @foreach ($availableItems->whereIn('id', $selectedItems) as $item)
                                <li>{{ $item->item_name }}</li>
                            @endforeach
                        </ul>
                        <p class="mt-3"><strong>Draw Type:</strong> {{ ucfirst($drawType) }}</p>
                    </div>
                    <div class="modal-footer">
                        <button wire:click="processRaffleDraw" class="btn btn-primary" wire:loading.attr="disabled"
                            wire:target="processRaffleDraw">
                            <span wire:loading.remove wire:target="processRaffleDraw">✅ Confirm & Draw</span>
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
                            <p class="mb-0 mt-2 opacity-90">Raffle Draw Complete!</p>
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
                                {{ count(json_decode($raffleDraw->reward, true)) }} Gift Selected!
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
                                                <div class="text-success mb-2">🎯</div>
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
    @endif
</div>
