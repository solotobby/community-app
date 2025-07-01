<div class="content">
    @if (session()->has('message'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition class="alert alert-success">
            {{ session('message') }}
            @if (session()->has('gift_url'))
                <br><strong>Share your gift:</strong> <a href="{{ session('gift_url') }}"
                    target="_blank">{{ session('gift_url') }}</a>
            @endif
        </div>
    @endif

    <div class="container-fluid p-0 m-0">
        <div class="card border-0">
            <div class="card-header">
                <h5 class="mb-0">Raise Money</h5>

                <!-- Progress Bar -->
                <div class="progress mt-3" style="height: 8px;">
                    <div class="progress-bar bg-primary" role="progressbar"
                        style="width: {{ ($currentStep / $totalSteps) * 100 }}%"></div>
                </div>
                <div class="d-flex justify-content-between mt-2">
                    <small class="text-muted">Step {{ $currentStep }} of {{ $totalSteps }}</small>
                    <small class="text-muted">{{ round(($currentStep / $totalSteps) * 100) }}% Complete</small>
                </div>
            </div>

            <div class="card-body">
                <form wire:submit.prevent="{{ $currentStep == $totalSteps ? 'createGift' : 'nextStep' }}">

                    @if ($currentStep == 1)
                        <!-- Step 1: Basic Details -->
                        <div class="step-content">
                            <h6 class="mb-3">Tell us about your fund raising</h6>

                            <div class="mb-3">
                                <label for="title" class="form-text"><strong>Title *</strong></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                    id="title" wire:model="title" placeholder="e.g., Sarah's Birthday Fund">
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="reason" class="form-text"><strong> Reason *</strong></label>
                                <select wire:model="reason" class="form-control @error('reason') is-invalid @enderror">
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
                                @error('reason')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label for="description" class="form-text"><strong> Description *</strong></label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" wire:model="description"
                                    rows="4" placeholder="Tell people what this gift is for and why it's special..."></textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">{{ strlen($description) }}/1000 characters</div>
                            </div>
                        </div>
                    @endif

                    @if ($currentStep == 2)
                        <!-- Step 2: Gift Details -->
                        <div class="step-content">
                            <h6 class="mb-3">Tell us more about your fund raising</h6>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="target_amount" class="form-text"><strong> Amount To Raise (₦) *</strong></label>
                                    <input type="number"
                                        class="form-control @error('target_amount') is-invalid @enderror"
                                        id="target_amount" wire:model="target_amount" min="1" step="0.01">
                                    @error('target_amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="deadline" class="form-text"><strong> Deadline (Max of 60 days)</strong></label>
                                    <input type="date" class="form-control @error('deadline') is-invalid @enderror"
                                        id="deadline" wire:model="deadline"
                                        min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                        max="{{ date('Y-m-d', strtotime('+60 days')) }}">
                                    @error('deadline')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>

                            <div class="mb-3">
                                <label for="gift_image" class="form-text"><strong> Image (Optional)</strong></label>
                                <input type="file" class="form-control @error('gift_image') is-invalid @enderror"
                                    id="gift_image" wire:model="gift_image" accept="image/*">
                                @error('gift_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Upload an image that will convince people to send you money (Max: 2MB)</div>

                                @if ($gift_image)
                                    <div class="mt-2">
                                        <img src="{{ $gift_image->temporaryUrl() }}" class="img-thumbnail"
                                            style="max-height: 150px;">
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    @if ($currentStep == 3)
                        <!-- Step 3: Settings & Preview -->
                        <div class="step-content">
                            <h6 class="mb-3">Configure Settings</h6>


                            {{-- <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="allow_messages"
                                        wire:model="allow_messages">
                                    <label class="form-check-label" for="allow_messages">
                                        Allow contributors to leave messages
                                    </label>
                                </div>
                            </div> --}}

                            {{-- <div class="col-md-6 mb-3">
                                <label for="min_contribution" class="form-text"><strong> Minimum Amount Accepted (₦)</strong></label>
                                <input type="number"
                                class="form-control @error('min_contribution') is-invalid @enderror"
                                id="min_contribution" wire:model="min_contribution" min="1"
                                step="0.01">
                                @error('min_contribution')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Leave empty for no minimum</div>
                            </div> --}}

                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_public"
                                        wire:model="is_public">
                                    <label class="form-text" for="is_public">
                                       <strong> Make this fund raising public </strong>
                                    </label>
                                </div>
                                <small class="form-text">The link is accessible only if made public</small>
                            </div>

                            <!-- Preview -->
                            <div class="card bg-grey col-md-6 mb-3">
                                <div class="card-header">
                                    <h6 class="mb-0">Preview</h6>
                                </div>
                                <div class="card-body">
                                    <h5 class="mb-2"><strong>{{ $title ?: 'Your Gift Title' }}</strong></h5>
                                    <h6 class="mb-2"><strong>
                                        {{ $description ?: 'Your gift description will appear here...' }}</strong></h6>

                                    <div class="d-flex justify-content-between flex-wrap form-text">
                                        <small><strong>Target:</strong>
                                            ₦{{ number_format($target_amount ?: 0, 2) }}</small>
                                        @if ($deadline)
                                            <small><strong>Deadline:</strong>
                                                {{ date('M d, Y', strtotime($deadline)) }}</small>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endif

                    <!-- Navigation Buttons -->
                    <div class="d-flex justify-content-between mt-4">
                        <div>
                            @if ($currentStep > 1)
                                <button type="button" class="btn btn-outline-secondary" wire:click="previousStep">
                                    <i class="fas fa-arrow-left me-1"></i> Previous
                                </button>
                            @endif
                        </div>

                        <div>
                            @if ($currentStep < $totalSteps)
                                <button type="submit" class="btn btn-primary">
                                    Next <i class="fas fa-arrow-right ms-1"></i>
                                </button>
                            @else
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-gift me-1"></i> Create Gift Request
                                </button>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
