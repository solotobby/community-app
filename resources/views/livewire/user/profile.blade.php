<div class="content">
    <div class="mt-4 mx-4">

        {{-- Success & Error Alerts --}}
        @if (session()->has('success'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        {{-- USER PROFILE SECTION --}}
        <div class="mb-5">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h2>User Profile</h2>
                <button class="btn btn-primary" wire:click="openUserModal">
                    Change Password
                </button>
            </div>
            <div class="mb-3">
                <label class="form-label">Name:</label>
                <div>{{ $name }}</div>
            </div>

            <div class="mb-3">
                <label class="form-label">Email:</label>
                <div>{{ $email }}</div>


            </div>
            <div class="mb-3">
                <label class="form-label">Referral Code:</label>
                <div>{{ $referral_code }}</div>

            </div>
            <div class="mb-3">
                <label class="form-label">Referred By:</label>
                <div>{{ $referred_by ?? 'NULL'}}</div>
            </div>

            <div class="mb-3">
                <label class="form-label">Level:</label>
                <div>{{ $level->name ?? 'NULL' }}</div>
            </div>
        </div>

        {{-- BANK INFORMATION SECTION --}}
        <div class="mb-5">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h4 class="mb-0">Bank Information</h4>

                @if (!$bank_name && !$account_number && !$account_name)
                    <button class="btn btn-primary" wire:click="openBankModal">
                        Add Bank Detail
                    </button>
                @endif
            </div>

            @if ($bank_name && $account_number && $account_name)
                <table class="table table-bordered w-auto">
                    <tbody>
                        <tr>
                            <th>Bank Name</th>
                            <td>{{ $bank_name }}</td>
                        </tr>
                        <tr>
                            <th>Account Number</th>
                            <td>{{ $account_number }}</td>
                        </tr>
                        <tr>
                            <th>Account Name</th>
                            <td>{{ $account_name }}</td>
                        </tr>
                    </tbody>
                </table>
            @else
                <p class="text-muted">User does not have a bank detail.</p>
            @endif
        </div>

        {{-- TRANSACTION PIN SECTION --}}
        <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h4 class="mb-0">Transaction PIN</h4>
                <button class="btn btn-primary" wire:click="openPinModal">
                    {{ $transaction_pin ? 'Change' : 'Set' }} Transaction PIN
                </button>
            </div>

            @if ($transaction_pin)
                <p class="text-success mb-0">Transaction PIN is set.</p>
            @else
                <p class="text-muted mb-0">User does not have a transaction PIN.</p>
            @endif
        </div>

        {{-- USER DETAIL MODAL --}}
        <div class="modal fade @if ($showUserModal) show d-block @endif" tabindex="-1" role="dialog"
            @if ($showUserModal) style="background-color: rgba(0,0,0,0.5);" @endif>
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form wire:submit.prevent="updateUserDetails">
                        <div class="modal-header">
                            <h5 class="modal-title">Change Password</h5>
                            <button type="button" class="btn-close" wire:click="closeUserModal"></button>
                        </div>
                        <div class="modal-body">

                            <div class="mb-3">
                                <label class="form-label">Current Password</label>
                                <input type="password"
                                    class="form-control @error('current_password') is-invalid @enderror"
                                    wire:model.defer="current_password">
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">New Password</label>
                                <input type="password" class="form-control @error('new_password') is-invalid @enderror"
                                    wire:model.defer="new_password">
                                @error('new_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Confirm New Password</label>
                                <input type="password"
                                    class="form-control @error('new_password_confirmation') is-invalid @enderror"
                                    wire:model.defer="new_password_confirmation">
                                @error('new_password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary" type="submit">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Transaction PIN Modal --}}
        <div class="modal fade @if ($showPinModal) show d-block @endif" tabindex="-1" role="dialog"
            @if ($showPinModal) style="background-color: rgba(0,0,0,0.5);" @endif>
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form wire:submit.prevent="saveTransactionPin">
                        <div class="modal-header">
                            <h5 class="modal-title">Set Transaction PIN</h5>
                            <button type="button" class="btn-close" wire:click="closePinModal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Transaction PIN</label>
                                <input type="password"
                                    class="form-control @error('transaction_pin') is-invalid @enderror"
                                    wire:model.defer="transaction_pin" placeholder="Enter new PIN">
                                @error('transaction_pin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary" type="submit">Save PIN</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Bank Modal --}}
        <div class="modal fade @if ($showBankModal) show d-block @endif" tabindex="-1" role="dialog"
            @if ($showBankModal) style="background-color: rgba(0,0,0,0.5);" @endif>
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form wire:submit.prevent="saveBankDetails">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Bank Detail</h5>
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
                                        wire:model="account_number">
                                    <button class="btn btn-outline-secondary" type="button"
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
                                    placeholder="{{ $account_name ? $account_name : '' }}"
                                    wire:loading.attr="placeholder" wire:target="fetchAccountName">

                                @error('account_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary" type="submit"
                                @if (!$account_name) disabled @endif>Save Bank Detail</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
