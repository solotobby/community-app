<div class="content">
    <div class="container-fluid py-4">
        {{-- Success & Error Alerts --}}
        @if (session()->has('success'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform translate-y-2"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform translate-y-0"
                x-transition:leave-end="opacity-0 transform translate-y-2"
                class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" @click="show = false"></button>
            </div>
        @endif

        @if (session()->has('error'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform translate-y-2"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform translate-y-0"
                x-transition:leave-end="opacity-0 transform translate-y-2"
                class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" @click="show = false"></button>
            </div>
        @endif

        {{-- Profile Header --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar-container me-3">
                                <div
                                    class="avatar bg-primary text-black d-flex align-items-center justify-content-center">
                                    {{ strtoupper(substr($name, 0, 2)) }}
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h3 class="mb-1">{{ $name }}</h3>
                                <p class="text-muted mb-0">{{ $email }}</p>
                                <small class="text-muted">
                                    <i class="fas fa-star text-warning me-1"></i>
                                    Level: {{ $level->name ?? 'Not assigned' }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            {{-- Personal Information --}}
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-grey border-bottom-0 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-user text-primary me-2"></i>
                            Personal Information
                        </h5>
                        <button class="btn btn-outline-primary btn-sm" wire:click="openUserModal">
                            <i class="fas fa-key me-1"></i>
                            Change Password
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label text-muted">Full Name</label>
                                <div class="fw-bold text-muted">{{ $name }}</div>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label text-muted">Email Address</label>
                                <div class="fw-bold text-muted">{{ $email }}</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted">Referral Code</label>
                                <div class="d-flex align-items-center">
                                    <code class="bg-light px-2 py-1 rounded me-2">{{ $referral_code }}</code>
                                    <button class="btn btn-outline-secondary btn-sm"
                                        onclick="copyToClipboard('{{ config('app.url') . '/register?ref=' . $referral_code }}')">
                                        <i class="fas fa-copy"></i>
                                    </button>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted">Referred By</label>
                                <div class="fw-bold text-muted">{{ $referred_by ?? 'Direct signup' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Contact Information --}}
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-grey border-bottom-0 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-address-book text-primary me-2"></i>
                            Contact Information
                        </h5>
                        <button class="btn btn-outline-primary btn-sm" wire:click="openContactModal">
                            <i class="fas fa-edit me-1"></i>
                            {{ $phone && $address ? 'Update' : 'Add' }} Details
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label text-muted">Phone Number</label>
                                <div class="d-flex align-items-center">
                                    <div class="fw-bold text-muted font-monospace">{{ $phone ?? 'Not provided' }}
                                    </div>
                                    @if ($phone && !$phone_verified)
                                        <span class="badge bg-warning text-dark">
                                            <i class="fas fa-exclamation-triangle me-1"></i>
                                            Unverified
                                        </span>
                                        <button class="btn btn-link btn-sm p-0 ms-2"
                                            wire:click="openPhoneVerificationModal">
                                            Verify Now
                                        </button>
                                    @elseif($phone && $phone_verified)
                                        <span class="badge bg-success">
                                            <i class="fas fa-check me-1"></i>
                                            Verified
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label text-muted">Date of Birth</label>
                                <div class="fw-bold text-muted">{{ $dob ?? 'Not provided' }}</div>
                            </div>
                            <div class="col-12">
                                <label class="form-label text-muted">Address</label>
                                <div class="fw-bold text-muted">{{ $address ?? 'Not provided' }}</div>
                            </div>
                            <div class="col-12">
                                <label class="form-label text-muted">Landmark</label>
                                <div class="fw-bold text-muted">{{ $landmark ?? 'Not provided' }}</div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-muted">LGA</label>
                                <div class="fw-bold text-muted">{{ $lga ?? 'Not provided' }}</div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-muted">State</label>
                                <div class="fw-bold text-muted">{{ $state ?? 'Not provided' }}</div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-muted">Country</label>
                                <div class="fw-bold text-muted">{{ $country ?? 'Not provided' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Security Settings --}}
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-grey border-bottom-0">
                        <h5 class="mb-0">
                            <i class="fas fa-shield-alt text-primary me-2"></i>
                            Security Settings
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded mb-3">
                            <div>
                                <div class="fw-medium">Transaction PIN</div>
                                <small class="text-muted">
                                    @if ($transaction_pin)
                                        <i class="fas fa-check-circle text-success me-1"></i>
                                        PIN is configured and secure
                                    @else
                                        <i class="fas fa-exclamation-triangle text-warning me-1"></i>
                                        No PIN set - transactions may be restricted
                                    @endif
                                </small>
                            </div>
                            <button class="btn btn-outline-primary btn-sm" wire:click="openPinModal">
                                <i class="fas fa-{{ $transaction_pin ? 'edit' : 'plus' }} me-1"></i>
                                {{ $transaction_pin ? 'Change' : 'Set' }} PIN
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bank Information --}}
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-grey border-bottom-0 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-university text-primary me-2"></i>
                            Bank Information
                        </h5>
                        @if (!$bank_name || !$account_number || !$account_name)
                            <button class="btn btn-outline-primary btn-sm" wire:click="openBankModal">
                                <i class="fas fa-plus me-1"></i>
                                Add Bank Details
                            </button>
                        @else
                        @endif
                    </div>
                    <div class="card-body">
                        @if ($bank_name && $account_number && $account_name)
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label text-muted">Bank Name</label>
                                    <div class="fw-bold text-muted">{{ $bank_name }}</div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label text-muted">Account Number</label>
                                    <div class="fw-bold text-muted font-monospace">{{ $account_number }}</div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label text-muted">Account Name</label>
                                    <div class="fw-bold text-muted">{{ $account_name }}</div>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-university text-muted fa-3x mb-3"></i>
                                <p class="text-muted mb-0">No bank details added yet</p>
                                <small class="text-muted">Add your bank details to receive payments</small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- MODALS --}}

        {{-- Change Password Modal --}}
        @if ($showUserModal)
            <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content theme-sensitive">
                        <form wire:submit.prevent="updateUserDetails">
                            <div class="modal-header">
                                <h5 class="modal-title">
                                    <i class="fas fa-key text-primary me-2"></i>
                                    Change Password
                                </h5>
                                <button type="button" class="btn-close" wire:click="closeUserModal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Current Password</label>
                                    <input type="password"
                                        class="form-control @error('current_password') is-invalid @enderror"
                                        wire:model.defer="current_password" placeholder="Enter your current password">
                                    @error('current_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">New Password</label>
                                    <input type="password"
                                        class="form-control @error('new_password') is-invalid @enderror"
                                        wire:model.defer="new_password"
                                        placeholder="Enter new password (min 6 characters)">
                                    @error('new_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Confirm New Password</label>
                                    <input type="password"
                                        class="form-control @error('new_password_confirmation') is-invalid @enderror"
                                        wire:model.defer="new_password_confirmation"
                                        placeholder="Confirm your new password">
                                    @error('new_password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    wire:click="closeUserModal">Cancel</button>
                                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                                    <span wire:loading.remove>Update Password</span>
                                    <span wire:loading>
                                        <span class="spinner-border spinner-border-sm me-2"></span>
                                        Updating...
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif

        {{-- Transaction PIN Modal --}}
        @if ($showPinModal)
            <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content theme-sensitive">
                        <form wire:submit.prevent="saveTransactionPin">
                            <div class="modal-header">
                                <h5 class="modal-title">
                                    <i class="fas fa-shield-alt text-primary me-2"></i>
                                    {{ $transaction_pin ? 'Change' : 'Set' }} Transaction PIN
                                </h5>
                                <button type="button" class="btn-close" wire:click="closePinModal"></button>
                            </div>
                            <div class="modal-body">
                                @if ($transaction_pin)
                                    <div class="mb-3">
                                        <label class="form-label">Current PIN</label>
                                        <input type="password"
                                            class="form-control @error('current_pin') is-invalid @enderror"
                                            wire:model.defer="current_pin" placeholder="Enter current PIN"
                                            maxlength="4">
                                        @error('current_pin')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endif
                                <div class="mb-3">
                                    <label class="form-label">{{ $transaction_pin ? 'New' : '' }} Transaction
                                        PIN</label>
                                    <input type="password"
                                        class="form-control @error('new_transaction_pin') is-invalid @enderror"
                                        wire:model.defer="new_transaction_pin" placeholder="Enter 4-digit PIN"
                                        maxlength="4">
                                    <div class="form-text">PIN must be exactly 4 digits</div>
                                    @error('new_transaction_pin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Confirm PIN</label>
                                    <input type="password"
                                        class="form-control @error('confirm_transaction_pin') is-invalid @enderror"
                                        wire:model.defer="confirm_transaction_pin" placeholder="Confirm 4-digit PIN"
                                        maxlength="4">
                                    @error('confirm_transaction_pin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    wire:click="closePinModal">Cancel</button>
                                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                                    <span wire:loading.remove>{{ $transaction_pin ? 'Update' : 'Set' }} PIN</span>
                                    <span wire:loading>
                                        <span class="spinner-border spinner-border-sm me-2"></span>
                                        Processing...
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif

        {{-- Bank Details Modal --}}
        @if ($showBankModal)
            <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content theme-sensitive">
                        <form wire:submit.prevent="saveBankDetails">
                            <div class="modal-header">
                                <h5 class="modal-title">
                                    <i class="fas fa-university text-primary me-2"></i>
                                    {{ $bank_name && $account_number && $account_name ? 'Update' : 'Add' }} Bank
                                    Details
                                </h5>
                                <button type="button" class="btn-close" wire:click="closeBankModal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Bank Name <span class="text-danger">*</span></label>
                                    <select class="form-select @error('bank_name') is-invalid @enderror"
                                        wire:model="bank_name">
                                        <option value="">-- Select Bank --</option>
                                        @foreach ($banks as $bank)
                                            <option value="{{ $bank['name'] }}">{{ $bank['name'] }}</option>
                                        @endforeach
                                    </select>
                                    @error('bank_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Account Number <span class="text-danger">*</label>
                                    <div class="input-group" x-data="{ number: @entangle('account_number') }"
                                        x-effect="if(number.length === 10) { $wire.validateAccount() }">
                                        <input type="text" maxlength="10"
                                            class="form-control @error('account_number') is-invalid @enderror"
                                            x-model="number" placeholder="Enter 10-digit account number">

                                        <button type="button" class="btn btn-outline-secondary"
                                            wire:click="validateAccount" wire:loading.attr="disabled"
                                            wire:target="validateAccount">
                                            <span wire:loading.remove wire:target="validateAccount">Validate</span>
                                            <span wire:loading wire:target="validateAccount">
                                                <span class="spinner-border spinner-border-sm"></span>
                                            </span>
                                        </button>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Account Name</label>
                                    <input type="text"
                                        class="form-control @error('account_name') is-invalid @enderror"
                                        wire:model="account_name" readonly
                                        placeholder="Will be auto-filled after validation">
                                    @error('account_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @if ($account_name)
                                        <div class="form-text text-success">
                                            <i class="fas fa-check-circle me-1"></i>
                                            Account validated successfully
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    wire:click="closeBankModal">Cancel</button>
                                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled"
                                    @if (!$account_name) disabled @endif>
                                    <span wire:loading.remove>Save Bank Details</span>
                                    <span wire:loading>
                                        <span class="spinner-border spinner-border-sm me-2"></span>
                                        Saving...
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif

        {{-- Contact Information Modal --}}
        @if ($showContactModal)
            <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content theme-sensitive">
                        <form wire:submit.prevent="saveContactInfo">
                            <div class="modal-header">
                                <h5 class="modal-title">
                                    <i class="fas fa-address-book text-primary me-2"></i>
                                    Update Contact Information
                                </h5>
                                <button type="button" class="btn-close" wire:click="closeContactModal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                        wire:model.defer="phone" placeholder="e.g., +234 801 234 5678">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Date of Birth <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('dob') is-invalid @enderror"
                                        wire:model.defer="dob" placeholder="Select your date of birth">
                                    @error('dob')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Address <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('address') is-invalid @enderror" wire:model.defer="address" rows="3"
                                        placeholder="Enter your full address"></textarea>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Landmark (Optional)</label>
                                    <input type="text"
                                        class="form-control @error('landmark') is-invalid @enderror"
                                        wire:model.defer="landmark" placeholder="e.g., Near City Mall">
                                    @error('landmark')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Local Government Area <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('lga') is-invalid @enderror"
                                        wire:model.defer="lga" placeholder="e.g., Ikeja">
                                    @error('lga')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">State <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('state') is-invalid @enderror"
                                        wire:model.defer="state" placeholder="e.g., Lagos">
                                    @error('state')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Country <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('country') is-invalid @enderror"
                                        wire:model.defer="country" placeholder="e.g., Nigeria">
                                    @error('country')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    wire:click="closeContactModal">Cancel</button>
                                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                                    <span wire:loading.remove">Save Contact Info</span>
                                    <span wire:loading>
                                        <span class="spinner-border spinner-border-sm me-2"></span>
                                        Saving...
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif

        {{-- Phone Verification Modal --}}
        @if ($showPhoneVerificationModal)
            <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content theme-sensitive">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                <i class="fas fa-mobile-alt text-primary me-2"></i>
                                Verify Phone Number
                            </h5>
                            <button type="button" class="btn-close"
                                wire:click="closePhoneVerificationModal"></button>
                        </div>
                        <div class="modal-body">
                            @if (!$verification_code_sent)
                                <div class="text-center mb-4">
                                    <i class="fas fa-sms fa-3x text-primary mb-3"></i>
                                    <p class="mb-0">We'll send a verification code to:</p>
                                    <strong>{{ $phone }}</strong>
                                </div>
                                <div class="d-grid">
                                    <button class="btn btn-primary" wire:click="sendVerificationCode"
                                        wire:loading.attr="disabled">
                                        <span wire:loading.remove wire:target="sendVerificationCode">
                                            <i class="fas fa-paper-plane me-2"></i>
                                            Send Verification Code
                                        </span>
                                        <span wire:loading wire:target="sendVerificationCode">
                                            <span class="spinner-border spinner-border-sm me-2"></span>
                                            Sending...
                                        </span>
                                    </button>
                                </div>
                            @else
                                <form wire:submit.prevent="verifyPhoneNumber">
                                    <div class="text-center mb-4">
                                        <i class="fas fa-key fa-3x text-success mb-3"></i>
                                        <p class="mb-2">Enter the 6-digit code sent to:</p>
                                        <strong>{{ $phone }}</strong>
                                        <p class="small text-muted mt-2">Didn't receive the code?
                                            <button type="button" class="btn btn-link btn-sm p-0"
                                                wire:click="resendVerificationCode">
                                                Resend Code
                                            </button>
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <input type="text"
                                            class="form-control form-control-lg text-center @error('verification_code') is-invalid @enderror"
                                            wire:model.defer="verification_code" placeholder="000000" maxlength="6"
                                            style="letter-spacing: 0.5em; font-size: 1.5rem;">
                                        @error('verification_code')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-success" wire:loading.attr="disabled">
                                            <span wire:loading.remove wire:target="verifyPhoneNumber">
                                                <i class="fas fa-check me-2"></i>
                                                Verify Phone Number
                                            </span>
                                            <span wire:loading wire:target="verifyPhoneNumber">
                                                <span class="spinner-border spinner-border-sm me-2"></span>
                                                Verifying...
                                            </span>
                                        </button>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <style>
    .theme-sensitive {
        background-color: #ffffff;
        color: #212529;
    }

    @media (prefers-color-scheme: dark) {
        .theme-sensitive {
            background-color: #1e1e1e !important;
            color: #f1f1f1 !important;
        }

        .theme-sensitive .form-control {
            background-color: #2b2b2b;
            color: #f1f1f1;
            border-color: #444;
        }

        .theme-sensitive .form-control::placeholder {
            color: #aaa;
        }

        .theme-sensitive .modal-header {
            border-bottom-color: #333;
        }

        .theme-sensitive .modal-footer {
            border-top-color: #333;
        }

        .theme-sensitive .btn-close {
            filter: invert(1);
        }

        .theme-sensitive .invalid-feedback {
            color: #ff8888;
        }
    }
</style>


    <style>
        .avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            font-size: 1.5rem;
            font-weight: bold;
        }

        .card {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
        }

        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }

        .btn {
            transition: all 0.2s ease-in-out;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .modal-content {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            border-bottom: 1px solid #e9ecef;
            border-radius: 15px 15px 0 0;
        }

        .badge {
            font-size: 0.75rem;
        }

        code {
            font-size: 0.9rem;
        }


        .theme-sensitive {
            background-color: white;
            color: #212529;
        }

        @media (prefers-color-scheme: dark) {
            .theme-sensitive {
                background-color: #2c2f33 !important;
                color: #f1f1f1 !important;
            }
        }
    </style>

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                // You can add a toast notification here
                alert('Referral code copied to clipboard!');
            });
        }
    </script>
</div>
