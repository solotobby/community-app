{{-- <div class="mt-4 flex flex-col gap-6">
    <flux:text class="text-center">
        {{ __('Please verify your email address by clicking on the link we just emailed to you.') }}
    </flux:text>

    @if (session('status') == 'verification-link-sent')
        <flux:text class="text-center font-medium !dark:text-green-400 !text-green-600">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </flux:text>
    @endif

    <div class="flex flex-col items-center justify-between space-y-3">
        <flux:button wire:click="sendVerification" variant="primary" class="w-full">
            {{ __('Resend verification email') }}
        </flux:button>

        <flux:link class="text-sm cursor-pointer" wire:click="logout">
            {{ __('Log out') }}
        </flux:link>
    </div>
</div> --}}


<div class="bg-image" style="background-image: url('{{ asset('assets/media/photos/photo34@2x.jpg') }}');">
    <div class="row mx-0 bg-pulse-op">
        <div class="hero-static col-md-6 col-xl-8 d-none d-md-flex align-items-md-end">
            <div class="p-4">
                <p class="fs-3 fw-semibold text-white">
                    <i class="fa fa-bell opacity-50"></i> You have
                    <a class="link-fx text-white" href="javascript:void(0)">5 new notifications</a>!
                </p>
                <p class="text-white-75 fw-medium">
                    Copyright &copy; <span>{{ date('Y') }}</span>
                </p>
            </div>
        </div>
        <div class="hero-static col-md-6 col-xl-4 d-flex align-items-center bg-body-extra-light p-0">
            <div class="content content-full">
                <!-- Header -->
                <div class="py-4 text-center text-md-start">
                    <a class="link-fx fw-bold" href="#">
                        <i class="fa fa-fire"></i>
                        <span class="fs-4 text-body-color">code</span><span class="fs-4">base</span>
                    </a>
                    <div class="mb-4 mt-5">
                        <i class="si si-lock-open fa-3x"></i>
                    </div>
                    <h1 class="h3 fw-bold mb-2">Authenticate your account</h1>
                    <h2 class="fs-5 lh-base fw-normal text-muted mb-0">
                        Please confirm your account by entering the authorization code sent to your mobile number *******3235.
                    </h2>
                </div>

                <!-- Form -->
                <form wire:submit.prevent="submit" class="py-4">
                    @if (session()->has('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @elseif (session()->has('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <div class="d-flex items-center justify-content-center justify-content-md-start gap-2 mb-4">
                        @for ($i = 1; $i <= 6; $i++)
                            @if ($i == 4)
                                <span class="d-flex align-items-center">-</span>
                            @endif
                            <input type="text" maxlength="1" style="width: 38px;"
                                wire:model="num{{ $i }}"
                                class="form-control form-control-lg text-center px-0">
                        @endfor
                    </div>

                    <div>
                        <button type="submit" class="btn btn-lg btn-alt-primary px-6 py-2 fw-semibold">
                            Submit
                        </button>
                    </div>

                    <p class="fs-sm text-muted py-4 mb-0">
                        Haven't received it? <a href="javascript:void(0)">Resend a new code</a>
                    </p>
                </form>
                <!-- END Form -->
            </div>
        </div>
    </div>
</div>
