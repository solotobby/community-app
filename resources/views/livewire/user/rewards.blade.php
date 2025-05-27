<div>
    <div class="content">
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

        <div class="container-fluid p-0 m-0">
            <div class="card border-0">
                <div class="card-header">
                    <h5 class="mb-0">My Referral Rewards</h5>
                </div>
                <div class="card-body p-2 table-responsive">
                    <table class="table table-bordered table-hover" style="background-color: transparent;">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 50px;">S/N</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Currency</th>
                                <th>Status</th>
                                <th>Claimed</th>
                                <th>Referred User</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($rewards as $reward)
                                <tr>
                                    <th class="text-center" scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ ucfirst($reward->reward_type) }}</td>
                                    <td>{{ number_format($reward->amount, 2) }}</td>
                                    <td>{{ strtoupper($reward->currency) }}</td>
                                    <td>
                                        <span
                                            class="badge {{ $reward->reward_status === 'earned' ? 'bg-success' : 'bg-warning text-dark' }}">
                                            {{ ucfirst($reward->reward_status) }}
                                        </span>
                                    </td>
                                    <td>{{ $reward->is_claim ? 'Yes' : 'No' }}</td>
                                    <td>{{ $reward->referrer->name ?? '-' }}</td>
                                    <td>
                                        @if (!$reward->is_claim && $reward->reward_status === 'pending')
                                            <button wire:click="openClaimModal({{ $reward->id }})"
                                                class="btn btn-sm btn-success">
                                                Claim Now
                                            </button>
                                        @else
                                            <span class="text-muted">Claimed</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No rewards found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-2">
                        {{ $rewards->links() }}
                    </div>
                </div>
            </div>
        </div>

        {{-- Claim Modal --}}
        @if ($showClaimModal && $selectedReward)
            <div class="modal fade show d-block" tabindex="-1" role="dialog" style="background: rgba(0,0,0,0.5);">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Confirm Payout</h5>
                            <button type="button" class="btn-close"
                                wire:click="closeClaimModal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-info">
                                <strong>Reward Amount:</strong> ₦{{ number_format($selectedReward->amount, 2) }}
                            </div>

                            <p>Payment will be made to the following bank account:</p>
                            <ul class="list-unstyled">
                                <li><strong>Bank:</strong> {{ $bankInfo->bank_name }}</li>
                                <li><strong>Account Name:</strong> {{ $bankInfo->account_name }}</li>
                                <li><strong>Account Number:</strong> {{ $bankInfo->account_number }}</li>
                            </ul>

                            <div class="mt-3">
                                <label class="form-label">Enter Transaction PIN</label>
                                <input type="password" class="form-control @error('pin') is-invalid @enderror"
                                    wire:model="pin" placeholder="Enter your 4-digit transaction PIN" maxlength="4">
                                @error('pin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button wire:click="confirmClaim" class="btn btn-success w-100 mt-3"
                                wire:loading.attr="disabled" wire:target="confirmClaim">
                                <span wire:loading.remove wire:target="confirmClaim">Confirm & Claim Reward</span>
                                <span wire:loading wire:target="confirmClaim">
                                    <span class="spinner-border spinner-border-sm me-2"></span>Processing...
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Set Transaction PIN Modal --}}
        @if ($showSetPinModal)
            <div class="modal fade show d-block" tabindex="-1" role="dialog"
                style="background-color: rgba(0,0,0,0.5);">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form wire:submit.prevent="saveTransactionPin">
                            <div class="modal-header">
                                <h5 class="modal-title">Set Transaction PIN</h5>
                                <button type="button" class="btn-close" wire:click="closeSetPinModal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="alert alert-info">
                                    <small>You need to set a transaction PIN to claim rewards. PIN must be 4
                                        digits.</small>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">New Transaction PIN</label>
                                    <input type="password"
                                        class="form-control @error('new_transaction_pin') is-invalid @enderror"
                                        wire:model="new_transaction_pin" placeholder="Enter 4 digit PIN" maxlength="4">
                                    @error('new_transaction_pin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Confirm Transaction PIN</label>
                                    <input type="password"
                                        class="form-control @error('new_transaction_pin_confirmation') is-invalid @enderror"
                                        wire:model="new_transaction_pin_confirmation" placeholder="Confirm your PIN"
                                        maxlength="4">
                                    @error('new_transaction_pin_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary" type="submit" wire:loading.attr="disabled" wire:target="saveTransactionPin">
                                    <span wire:loading.remove wire:target="saveTransactionPin">Set PIN & Continue</span>
                                    <span wire:loading wire:target="saveTransactionPin">
                                        <span class="spinner-border spinner-border-sm me-2"></span>Setting PIN...
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif

        {{-- Bank Modal --}}
        @if ($showBankModal)
            <div class="modal fade show d-block" tabindex="-1" role="dialog"
                style="background-color: rgba(0,0,0,0.5);">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form wire:submit.prevent="saveBankDetails">
                            <div class="modal-header">
                                <h5 class="modal-title">Add Bank Details</h5>
                                <button type="button" class="btn-close" wire:click="closeBankModal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Bank Name</label>
                                    <select class="form-control @error('bank_name') is-invalid @enderror"
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
                                    <label class="form-label">Account Number</label>
                                    <div class="input-group">
                                        <input type="text" maxlength="10"
                                            class="form-control @error('account_number') is-invalid @enderror"
                                            wire:model="account_number" placeholder="Enter 10-digit account number">
                                        <button type="button" class="btn btn-outline-secondary"
                                            wire:click="validateAccount" wire:loading.attr="disabled"
                                            wire:target="validateAccount">
                                            <span wire:loading.remove wire:target="validateAccount">Validate</span>
                                            <span wire:loading wire:target="validateAccount">
                                                <span class="spinner-border spinner-border-sm"></span>
                                            </span>
                                        </button>
                                    </div>
                                    @error('account_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Account Name</label>
                                    <input type="text"
                                        class="form-control @error('account_name') is-invalid @enderror"
                                        wire:model="account_name" readonly
                                        placeholder="Account name will appear after validation">
                                    @error('account_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary" type="submit"
                                    {{ !$account_name ? 'disabled' : '' }}
                                    wire:loading.attr="disabled" wire:target="saveBankDetails">
                                    <span wire:loading.remove wire:target="saveBankDetails">Save Bank Details</span>
                                    <span wire:loading wire:target="saveBankDetails">
                                        <span class="spinner-border spinner-border-sm me-2"></span>Saving...
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
