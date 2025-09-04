<div class="row mx-0 min-vh-100">
    <div class="hero-static col-md-6 col-xl-7 d-none d-md-flex align-items-md-end bg-image position-fixed"
        style="background-image: url('assets/media/photos/famlic_login.png'); background-size: contain; background-position: center; background-repeat: no-repeat; background-color: white;">
        <div class="p-4">
            {{-- <p class="text-white-75 fw-medium">
                Copyright &copy; <span data-toggle="year-copy"></span>
            </p> --}}

            {{-- <p class="fs-4 fw-semibold text-black">
                Raise Funds and Support from Family & Friends
            </p> --}}

        </div>
    </div>

    <div class="hero-static col-md-6 col-xl-5 d-flex align-items-center ms-auto min-height: 100vh; overflow-y: auto;">
        <div class="content content-full">
            <div class="px-4 py-2 mb-4">
                <a class="link-fx fw-bold" href="{{ url('/') }}">
                    <i class="fa fa-gift"></i>
                    <span class="fs-4 text-body-color"> Fam</span><span class="fs-4">lic</span>
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
                    <select id="levelSelect" class="form-control">
                        <option value="">-- Select any Level of your Choice --</option>
                        @foreach ($levels as $lvl)
                            <option value="{{ $lvl->id }}" data-amount="{{ $lvl->amount ?? 0 }}">
                                {{ $lvl->name }}
                            </option>
                        @endforeach
                    </select>
                    <label>Select Level</label>
                </div>

                <div id="amountToPay" class="mb-3 text-center" style="display:none;">
                    <div class="alert alert-info py-2">
                        <strong>Access Fee:</strong> ₦<span id="amountValue"></span>
                    </div>

                    <!-- Faint Note -->
                    {{-- <div class="alert alert-info order mt-3">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-gift text-primary me-2"></i>
                            <small class="text-muted">
                                🎉 Crowdfunding is 100% free!
                            </small>
                        </div>
                    </div> --}}
                </div>

                <div id="crowdfundingComplete" class="mb-3 text-center" style="display:none;">
                    <div class="alert alert-success py-2">
                        🎉 Crowdfunding is 100% free!
                    </div>
                </div>

                <div x-data="{ show: false }" class="form-floating mb-4 position-relative">
                    <input :type="show ? 'text' : 'password'" wire:model.defer="password" class="form-control"
                        placeholder="Enter your password" id="password">
                    <label for="password">Password</label>

                    <span @click="show = !show" class="position-absolute top-50 end-0 translate-middle-y me-3"
                        style="cursor: pointer;">
                        <i :class="show ? 'fa fa-eye-slash' : 'fa fa-eye'"></i>
                    </span>

                    {{-- <small class="text-muted">
                        Must be at least 6 characters and include uppercase, lowercase, and a number.
                    </small> --}}

                    @error('password')
                        <span class="text-danger fs-sm">{{ $message }}</span>
                    @enderror
                </div>



                <div x-data="{ show: false }" class="form-floating mb-4 position-relative">
                    <input :type="show ? 'text' : 'password'" wire:model.defer="password_confirmation"
                        class="form-control" placeholder="Confirm password" id="password_confirmation">
                    <label for="password_confirmation">Confirm Password</label>

                    <span @click="show = !show" class="position-absolute top-50 end-0 translate-middle-y me-3"
                        style="cursor: pointer;">
                        <i :class="show ? 'fa fa-eye-slash' : 'fa fa-eye'"></i>
                    </span>
                </div>
                <div class="form-floating mb-4">
                    <select wire:model.defer="hear_us" class="form-control" id="hear_us">
                        <option value="" selected disabled>-- Select an option --</option>
                        <option value="tiktok">TikTok</option>
                        <option value="youtube">Youtube</option>
                        <option value="facebook">Facebook</option>
                        <option value="whatsapp">WhatsApp</option>
                        <option value="instagram">Instagram</option>
                        <option value="twitter">Twitter(X)</option>
                        <option value="event">Event or Seminar</option>
                        <option value="friend">Referred by Friend</option>
                        <option value="family">Referred by Family</option>
                        <option value="online_ads">Online Ads (Google, etc.)</option>
                    </select>
                    <label for="hear_us">How did you hear about us?</label>
                    @error('hear_us')
                        <span class="text-danger fs-sm">{{ $message }}</span>
                    @enderror
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
                        <input wire:model.live="agreeTerms" type="checkbox" class="form-check-input" id="signup-terms">

                        <label class="form-check-label" for="signup-terms">
                            I agree to Terms and Conditions
                        </label>
                    </div>

                    @error('agreeTerms')
                        <span class="text-danger fs-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Continue button -->
                <div class="mb-4">
                    <button type="submit" class="btn btn-lg btn-alt-primary fw-semibold" wire:loading.attr="disabled"
                        @disabled(!$agreeTerms)>
                        <span wire:loading.remove>Continue</span>
                        <span wire:loading>Processing...</span>
                    </button>

                    <div class="mt-4">
                        <a class="fs-sm fw-medium link-fx text-muted me-2 mb-1 d-inline-block" href="#"
                            data-bs-toggle="modal" wire:click="openTermsModal">
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

    <!-- Modal Terms -->
    @if ($showTermsModal)
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content theme-sensitive">
                    <div class="block block-rounded block-transparent mb-0">
                        <div class="block-header bg-primary-dark">
                            <h3 class="block-title text-white">Terms & Conditions</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option text-white" wire:click="closeTermsModal"
                                    aria-label="Close">
                                    <i class="fa fa-fw fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content fs-sm">
                            <p>
                                By using this platform, you agree to our terms and conditions. These include abiding by our
                                rules,
                                not engaging in prohibited activities, and respecting the privacy of others.
                            </p>
                            <p>
                                You also consent to the collection and use of your information as outlined in our Privacy
                                Policy.
                                Please read these documents carefully before registering.
                            </p>
                            <p>Any account created that did not raise money will be deleted permanently after 30 days.
                            </p>
                            <p>
                                This agreement may be updated from time to time. It is your responsibility to stay informed
                                about changes.
                            </p>
                            <p><a href="{{ route('terms') }}">Learn More...</a></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-alt-secondary" data-bs-dismiss="modal"
                                wire:click="closeTermsModal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const levels = @json($levels->map(fn($lvl) => [
                'id' => $lvl->id,
                'amount' => $lvl->registration_amount
            ]));

            const levelSelect = document.getElementById("levelSelect");
            const amountToPay = document.getElementById("amountToPay");
            const amountValue = document.getElementById("amountValue");
            const crowdfundingComplete = document.getElementById("crowdfundingComplete");

            levelSelect.addEventListener("change", function () {
                const selectedId = levelSelect.value;
                if (!selectedId) {
                    amountToPay.style.display = "none";
                    crowdfundingComplete.style.display = "none";
                    amountValue.textContent = "";
                    return;
                }

                const level = levels.find(lvl => lvl.id == selectedId);

                if (level) {
                    amountToPay.style.display = "block";
                    amountValue.textContent = Number(level.amount).toLocaleString(undefined, {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });

                    if (parseFloat(level.amount) === 0) {
                        crowdfundingComplete.style.display = "block";
                    } else {
                        crowdfundingComplete.style.display = "none";
                    }
                } else {
                    amountToPay.style.display = "none";
                    crowdfundingComplete.style.display = "none";
                    amountValue.textContent = "";
                }
            });
        });
    </script>

</div>
