<div>
    <div class="content">
        <div class="p-4">
            {{-- <h2 class="text-xl font-semibold mb-4">Raffle Draw</h2> --}}

            {{-- Session Messages --}}

            @if (session()->has('success'))
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition
                    class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session()->has('error'))
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Raffle Draw Button --}}
            {{-- <div class="mb-4">
            <button wire:click="performDraw"
                class="bg-blue-500 hover:bg-blue-600 text-black font-bold py-2 px-4 rounded {{ $user->raffle_draw_count < 1 ? 'opacity-50 cursor-not-allowed' : '' }}"
                {{ $user->raffle_draw_count < 1 ? 'disabled' : '' }}>
                Play Raffle Draw
            </button>
            <p class="text-sm text-gray-600 mt-1">You have {{ $user->raffle_draw_count }} raffle draw(s) left</p>
        </div> --}}

            <div class="container-fluid p-0 m-0">
                <div class="card border-0">
                    <div class="card-header bg-grey d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-gift text-primary me-2"></i>
                            My Famlic Gift(s)
                        </h5>
                    </div>

                    <div class="card-body p-2 table-responsive">
                        <table class="table table-bordered table-hover" style="background-color: transparent;">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 50px;">S/N</th>
                                    <th>Gift ID</th>
                                    <th style="min-width: 200px;">Reward</th>
                                    <th>Status</th>
                                    <th>Claimed At</th>
                                    <th>Expires At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($draws as $draw)
                                    <tr>
                                        <th class="text-center" scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $draw->name ?? '-' }}</td>
                                        <td>
                                            @if ($draw->reward)
                                                @php
                                                    $rewards = is_string($draw->reward)
                                                        ? json_decode($draw->reward, true)
                                                        : $draw->reward;
                                                @endphp
                                                @if (is_array($rewards))
                                                    <ul class="list-unstyled mb-0">
                                                        @foreach ($rewards as $reward)
                                                            <li class="small">
                                                                <i class="fas fa-gift text-primary me-1"></i>
                                                                {{ is_array($reward) ? $reward['name'] ?? 'Unknown' : $reward }}
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    <span class="text-muted">{{ $draw->reward }}</span>
                                                @endif
                                            @else
                                                <span class="text-muted">No rewards specified</span>
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $badgeClass = match ($draw->status) {
                                                    'pending' => 'bg-warning text-dark',
                                                    'earned' => 'bg-success',
                                                    'expired' => 'bg-danger',
                                                    default => 'bg-secondary',
                                                };
                                            @endphp
                                            <span class="badge {{ $badgeClass }}">
                                                {{ ucfirst($draw->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $draw->claimed_at ? $draw->claimed_at->format('M d, Y H:i') : '-' }}</td>
                                        <td>
                                            @if ($draw->expired_at && $draw->status === 'earned')
                                                <span class="text-muted">-</span>
                                            @else
                                                {{ $draw->expired_at ? $draw->expired_at->format('M d, Y H:i') : '-' }}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($draw->status === 'pending' && now()->lt($draw->expired_at))
                                                <button wire:click="openClaimModal({{ $draw->id }})"
                                                    class="btn btn-sm btn-success">
                                                    Claim Now
                                                </button>
                                            @elseif ($draw->status === 'earned')
                                                <span class="text-muted">Claimed</span>
                                            @elseif ($draw->status === 'expired')
                                                <span class="text-muted">Expired</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No raffle draws found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        @if ($draws->hasPages())
                            <div class="mt-3 d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-muted">
                                        Page {{ $draws->currentPage() }} of {{ $draws->lastPage() }}
                                    </small>
                                </div>
                                <div>
                                    {{ $draws->links() }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>

        {{-- Contact Information Modal (First Modal) --}}
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
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <small>Please provide your contact information to complete the claim
                                        process.</small>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                        wire:model.defer="phone" placeholder="e.g., +234 801 234 5678">
                                    @error('phone')
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
                                    <input type="text" class="form-control @error('landmark') is-invalid @enderror"
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
                                    <span wire:loading.remove>Save Contact Info & Continue</span>
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

        {{-- Claim Modal --}}
        @if ($showClaimModal)
            <div class="modal fade show d-block" tabindex="-1" role="dialog" style="background: rgba(0,0,0,0.5);">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content theme-sensitive">
                        <div class="modal-header">
                            <h5 class="modal-title">Confirm Payout</h5>
                            <button type="button" class="btn-close"
                                wire:click="$set('showClaimModal', false)"></button>
                        </div>
                        <div class="modal-body">
                            <p>An equivalent amount for your winnings
                                <b>NGN{{ number_format($selectedDraw->price, 2) }}</b>
                                will be paid into your
                                account as we do not have a collection center close to you
                                <br>
                                    Payment will be made to the following bank account and a withdrawal fee of 2% will be deducted:
                            </p>
                            <ul class="list-unstyled">
                                <li><strong>Bank:</strong> {{ $bankInfo->bank_name }}</li>
                                <li><strong>Account Name:</strong> {{ $bankInfo->account_name }}</li>
                                <li><strong>Account Number:</strong> {{ $bankInfo->account_number }}</li>
                            </ul>

                            <div class="mt-3">
                                <label class="form-label">Enter Transaction PIN</label>
                                <input type="password" class="form-control @error('pin') is-invalid @enderror"
                                    wire:model="pin" placeholder="Enter your transaction PIN">
                                @error('pin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- <span wire:loading.remove>Update Password</span> --}}
                            <button wire:click="confirmClaim" class="btn btn-success w-100 mt-3">
                                Confirm & Claim Reward
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

        {{-- Set Transaction PIN Modal --}}
        @if ($showSetPinModal)
            <div class="modal fade show d-block" tabindex="-1" role="dialog"
                style="background-color: rgba(0,0,0,0.5);">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content theme-sensitive">
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
                                        wire:model="new_transaction_pin" placeholder="Enter 4 digit PIN"
                                        maxlength="4">
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
                                <button class="btn btn-primary" type="submit">Set PIN & Continue</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif

        {{-- Bank Modal --}}
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
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <small>Sorry, As we do not have a collection point in your area at the moment,
                                        an equivalent amount of your winnings will be made into the account details you
                                        submit below.</small>
                                </div>
                                <div class="mb-3">
                                    <label for="bank" class="form-label">Select Bank</label>
                                    <select id="bank" class="form-select" wire:model="bank_code">
                                        <option value="">-- Choose Bank --</option>
                                        @foreach ($banks as $bank)
                                            <option value="{{ $bank['code'] }}">{{ $bank['name'] }}</option>
                                        @endforeach
                                    </select>
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

</div>
