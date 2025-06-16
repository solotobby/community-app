<div class="content">
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div style="min-width: 320px; max-width: 400px; width: 100%;">

            <form wire:submit.prevent="submit">
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input wire:model="name" type="text" class="form-control @error('name') is-invalid @enderror">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Registration Amount</label>
                    <input wire:model="registration_amount" type="number"
                        class="form-control @error('registration_amount') is-invalid @enderror">
                    @error('registration_amount')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Entry Gift Percentage</label>
                    <input wire:model="entry_gift" type="number" max="100"
                        class="form-control @error('entry_gift') is-invalid @enderror">
                    @error('entry_gift')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Referral Bonus Percentage</label>
                    <input wire:model="referral_bonus" type="number" max="100"
                        class="form-control @error('referral_bonus') is-invalid @enderror">
                    @error('referral_bonus')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Currency</label>
                    <select wire:model="currency" class="form-control @error('currency') is-invalid @enderror">
                        <option value="">Select currency</option>
                        <option value="NGN">Naira (NGN)</option>
                        <option value="USD">US Dollar (USD)</option>
                        <option value="EUR">Euro (EUR)</option>
                        <option value="GBP">British Pound (GBP)</option>
                    </select>
                    @error('currency')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


                <button class="btn btn-primary" type="submit">Create Level</button>
            </form>
        </div>
    </div>
</div>
