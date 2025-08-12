<div class="row mx-0 min-vh-100">
    <div class="hero-static col-md-4 col-xl-7 d-none d-md-flex align-items-md-end bg-image position-fixed"
        style="background-image: url('{{ asset('assets/media/photos/Famlic_banner.jpg') }}'); background-size: contain; background-position: center; background-repeat: no-repeat; background-color: white; height: 100vh; width: 58.333333%;">
        <div class="p-4">
            {{-- <p class="text-white-75 fw-medium">
                Copyright &copy; <span data-toggle="year-copy"></span>
            </p> --}}
        </div>
    </div>

    <!-- Right Content -->
    <div class="hero-static col-md-8 col-xl-5 d-flex align-items-center ms-auto"
        style="background-color: white; min-height: 100vh; overflow-y: auto;">
        <div class="content content-full">
            <!-- Header -->
            <div class="px-4 py-2 mb-4">
                <a class="link-fx fw-bold" href="{{ url('/') }}">
                    <i class="fa fa-gift"></i>
                    <span class="fs-4 text-body-color"> Fam</span><span class="fs-4">lic</span>
                </a>
                <h1 class="h3 fw-bold mt-4 mb-2">Don't worry, we've got your back</h1>
                <h2 class="h5 fw-medium text-muted mb-0">Please enter your email address</h2>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="alert alert-success mb-4 mx-4">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Reset Password Form -->
            <form wire:submit.prevent="resetPassword" class="px-4">
                <!-- Hidden token -->
                <input type="hidden" wire:model="token" value="{{ $token }}">

                <!-- Email -->
                <div class="form-floating mb-4">
                    <input type="email"
                        class="form-control @error('email') is-invalid @enderror"
                        id="reset-email" placeholder=" "
                        wire:model.defer="email" required autocomplete="email" readonly>
                    <label for="reset-email">Email Address</label>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- New Password -->
                <div x-data="{ showPassword: false }" class="form-floating mb-4 position-relative">
                    <input :type="showPassword ? 'text' : 'password'"
                        class="form-control @error('password') is-invalid @enderror"
                        id="reset-password" placeholder=" "
                        wire:model.defer="password" required
                        autocomplete="new-password" minlength="8">
                    <label for="reset-password">New Password</label>
                    <span @click="showPassword = !showPassword"
                        class="position-absolute top-50 end-0 translate-middle-y me-3"
                        style="cursor: pointer; z-index: 10;">
                        <i :class="showPassword ? 'fa fa-eye-slash' : 'fa fa-eye'"></i>
                    </span>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div x-data="{ showConfirmation: false }" class="form-floating mb-4 position-relative">
                    <input :type="showConfirmation ? 'text' : 'password'"
                        class="form-control @error('password_confirmation') is-invalid @enderror"
                        id="reset-password-confirmation" placeholder=" "
                        wire:model.defer="password_confirmation" required
                        autocomplete="new-password" minlength="8">
                    <label for="reset-password-confirmation">Confirm Password</label>
                    <span @click="showConfirmation = !showConfirmation"
                        class="position-absolute top-50 end-0 translate-middle-y me-3"
                        style="cursor: pointer; z-index: 10;">
                        <i :class="showConfirmation ? 'fa fa-eye-slash' : 'fa fa-eye'"></i>
                    </span>
                    @error('password_confirmation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Submit -->
                <div class="mb-4">
                    <button type="submit" class="btn btn-lg btn-alt-primary fw-semibold" wire:loading.attr="disabled">
                        <span wire:loading.remove>Reset Password</span>
                        <span wire:loading>Processing...</span>
                    </button>
                    <div class="mt-4">
                        <a class="fs-sm fw-medium link-fx text-muted me-2 mb-1 d-inline-block"
                            href="{{ route('login') }}">
                            <i class="fa fa-arrow-left opacity-50 me-1"></i> Back to Sign In
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
