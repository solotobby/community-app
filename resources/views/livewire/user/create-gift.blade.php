<div class="content">

    <div class="position-fixed top-0 end-0 p-3" style="z-index: 9999">
        @if (session()->has('message') || session()->has('success'))
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

    {{-- Verification Modal --}}
    @if ($showVerificationModal)
        <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content shadow theme-sensitive">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-shield-alt text-primary me-2"></i>
                            Account Verification
                        </h5>
                        <button type="button" class="btn-close" wire:click="closeVerificationModal"></button>
                    </div>
                    <div class="modal-body">
                        @php
                            $user = auth()->user();
                            $phoneVerified = $user->phone_verified ?? false;
                            $emailVerified = $user->email_verified ?? false;
                        @endphp

                        {{-- Verification Choice --}}
                        @if ($currentVerificationStep === 'choose')
                            <div class="text-center mb-4">
                                <i class="fas fa-user-check fa-3x text-primary mb-3"></i>
                                <h6 class="mb-3">Complete your verification to create gifts</h6>
                                <p class="text-muted small">We need to verify your contact information for security.</p>
                            </div>

                            <div class="row g-3">
                                @if (!$phoneVerified)
                                    <div class="col-12">
                                        <div class="card border-warning">
                                            <div class="card-body text-center">
                                                <i class="fas fa-mobile-alt fa-2x text-warning mb-2"></i>
                                                <h6 class="card-title">Phone Verification</h6>
                                                <p class="card-text small text-muted mb-3">{{ $phone }}</p>
                                                <button class="btn btn-warning btn-sm w-100" wire:click="startPhoneVerification">
                                                    <i class="fas fa-sms me-2"></i>Verify Phone
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-12">
                                        <div class="card border-success">
                                            <div class="card-body text-center">
                                                <i class="fas fa-mobile-alt fa-2x text-success mb-2"></i>
                                                <h6 class="card-title">Phone Verified ✓</h6>
                                                <p class="card-text small text-muted">{{ $phone }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if (!$emailVerified)
                                    <div class="col-12">
                                        <div class="card border-info">
                                            <div class="card-body text-center">
                                                <i class="fas fa-envelope fa-2x text-info mb-2"></i>
                                                <h6 class="card-title">Email Verification</h6>
                                                <p class="card-text small text-muted mb-3">{{ $user->email }}</p>
                                                <button class="btn btn-primary btn-sm w-100" wire:click="startEmailVerification">
                                                    <i class="fas fa-paper-plane me-2"></i>Verify Email
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-12">
                                        <div class="card border-success">
                                            <div class="card-body text-center">
                                                <i class="fas fa-envelope fa-2x text-success mb-2"></i>
                                                <h6 class="card-title">Email Verified ✓</h6>
                                                <p class="card-text small text-muted">{{ $user->email }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif

                        {{-- Phone Verification --}}
                        @if ($currentVerificationStep === 'phone')
                            @if (!$phone_code_sent)
                                <div class="text-center mb-4">
                                    <i class="fas fa-sms fa-3x text-primary mb-3"></i>
                                    <h6 class="mb-2">Verify Your Phone Number</h6>
                                    <p class="mb-2">We'll send a verification code to:</p>
                                    <strong class="text-success">{{ $phone }}</strong>
                                    <p class="text-muted small mt-2">This helps us keep your account secure.</p>
                                </div>
                                <div class="d-grid gap-2">
                                    <button class="btn btn-primary btn-lg" wire:click="sendPhoneVerificationCode"
                                        wire:loading.attr="disabled">
                                        <span wire:loading.remove wire:target="sendPhoneVerificationCode">
                                            <i class="fas fa-paper-plane me-2"></i>Send Code
                                        </span>
                                        <span wire:loading wire:target="sendPhoneVerificationCode">
                                            <span class="spinner-border spinner-border-sm me-2"></span>Sending...
                                        </span>
                                    </button>
                                    <button class="btn btn-outline-secondary" wire:click="goBackToChoice">
                                        <i class="fas fa-arrow-left me-2"></i>Back
                                    </button>
                                </div>
                            @else
                                <form wire:submit.prevent="verifyPhoneNumber">
                                    <div class="text-center mb-4">
                                        <i class="fas fa-key fa-3x text-success mb-3"></i>
                                        <h6 class="mb-2">Enter Verification Code</h6>
                                        <p class="mb-2">Enter the 6-digit code sent to:</p>
                                        <strong class="text-success">{{ $phone }}</strong>
                                    </div>

                                    <div class="mb-4">
                                        <input type="text"
                                            class="form-control form-control-lg text-center @error('phone_verification_code') is-invalid @enderror"
                                            wire:model.defer="phone_verification_code" placeholder="000000" maxlength="6"
                                            style="letter-spacing: 0.5em; font-size: 1.5rem;">
                                        @error('phone_verification_code')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-success btn-lg" wire:loading.attr="disabled">
                                            <span wire:loading.remove wire:target="verifyPhoneNumber">
                                                <i class="fas fa-check me-2"></i>Verify Phone
                                            </span>
                                            <span wire:loading wire:target="verifyPhoneNumber">
                                                <span class="spinner-border spinner-border-sm me-2"></span>Verifying...
                                            </span>
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary" wire:click="sendPhoneVerificationCode">
                                            <i class="fas fa-redo me-2"></i>Resend Code
                                        </button>
                                        <button class="btn btn-outline-secondary" wire:click="goBackToChoice">
                                            <i class="fas fa-arrow-left me-2"></i>Back
                                        </button>
                                    </div>
                                </form>
                            @endif
                        @endif

                        {{-- Email Verification --}}
                        @if ($currentVerificationStep === 'email')
                            @if (!$email_code_sent)
                                <div class="text-center mb-4">
                                    <i class="fas fa-envelope fa-3x text-info mb-3"></i>
                                    <h6 class="mb-2">Verify Your Email Address</h6>
                                    <p class="mb-2">We'll send a verification code to:</p>
                                    <strong class="text-info">{{ $user->email }}</strong>
                                    <p class="text-muted small mt-2">Check your inbox and spam folder.</p>
                                </div>
                                <div class="d-grid gap-2">
                                    <button class="btn btn-primary btn-lg" wire:click="sendEmailVerificationCode"
                                        wire:loading.attr="disabled">
                                        <span wire:loading.remove wire:target="sendEmailVerificationCode">
                                            <i class="fas fa-paper-plane me-2"></i>Send Code
                                        </span>
                                        <span wire:loading wire:target="sendEmailVerificationCode">
                                            <span class="spinner-border spinner-border-sm me-2"></span>Sending...
                                        </span>
                                    </button>
                                    <button class="btn btn-outline-secondary" wire:click="goBackToChoice">
                                        <i class="fas fa-arrow-left me-2"></i>Back
                                    </button>
                                </div>
                            @else
                                <form wire:submit.prevent="verifyEmailAddress">
                                    <div class="text-center mb-4">
                                        <i class="fas fa-key fa-3x text-success mb-3"></i>
                                        <h6 class="mb-2">Enter Verification Code</h6>
                                        <p class="mb-2">Enter the 6-digit code sent to:</p>
                                        <strong class="text-info">{{ $user->email }}</strong>
                                    </div>

                                    <div class="mb-4">
                                        <input type="text"
                                            class="form-control form-control-lg text-center @error('email_verification_code') is-invalid @enderror"
                                            wire:model.defer="email_verification_code" placeholder="000000" maxlength="6"
                                            style="letter-spacing: 0.5em; font-size: 1.5rem;">
                                        @error('email_verification_code')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-success btn-lg" wire:loading.attr="disabled">
                                            <span wire:loading.remove wire:target="verifyEmailAddress">
                                                <i class="fas fa-check me-2"></i>Verify Email
                                            </span>
                                            <span wire:loading wire:target="verifyEmailAddress">
                                                <span class="spinner-border spinner-border-sm me-2"></span>Verifying...
                                            </span>
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary" wire:click="sendEmailVerificationCode">
                                            <i class="fas fa-redo me-2"></i>Resend Code
                                        </button>
                                        <button class="btn btn-outline-secondary" wire:click="goBackToChoice">
                                            <i class="fas fa-arrow-left me-2"></i>Back
                                        </button>
                                    </div>
                                </form>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
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
                <!-- Single form with dynamic submission -->
                <form wire:submit.prevent="submitForm">

                    @if ($currentStep == 1)
                        <!-- Step 1: Basic Details -->
                        <div class="step-content">
                            <h6 class="mb-3">Tell us about your fund raising</h6>

                            <div class="mb-3">
                                <label for="title" class="form-text"><strong>Title *</strong></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                                    wire:model="title" placeholder="e.g., Sarah's Birthday Fund">
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
                                    <option value="Retirement">Retirement</option>
                                    <option value="business_support">Business Support</option>
                                    <option value="school_fees">School Fees</option>
                                    <option value="Others">Others</option>
                                </select>
                                @error('reason')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-text"><strong> Description *</strong></label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                                    wire:model="description" rows="4"
                                    placeholder="Tell people what this gift is for and why it's special..."></textarea>
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
                                <!-- Target Amount -->
                                <div class="col-md-6 mb-3">
                                    <label for="target_amount" class="form-text"><strong> Amount To Raise (₦)
                                            *</strong></label>
                                    <input type="number" class="form-control @error('target_amount') is-invalid @enderror"
                                        id="target_amount" wire:model.live="target_amount" min="1" step="0.01">
                                    @error('target_amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                    <!-- Checkbox -->
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" id="include_fee"
                                            wire:model.live="include_fee">
                                        <label class="form-text" for="include_fee">
                                            Do you want Famlic commission fee (5%) to be added to your target amount?
                                        </label>
                                    </div>

                                    <!-- Live display of adjusted amount -->
                                    @if(is_numeric($finalTargetAmount) && $finalTargetAmount > 0)
                                        <div class="form-text text-success">
                                            Final Amount to Raise: ₦{{ number_format($finalTargetAmount, 2) }}
                                        </div>
                                    @endif
                                </div>

                             <!-- Deadline -->
                            <div class="col-md-6 mb-3">
                                <label for="deadline" class="form-text">
                                    <strong> Deadline (Max of 60 days) *</strong>
                                </label>
                                <input
                                    type="date"
                                    class="form-control @error('deadline') is-invalid @enderror"
                                    id="deadline"
                                    wire:model.live="deadline"
                                    min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                    max="{{ date('Y-m-d', strtotime('+60 days')) }}"
                                    value="{{ old('deadline', date('Y-m-d', strtotime('+59 days'))) }}"
                                    required>
                                @error('deadline')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <!-- Gift Image Upload -->
                            <div class="mb-3">
                                <label for="gift_image" class="form-text"><strong> Image (Optional)</strong></label>
                                <input type="file" class="form-control @error('gift_image') is-invalid @enderror"
                                    id="gift_image" wire:model="gift_image" accept="image/*">
                                @error('gift_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <div class="form-text">Upload an image that will convince people to send you money (Max:
                                    2MB)</div>

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

                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_public" wire:model="is_public">
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
                                            ₦{{ number_format($finalTargetAmount ?: 0, 2) }}</small>
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
                    <div class="d-flex justify-content-start gap-2 mt-4">
                        @if ($currentStep > 1)
                            <button type="button" class="btn btn-outline-secondary" wire:click="previousStep">
                                <i class="fas fa-arrow-left me-1"></i> Previous
                            </button>
                        @endif

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

                </form>
            </div>
        </div>
    </div>
</div>
