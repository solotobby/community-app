<div class="d-flex justify-content-center align-items-center vh-100">
    <div style="min-width: 320px; max-width: 400px; width: 100%;">

        <form wire:submit.prevent="submit">
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input wire:model="name" type="text" class="form-control @error('name') is-invalid @enderror">
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Registration Amount</label>
                <input wire:model="registration_amount" type="number" class="form-control @error('registration_amount') is-invalid @enderror">
                @error('registration_amount') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Referral Bonus</label>
                <input wire:model="referral_bonus" type="number" class="form-control @error('referral_bonus') is-invalid @enderror">
                @error('referral_bonus') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <button class="btn btn-primary" type="submit">Create Level</button>
        </form>
    </div>
</div>
