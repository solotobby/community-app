<div>
    <div class="p-4">
        {{-- <h2 class="text-xl font-semibold mb-4">Raffle Draw</h2> --}}

        {{-- Session Messages --}}

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

        {{-- Raffle Draw Button --}}
        {{-- <div class="mb-4">
            <button wire:click="performDraw"
                class="bg-blue-500 hover:bg-blue-600 text-black font-bold py-2 px-4 rounded {{ $user->raffle_draw_count < 1 ? 'opacity-50 cursor-not-allowed' : '' }}"
                {{ $user->raffle_draw_count < 1 ? 'disabled' : '' }}>
                Play Raffle Draw
            </button>
            <p class="text-sm text-gray-600 mt-1">You have {{ $user->raffle_draw_count }} raffle draw(s) left</p>
        </div> --}}

        {{-- Draw History --}}
        <div class="card border-0">
            <div class="card-header">
                <h5 class="mb-0">My Raffle Draw Reward(s)</h5>
            </div>
            <div class="card-body p-2 table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;">S/N</th>
                            <th>Raffle ID</th>
                            <th>Reward</th>
                            {{-- <th>Price</th> --}}
                            {{-- <th>Currency</th> --}}
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
                                    @foreach (json_decode($draw->reward, true) as $reward)
                                        <li>{{ $reward['name'] }}</li>
                                    @endforeach
                                </td>
                                {{-- <td>{{ number_format($draw->price, 2) }}</td> --}}
                                {{-- <td>{{ strtoupper($draw->currency) }}</td> --}}
                                <td>
                                    @if ($draw->status === 'pending')
                                        <span class="text-yellow-600 font-medium">Pending</span>
                                    @elseif ($draw->status === 'earned')
                                        <span class="text-green-600 font-medium">Claimed</span>
                                    @else
                                        <span class="text-red-600 font-medium">Expired</span>
                                    @endif
                                </td>
                                <td>{{ $draw->claimed_at ? $draw->claimed_at->format('M d, Y H:i') : '-' }}</td>
                                <td>{{ $draw->expired_at ? $draw->expired_at->format('M d, Y H:i') : '-' }}</td>
                                <td>
                                    @if ($draw->status === 'pending' && now()->lt($draw->expired_at))
                                        <button wire:click="openClaimModal({{ $draw->id }})"
                                            class="btn btn-sm btn-success">
                                            Claim Now
                                        </button>
                                    @elseif ($draw->status === 'earned')
                                        <span class="badge bg-success">Claimed</span>
                                    @elseif ($draw->status === 'expired')
                                        <span class="badge bg-danger">Expired</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-gray-500 py-4">No raffle draws yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Claim Modal --}}
    @if ($showClaimModal)
        <div class="modal fade show d-block" tabindex="-1" role="dialog" style="background: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirm Payout</h5>
                        <button type="button" class="btn-close" wire:click="$set('showClaimModal', false)"></button>
                    </div>
                    <div class="modal-body">
                        <p>An equivalent amount for your prizes <b>NGN{{ $draw->price }}</b> will be paid into your account as we do not have a collection center close to you</p>
                        <p>Payment will be made to the following bank account:</p>
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

                        <button wire:click="confirmClaim" class="btn btn-success w-100 mt-3">
                            Confirm & Claim Reward
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Set Transaction PIN Modal --}}
    @if ($showSetPinModal)
        <div class="modal fade show d-block" tabindex="-1" role="dialog" style="background-color: rgba(0,0,0,0.5);">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form wire:submit.prevent="saveTransactionPin">
                        <div class="modal-header">
                            <h5 class="modal-title">Set Transaction PIN</h5>
                            <button type="button" class="btn-close" wire:click="closeSetPinModal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-info">
                                <small>You need to set a transaction PIN to claim rewards. PIN must be 4 digits.</small>
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
                            <button class="btn btn-primary" type="submit">Set PIN & Continue</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    {{-- Bank Modal --}}
    @if ($showBankModal)
        <div class="modal fade show d-block" tabindex="-1" role="dialog" style="background-color: rgba(0,0,0,0.5);">
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
                                <input type="text" class="form-control @error('account_name') is-invalid @enderror"
                                    wire:model="account_name" readonly
                                    placeholder="Account name will appear after validation">
                                @error('account_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary" type="submit" {{ !$account_name ? 'disabled' : '' }}>
                                Save Bank Details
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
