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

        {{-- Page Header --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h3 class="mb-1">
                                    <i class="fas fa-money-bill-wave text-primary me-2"></i>
                                    Withdrawal
                                </h3>
                                <p class="text-muted mb-0">Withdraw funds from your wallet</p>
                            </div>
                            <div class="text-end">
                                <h4 class="mb-0 text-success">₦{{ number_format($balance, 2) }}</h4>
                                <small class="text-muted">Withdrawable Balance</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            {{-- Withdrawal Form --}}
            <div class="col-lg-8 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-grey border-bottom-0">
                        <h5 class="mb-0">
                            <i class="fas fa-wallet text-primary me-2"></i>
                            Make Withdrawal
                        </h5>
                    </div>
                    <div class="card-body">
                        <form wire:submit.prevent="submit">
                            {{-- Bank Details Section --}}
                            <div class="mb-4">
                                <h5 class="text-muted mb-3">Bank Details</h5>
                                @if ($bank_name && $account_number && $account_name)
                                    <div class="p-3  rounded border">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6 class="text-muted mb-0">Bank Name</h6>
                                                <div class="text-muted mb-0">{{ $bank_name }}</div>
                                            </div>
                                            <div class="col-md-6">
                                                <h6 class="text-muted mb-0">Account Number</h6>
                                                <div class="text-muted mb-0 font-monospace">{{ $account_number }}</div>
                                            </div>
                                            <div class="col-12 mt-2">
                                                <h6 class="text-muted mb-0">Account Name</h6>
                                                <div class="text-muted mb-0">{{ $account_name }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="text-center py-4 bg-light rounded">
                                        <i class="fas fa-university text-muted fa-3x mb-3"></i>
                                        <p class="text-muted mb-2">No bank details found</p>
                                        <button type="button" class="btn btn-primary" wire:click="openBankModal">
                                            <i class="fas fa-plus me-1"></i>
                                            Add Bank Details
                                        </button>
                                    </div>
                                @endif
                            </div>

                            {{-- Transaction PIN Section --}}
                            @if (!$transaction_pin)
                                    <div class="text-center py-4 bg-warning-subtle rounded">
                                        <i class="fas fa-exclamation-triangle text-warning fa-3x mb-3"></i>
                                        <p class="text-warning mb-2">Transaction PIN not set</p>
                                        <button type="button" class="btn btn-warning" wire:click="openPinModal">
                                            <i class="fas fa-plus me-1"></i>
                                            Set Transaction PIN
                                        </button>
                                    </div>
                                @endif


                            {{-- Amount Section --}}
                            <div class="mb-4">
                                <label class="text-muted mb-0">Withdrawal Amount <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">₦</span>
                                    <input type="number"
                                           class="form-control @error('amount') is-invalid @enderror"
                                           wire:model.defer="amount"
                                           placeholder="Enter amount to withdraw"
                                           min="100"
                                           max="{{ $balance }}"
                                           step="0.01">
                                    @error('amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Minimum withdrawal: ₦100 • Maximum: ₦{{ number_format($balance, 2) }}
                                </div>
                            </div>

                            {{-- Commission Note --}}
                            <div class="alert alert-info mb-4">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Commission Fee:</strong> A 5% commission fee will be deducted from your withdrawal amount.
                            </div>

                            {{-- Submit Button --}}
                            <div class="d-grid">
                                <button type="submit"
                                        class="btn btn-primary btn-lg"
                                        @if(!$bank_name || !$account_number || !$account_name || !$transaction_pin) disabled @endif>
                                    <i class="fas fa-money-bill-wave me-2"></i>
                                    Proceed to Withdrawal
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Recent Withdrawals --}}
            <div class="col-lg-4 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-grey border-bottom-0">
                        <h5 class="mb-0">
                            <i class="fas fa-history text-primary me-2"></i>
                            Recent Withdrawals
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        @if ($withdrawals->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach ($withdrawals as $withdrawal)
                                    <div class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="mb-1">₦{{ number_format($withdrawal->amount, 2) }}</h6>
                                                <small class="text-muted">{{ $withdrawal->reference }}</small>
                                            </div>
                                            <div class="text-end">
                                                <span class="badge bg-{{ $withdrawal->status == 'success' ? 'success' : ($withdrawal->status == 'pending' ? 'warning' : 'danger') }}">
                                                    {{ ucfirst($withdrawal->status) }}
                                                </span>
                                                <small class="text-muted d-block">{{ $withdrawal->created_at->format('M d, Y') }}</small>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="p-3">
                                {{ $withdrawals->links() }}
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-history text-muted fa-3x mb-3"></i>
                                <p class="text-muted mb-0">No withdrawal history</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- MODALS --}}

        {{-- Bank Details Modal --}}
        @if ($showBankModal)
            <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content theme-sensitive">
                        <form wire:submit.prevent="saveBankDetails">
                            <div class="modal-header">
                                <h5 class="modal-title">
                                    <i class="fas fa-university text-primary me-2"></i>
                                    {{ $bank_name && $account_number && $account_name ? 'Update' : 'Add' }} Bank Details
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
                                   @error('account_name')
                                   <div class="invalid-feedback">{{ $message }}</div>
                                   @enderror

                                   @if ($account_name)
                                   <label class="form-label">Account Name</label>

                                   <input type="text"
                                       class="form-control @error('account_name') is-invalid @enderror"
                                       wire:model="account_name"
                                       readonly
                                       placeholder="Will be auto‑filled after validation">
                                        <div class="form-text text-success">
                                            <i class="fas fa-check-circle me-1"></i>
                                            Account validated successfully
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" wire:click="closeBankModal">Cancel</button>
                                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled"
                                    @if (!$account_name) disabled @endif>
                                    <span wire:loading.remove>Save Bank Details</span>
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
                                    <label class="form-label">{{ $transaction_pin ? 'New' : '' }} Transaction PIN</label>
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
                                        class="form-control @error('new_transaction_pin_confirmation') is-invalid @enderror"
                                        wire:model.defer="new_transaction_pin_confirmation" placeholder="Confirm 4-digit PIN"
                                        maxlength="4">
                                    @error('new_transaction_pin_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" wire:click="closePinModal">Cancel</button>
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

        {{-- Withdrawal Confirmation Modal --}}
        @if ($showConfirmModal)
            <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content theme-sensitive">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                Confirm Withdrawal
                            </h5>
                            <button type="button" class="btn-close" wire:click="closeConfirmModal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="text-center mb-4">
                                <i class="fas fa-money-bill-wave text-primary fa-3x mb-3"></i>
                                <h4 class="text-primary">₦{{ number_format($amount, 2) }}</h4>
                                <p class="text-muted">Withdrawal Amount</p>
                            </div>

                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">Payment Summary</h6>
                                    <div class="row mb-2">
                                        <div class="col">Amount:</div>
                                        <div class="col-auto">₦{{ number_format($amount, 2) }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">Commission Fee (5%):</div>
                                        <div class="col-auto text-danger">-₦{{ number_format($amount * 0.05, 2) }}</div>
                                    </div>
                                    <hr>
                                    <div class="row fw-bold">
                                        <div class="col">You will receive:</div>
                                        <div class="col-auto text-success">₦{{ number_format($amount * 0.95, 2) }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3">
                                <h6>Payment will be made to:</h6>
                                <ul class="list-unstyled">
                                    <li><strong>Bank:</strong> {{ $bank_name }}</li>
                                    <li><strong>Account Name:</strong> {{ $account_name }}</li>
                                    <li><strong>Account Number:</strong> {{ $account_number }}</li>
                                </ul>
                            </div>

                            <div class="mt-3">
                                <label class="form-label">Enter Transaction PIN</label>
                                <input type="password" class="form-control @error('pin') is-invalid @enderror"
                                    wire:model.defer="pin" placeholder="Enter your 4-digit PIN" maxlength="4">
                                @error('pin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="closeConfirmModal">Cancel</button>
                            <button type="button" class="btn btn-success" wire:click="confirmWithdrawal" wire:loading.attr="disabled">
                                <span wire:loading.remove>
                                    <i class="fas fa-check me-1"></i>
                                    Confirm Withdrawal
                                </span>
                                <span wire:loading>
                                    <span class="spinner-border spinner-border-sm me-2"></span>
                                    Processing...
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
