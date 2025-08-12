<div class="row mx-0 min-vh-100">
        <div class="hero-static col-md-6 col-xl-7 d-none d-md-flex align-items-md-end bg-image"
             style="background-image: url('assets/media/photos/Famlic_banner.jpg'); background-size: contain; background-position: center; background-repeat: no-repeat; background-color: white;">
            <div class="p-4">
                {{-- <p class="text-white-75 fw-medium">
                    Copyright &copy; <span data-toggle="year-copy"></span>
                </p> --}}

                {{-- <p class="fs-4 fw-semibold text-black">
                    Raise Funds and Support from Family & Friends
                </p> --}}

            </div>
        </div>

        <div class="hero-static col-md-6 col-xl-5 d-flex align-items-center" style="background-color: white;">
            <div class="content content-full">
                <!-- Header -->
                <div class="px-4 py-2 mb-4">
                    <a class="link-fx fw-bold" href="{{ url('/') }}">
                        <i class="fa fa-gift"></i>
                        <span class="fs-4 text-body-color"> Fam</span><span class="fs-4">lic</span>
                    </a>
                    <h1 class="h3 fw-bold mt-4 mb-2">Welcome to Your Dashboard</h1>
                    <h2 class="h5 fw-medium text-muted mb-0">Please sign in</h2>
                </div>

                <form wire:submit.prevent="login" class="js-validation-signin px-4">
                    <div class="form-floating mb-4">
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="login-email"
                            placeholder="Enter your email" wire:model.defer="email" required autofocus
                            autocomplete="email">
                        <label class="form-label" for="login-email">Email Address</label>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div x-data="{ show: false }" class="form-floating mb-4 position-relative">
                        <input :type="show ? 'text' : 'password'"
                            class="form-control @error('password') is-invalid @enderror" id="login-password"
                            placeholder="Enter your password" wire:model.defer="password" required
                            autocomplete="current-password">
                        <label class="form-label" for="login-password">Password</label>

                        <span @click="show = !show" class="position-absolute top-50 end-0 translate-middle-y me-3"
                            style="cursor: pointer; z-index: 10;">
                            <i :class="show ? 'fa fa-eye-slash' : 'fa fa-eye'"></i>
                        </span>

                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="login-remember-me"
                                wire:model="remember">
                            <label class="form-check-label" for="login-remember-me">Remember Me</label>
                        </div>
                    </div>

                    <div class="mb-4">
                        <button type="submit" class="btn btn-lg btn-alt-primary fw-semibold"
                            wire:loading.attr="disabled">
                            <span wire:loading.remove>Sign In</span>
                            <span wire:loading>Processing...</span>
                        </button>
                        <div class="mt-4">
                            <a class="fs-sm fw-medium link-fx text-muted me-2 mb-1 d-inline-block"
                                href="{{ route('register') }}">
                                Create Account
                            </a>
                            <a class="fs-sm fw-medium link-fx text-muted me-2 mb-1 d-inline-block"
                                href="{{ route('password.request') }}">
                                Forgot Password
                            </a>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
