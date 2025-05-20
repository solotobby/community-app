<div class="row mx-0 bg-earth-op">
    <div class="hero-static col-md-6 col-xl-8 d-none d-md-flex align-items-md-end bg-image"
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

    <div class="hero-static col-md-6 col-xl-4 d-flex align-items-center bg-body-extra-light">
        <div class="content content-full">
            <div class="px-4 py-2 mb-4">
                <a class="link-fx fw-bold" href="{{ url('/') }}">
                    <i class="fa fa-fire"></i>
                    <span class="fs-4 text-body-color">code</span><span class="fs-4">base</span>
                </a>
                <h1 class="h3 fw-bold mt-4 mb-2">Create New Account</h1>
                <h2 class="h5 fw-medium text-muted mb-0">Please add your details</h2>
            </div>

            <form wire:submit.prevent="register" class="px-4">
                <div class="form-floating mb-4">
                    <input wire:model.defer="name" type="text" class="form-control" placeholder="Enter your Name">
                    <label>Username</label>
                    @error('name') <span class="text-danger fs-sm">{{ $message }}</span> @enderror
                </div>

                <div class="form-floating mb-4">
                    <input wire:model.defer="email" type="email" class="form-control" placeholder="Enter your Email">
                    <label>Email</label>
                    @error('email') <span class="text-danger fs-sm">{{ $message }}</span> @enderror
                </div>

                <div class="form-floating mb-4">
                    <input wire:model.defer="password" type="password" class="form-control" placeholder="Enter your password">
                    <label>Password</label>
                    @error('password') <span class="text-danger fs-sm">{{ $message }}</span> @enderror
                </div>

                <div class="form-floating mb-4">
                    <input wire:model.defer="password_confirmation" type="password" class="form-control" placeholder="Confirm password">
                    <label>Confirm Password</label>
                </div>

                <div class="mb-4">
                    <div class="form-check">
                        <input wire:model="agreeTerms" type="checkbox" class="form-check-input" id="signup-terms">
                        <label class="form-check-label" for="signup-terms">I agree to Terms</label>
                    </div>
                    @error('agreeTerms') <span class="text-danger fs-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <button type="submit" class="btn btn-lg btn-alt-primary fw-semibold">
                        Create Account
                    </button>
                    <div class="mt-4">
                        <a class="fs-sm fw-medium link-fx text-muted me-2 mb-1 d-inline-block" href="#" data-bs-toggle="modal" data-bs-target="#modal-terms">
                            Read Terms
                        </a>
                        <a class="fs-sm fw-medium link-fx text-muted me-2 mb-1 d-inline-block" href="{{ route('login') }}">
                            Sign In
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Terms (unchanged) -->
    @include('partials.modal-terms')
</div>
