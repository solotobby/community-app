{{-- <div class="flex flex-col gap-6">
    <x-auth-header :title="__('Log in to your account')" :description="__('Enter your email and password below to log in')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="login" class="flex flex-col gap-6">
        <!-- Email Address -->
        <flux:input
            wire:model="email"
            :label="__('Email address')"
            type="email"
            required
            autofocus
            autocomplete="email"
            placeholder="email@example.com"
        />

        <!-- Password -->
        <div class="relative">
            <flux:input
                wire:model="password"
                :label="__('Password')"
                type="password"
                required
                autocomplete="current-password"
                :placeholder="__('Password')"
                viewable
            />

            @if (Route::has('password.request'))
                <flux:link class="absolute end-0 top-0 text-sm" :href="route('password.request')" wire:navigate>
                    {{ __('Forgot your password?') }}
                </flux:link>
            @endif
        </div>

        <!-- Remember Me -->
        <flux:checkbox wire:model="remember" :label="__('Remember me')" />

        <div class="flex items-center justify-end">
            <flux:button variant="primary" type="submit" class="w-full">{{ __('Log in') }}</flux:button>
        </div>
    </form>

    @if (Route::has('register'))
        <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
            {{ __('Don\'t have an account?') }}
            <flux:link :href="route('register')" wire:navigate>{{ __('Sign up') }}</flux:link>
        </div>
    @endif
</div> --}}

<div class="bg-image" style="background-image: url('assets/media/photos/photo34@2x.jpg');">
    <div class="row mx-0 bg-black-50">
        <div class="hero-static col-md-4 col-xl-7 d-none d-md-flex align-items-md-end">
            <div class="p-4">
                <p class="fs-3 fw-semibold text-white">
                    Get Inspired and Create.
                </p>
                <p class="text-white-75 fw-medium">
                    Copyright &copy; <span data-toggle="year-copy"></span>
                </p>
            </div>
        </div>
        <div class="hero-static col-md-6 col-xl-5 d-flex align-items-center bg-body-extra-light">
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

                    <div class="form-floating mb-4">
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            id="login-password" placeholder="Enter your password" wire:model.defer="password" required
                            autocomplete="current-password">
                        <label class="form-label" for="login-password">Password</label>
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
                        <button type="submit" class="btn btn-lg btn-alt-primary fw-semibold">
                            Sign In
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
