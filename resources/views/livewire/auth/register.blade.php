<div class="row mx-0 bg-earth-op">
    <div class="hero-static col-md-4 col-xl-7 d-none d-md-flex align-items-md-end bg-image"
        style="background-image: url('{{ asset('assets/media/photos/photo34@2x.jpg') }}');">
        <div class="p-4">
            <p class="fs-3 fw-semibold text-white mb-1">
                We're very happy you are joining our community!
            </p>
            <p class="fs-5 text-white fw-medium">
                <i class="fa fa-angle-right opacity-50"></i> Create your account today and receive 50% off.
            </p>
            <p class="text-white-75 fw-medium">
                Copyright &copy; <span>{{ now()->year }}</span>
            </p>
        </div>
    </div>

    <div class="hero-static col-md-6 col-xl-5 d-flex align-items-center bg-body-extra-light">
        <div class="content content-full">
            <div class="px-4 py-2 mb-4">
                <a class="link-fx fw-bold" href="{{ url('/') }}">
                    <i class="fa fa-fire"></i>
                    <span class="fs-4 text-body-color">Community</span><span class="fs-4"> App</span>
                </a>
                <h1 class="h3 fw-bold mt-4 mb-2">Create New Account</h1>
                <h2 class="h5 fw-medium text-muted mb-0">Please add your details</h2>
            </div>

            <form wire:submit.prevent="register" class="px-4">
                <div class="form-floating mb-4">
                    <input wire:model.defer="name" type="text" class="form-control" placeholder="Enter your Name">
                    <label>Name</label>
                    @error('name')
                        <span class="text-danger fs-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-floating mb-4">
                    <input wire:model.defer="email" type="email" class="form-control" placeholder="Enter your Email">
                    <label>Email</label>
                    @error('email')
                        <span class="text-danger fs-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-floating mb-4">
                    <select id="levelSelect" wire:model="level" class="form-control">
                        <option value="">-- Select Level --</option>
                        @foreach ($levels as $lvl)
                            <option value="{{ $lvl->id }}">{{ $lvl->name }}</option>
                        @endforeach
                    </select>
                    <label>Select Level</label>
                </div>

                <div id="amountToPay" class="mb-3 text-center" style="display:none;">
                    <div class="alert alert-info py-2">
                        <strong>Amount to Pay:</strong> ₦<span id="amountValue"></span>
                    </div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        const levels = window.levels || [];
                        const select = document.getElementById('levelSelect');
                        const amountDiv = document.getElementById('amountToPay');
                        const amountSpan = document.getElementById('amountValue');

                        select.addEventListener('change', () => {
                            const selectedId = select.value;
                            if (!selectedId) {
                                amountDiv.style.display = 'none';
                                amountSpan.textContent = '';
                                return;
                            }

                            const level = levels.find(lvl => lvl.id == selectedId);
                            if (level && level.amount) {
                                amountSpan.textContent = Number(level.amount).toLocaleString(undefined, {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                });
                                amountDiv.style.display = 'block';
                            } else {
                                amountDiv.style.display = 'none';
                                amountSpan.textContent = '';
                            }
                        });
                    });
                </script>



                <div class="form-floating mb-4">
                    <input wire:model.defer="password" type="password" class="form-control"
                        placeholder="Enter your password">
                    <label>Password</label>
                    @error('password')
                        <span class="text-danger fs-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-floating mb-4">
                    <input wire:model.defer="password_confirmation" type="password" class="form-control"
                        placeholder="Confirm password">
                    <label>Confirm Password</label>
                </div>

                <div class="form-floating mb-4">
                    <input wire:model.defer="referral_code" type="text" class="form-control"
                        placeholder="Referral code (optional)">
                    <label>Referral Code (optional)</label>
                    @error('referral_code')
                        <span class="text-danger fs-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <div class="form-check">
                        <input wire:model="agreeTerms" type="checkbox" class="form-check-input" id="signup-terms">
                        <label class="form-check-label" for="signup-terms">I agree to Terms</label>
                    </div>
                    @error('agreeTerms')
                        <span class="text-danger fs-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <button type="submit" class="btn btn-lg btn-alt-primary fw-semibold" wire:loading.attr="disabled">
                        <span wire:loading.remove>Make Payment</span>
                        <span wire:loading>Processing...</span>
                    </button>

                    <div class="mt-4">
                        <a class="fs-sm fw-medium link-fx text-muted me-2 mb-1 d-inline-block" href="#"
                            data-bs-toggle="modal" data-bs-target="#modal-terms">
                            Read Terms
                        </a>
                        <a class="fs-sm fw-medium link-fx text-muted me-2 mb-1 d-inline-block"
                            href="{{ route('login') }}">
                            Sign In
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Terms (unchanged) -->
    @include('partials.modal-terms')
    <script>
        window.levels = @json($levels->map(fn($lvl) => ['id' => $lvl->id, 'amount' => $lvl->registration_amount]));
    </script>


</div>
