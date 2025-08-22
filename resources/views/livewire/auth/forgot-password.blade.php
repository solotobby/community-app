<div class="row mx-0 min-vh-100">
    <div class="hero-static col-md-4 col-xl-7 d-none d-md-flex align-items-md-end bg-image position-fixed"
        style="background-image: url('{{ asset('assets/media/photos/Famlic_banner.jpg') }}'); background-size: contain; background-position: center; background-repeat: no-repeat; background-color: white; height: 100vh; width: 58.333333%;">
        <div class="p-4">
            {{-- <p class="text-white-75 fw-medium">
                Copyright &copy; <span data-toggle="year-copy"></span>
            </p> --}}
        </div>
    </div>

    <div class="hero-static col-md-8 col-xl-5 d-flex align-items-center ms-auto"
        style=" min-height: 100vh; overflow-y: auto;">
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

            <!-- Reset Form -->
            <form wire:submit.prevent="sendPasswordResetLink" class="px-4">
                <div class="form-floating mb-4">
                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                        id="reminder-credential" placeholder="Enter your email" wire:model.defer="email" required
                        autocomplete="email">
                    <label class="form-label" for="reminder-credential">Email Address</label>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <button type="submit" class="btn btn-lg btn-alt-primary fw-semibold" wire:loading.attr="disabled">
                        <span wire:loading.remove>Send Reset Link</span>
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
