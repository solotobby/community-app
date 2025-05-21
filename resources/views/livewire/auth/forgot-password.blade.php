

<div class="bg-image" style="background-image: url('{{ asset('assets/media/photos/photo34@2x.jpg') }}');">
  <div class="row mx-0 bg-default-op">
    <div class="hero-static col-md-6 col-xl-8 d-none d-md-flex align-items-md-end">
      <div class="p-4">
        <p class="fs-3 fw-semibold text-white">
          You are awesome! Build something amazing!
        </p>
        <p class="text-white-75 fw-medium">
          Copyright &copy; <span>{{ date('Y') }}</span>
        </p>
      </div>
    </div>
    <div class="hero-static col-md-6 col-xl-4 d-flex align-items-center bg-body-extra-light">
      <div class="content content-full">

        <!-- Header -->
        <div class="px-4 py-2 mb-4">
          <a class="link-fx fw-bold" href="{{ url('/') }}">
            <i class="fa fa-fire"></i>
            <span class="fs-4 text-body-color">code</span><span class="fs-4">base</span>
          </a>
          <h1 class="h3 fw-bold mt-4 mb-2">Don’t worry, we’ve got your back</h1>
          <h2 class="h5 fw-medium text-muted mb-0">Please enter your username or email</h2>
        </div>
        <!-- END Header -->

        <!-- Reminder Form -->
        <form wire:submit.prevent="sendResetLink" class="px-4">
          <div class="form-floating mb-4">
            <input
              type="email"
              class="form-control @error('email') is-invalid @enderror"
              id="reminder-credential"
              placeholder="Enter your email"
              wire:model.defer="email"
              required
              autocomplete="email"
            >
            <label class="form-label" for="reminder-credential">Email</label>
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="mb-4">
            <button type="submit" class="btn btn-lg btn-alt-primary fw-semibold">
              Reset Password
            </button>
            <div class="mt-4">
              <a class="fs-sm fw-medium link-fx text-muted me-2 mb-1 d-inline-block" href="{{ route('login') }}">
                <i class="fa fa-arrow-left opacity-50 me-1"></i> Sign In
              </a>
            </div>
          </div>
        </form>
        <!-- END Reminder Form -->

      </div>
    </div>
  </div>
</div>
