<?php

namespace App\Livewire\User;

use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\GiftRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\PhoneOtp;
use App\Models\EmailOtp;
use Illuminate\Support\Facades\Mail;
use Throwable;
use App\Mail\EmailVerification;
use App\Mail\GiftCreatedEmail;
use Carbon\Carbon;

class CreateGift extends Component
{
    use WithFileUploads;

    public $currentStep = 1;
    public $totalSteps = 3;

    // Gift Details
    public $title = '';
    public $reason = '';
    public $description = '';
    public $target_amount = '';
    public $deadline = '';
    public $gift_image;
    public $include_fee = false;
    public $finalTargetAmount = 0;

    // Settings
    public $is_public = true;
    public $allow_messages = true;
    public $min_contribution = 100;

    public $showContactModal = false;
    public $showVerificationModal = false;
    public $currentVerificationStep = 'choose'; // choose, phone, email

    // Verification codes
    public $phone_code_sent = false;
    public $email_code_sent = false;
    public $phone_verification_code = '';
    public $email_verification_code = '';

    // Contact form fields
    public $phone = '';
    public $dob = '';
    public $address = '';
    public $landmark = '';
    public $lga = '';
    public $state = '';
    public $country = '';

    protected function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'reason' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'target_amount' => 'required|numeric|min:1',
            'deadline' => 'required|date|after:today',
            'gift_image' => 'nullable|image|max:2048',
            'is_public' => 'boolean',
            'allow_messages' => 'boolean',
            'min_contribution' => 'nullable|numeric|min:1'
        ];
    }

    private function isContactInfoIncomplete($user)
    {
        return empty($user->phone) ||
            empty($user->address) ||
            empty($user->lga) ||
            empty($user->state) ||
            empty($user->country) ||
            empty($user->dob);
    }

    private function loadUserContactInfo()
    {
        $user = Auth::user();
        $this->phone = $user->phone ?? '';
        $this->dob = $user->dob ?? '';
        $this->address = $user->address ?? '';
        $this->landmark = $user->landmark ?? '';
        $this->lga = $user->lga ?? '';
        $this->state = $user->state ?? '';
        $this->country = $user->country ?? '';
        $this->resetValidation();
    }

    public function closeContactModal()
    {
        $this->showContactModal = false;
        $this->resetValidation();
    }

    public function saveContactInfo()
    {
        $validated = $this->validate([
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'landmark' => 'nullable|string|max:255',
            'lga' => 'required|string|max:255',
            'dob' => 'required|date|before:today',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $phoneChanged = $user->phone !== $this->phone;

        // Update user info
        $user->update($validated + [
            'phone_verified' => $phoneChanged ? false : $user->phone_verified,
            'phone_verified_at' => $phoneChanged ? null : $user->phone_verified_at,
        ]);

        $this->closeContactModal();

        // Handle verification
        if ($phoneChanged || !$user->phone_verified || !$user->email_verified) {
            $this->showVerificationModal = true;
            session()->flash('message', 'Contact info saved. Please complete verification.');
        } else {
            session()->flash('message', 'Contact information updated successfully.');
            return redirect()->route('user.gift.create-gift');
        }
    }

    // Verification Modal Methods
    public function closeVerificationModal()
    {
        $this->showVerificationModal = false;
        $this->currentVerificationStep = 'choose';
        $this->phone_code_sent = false;
        $this->email_code_sent = false;
        $this->phone_verification_code = '';
        $this->email_verification_code = '';
        $this->resetValidation();
    }

    public function startPhoneVerification()
    {
        $this->currentVerificationStep = 'phone';
    }

    public function startEmailVerification()
    {
        $this->currentVerificationStep = 'email';
    }

    public function goBackToChoice()
    {
        $this->currentVerificationStep = 'choose';
        $this->phone_code_sent = false;
        $this->email_code_sent = false;
        $this->resetValidation();
    }

    // Phone Verification
    public function sendPhoneVerificationCode()
    {
        try {
            $code = rand(100000, 999999);
            $formattedPhone = $this->formatPhone($this->phone);

            PhoneOtp::updateOrCreate(
                ['phone' => $this->phone],
                ['code' => $code, 'expires_at' => now()->addMinutes(10)]
            );

            $response = Http::post('https://v3.api.termii.com/api/sms/send', [
                'api_key' => config('services.termii.api_key'),
                'message_type' => 'NUMERIC',
                'to' => $formattedPhone,
                'from' => config('services.termii.sender_id'),
                'channel' => 'generic',
                'type' => 'plain',
                'sms' => "Your verification code is: {$code} - Famlic"
            ]);

            if ($response->successful()) {
                $this->phone_code_sent = true;
                session()->flash('message', 'Phone verification code sent successfully.');
            } else {
                Log::error('SMS send failed', ['response' => $response->body()]);
                session()->flash('error', 'Failed to send phone verification code.');
            }
        } catch (Throwable $e) {
            Log::error('Phone OTP error', ['error' => $e->getMessage()]);
            session()->flash('error', 'Something went wrong. Please try again.');
        }
    }

    public function verifyPhoneNumber()
    {
        $this->validate(['phone_verification_code' => 'required|digits:6']);

        $otp = PhoneOtp::where('phone', $this->phone)
            ->where('code', $this->phone_verification_code)
            ->where('expires_at', '>=', now())
            ->first();

        if (!$otp) {
            session()->flash('error', 'Invalid or expired phone verification code.');
            return;
        }

        Auth::user()->update([
            'phone_verified' => true,
            'phone_verified_at' => now(),
        ]);

        $otp->delete();
        session()->flash('message', 'Phone verified successfully!');

        $this->checkVerificationComplete();
    }

    // Email Verification
    public function sendEmailVerificationCode()
    {
        try {
            $code = rand(100000, 999999);
            $user = Auth::user();

            EmailOtp::updateOrCreate(
                ['email' => $user->email],
                ['code' => $code, 'expires_at' => now()->addMinutes(10)]
            );

            // Fixed: Remove undefined $verificationUrl variable and pass $code instead
            Mail::to($user->email)->send(new EmailVerification($user->name, $code));

            $this->email_code_sent = true;
            session()->flash('message', 'Email verification code sent successfully.');
        } catch (Throwable $e) {
            Log::error('Email OTP error', ['error' => $e->getMessage()]);
            session()->flash('error', 'Failed to send email verification code.');
        }
    }

    public function verifyEmailAddress()
    {
        $this->validate(['email_verification_code' => 'required|digits:6']);

        $user = Auth::user();
        $otp = EmailOtp::where('email', $user->email)
            ->where('code', $this->email_verification_code)
            ->where('expires_at', '>=', now())
            ->first();

        if (!$otp) {
            session()->flash('error', 'Invalid or expired email verification code.');
            return;
        }

        $user->update([
            'email_verified' => true,
            'email_verified_at' => now(),
        ]);

        $otp->delete();
        session()->flash('message', 'Email verified successfully!');

        $this->checkVerificationComplete();
    }

    private function checkVerificationComplete()
    {
        $user = Auth::user()->refresh();

        if ($user->phone_verified && $user->email_verified) {
            $this->closeVerificationModal();
            session()->flash('message', 'All verifications complete! You can now create your gift.');
            return redirect()->route('user.gift.create-gift');
        } else {
            $this->currentVerificationStep = 'choose';
        }
    }

    private function formatPhone($phone)
    {
        return Str::startsWith($phone, '+') ? $phone : '+234' . ltrim($phone, '0');
    }

    public function nextStep()
    {
        $this->validateCurrentStep();

        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
        }
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    private function validateCurrentStep()
    {
        if ($this->currentStep == 1) {
            $this->validate([
                'title' => 'required|string|max:255',
                'reason' => 'required|string|max:255',
                'description' => 'required|string|max:1000',
            ]);
        } elseif ($this->currentStep == 2) {
            $this->validate([
                'target_amount' => 'required|numeric|min:1',
                'deadline' => 'required|date|after:today',
                'gift_image' => 'nullable|image|max:2048',
            ]);
        }
    }

    public function updatedTargetAmount()
    {
        $this->calculateFinalTarget();
    }

    public function updatedIncludeFee()
    {
        $this->calculateFinalTarget();
    }

    public function calculateFinalTarget()
    {
        if ($this->include_fee && is_numeric($this->target_amount)) {
            $this->finalTargetAmount = round($this->target_amount / 0.95, 2); // adds 5% correctly
        } else {
            $this->finalTargetAmount = $this->target_amount;
        }
    }

    public function submitForm()
    {
        if ($this->currentStep < $this->totalSteps) {
            $this->nextStep();
        } else {
            $this->createGift();
        }
    }

    public function createGift()
    {
        $this->validate();

        $imagePath = null;
        if ($this->gift_image) {
            $imagePath = $this->gift_image->store('gift-images', 'public');
        }

        $settings = [
            'allow_messages' => $this->allow_messages,
            'min_contribution' => $this->min_contribution ?: null,
        ];

        $targetAmount = $this->include_fee ? $this->finalTargetAmount : $this->target_amount;

        $giftRequest = GiftRequest::create([
            'user_id' => Auth::id(),
            'title' => $this->title,
            'reason' => $this->reason,
            'description' => $this->description,
            'target_amount' => $targetAmount,
            'deadline' => $this->deadline ?? now()->addDays(60)->toDateString(),
            'gift_image' => $imagePath,
            'is_public' => $this->is_public,
            'settings' => $settings,
        ]);

        try {
            $user = Auth::user();
            $formattedPhone = $this->formatPhone($user->phone);

            $url = $giftRequest->getPublicUrl();
            $expiry = Carbon::parse($giftRequest->deadline)->format('M d, Y');

            $message = "Your gift request '{$giftRequest->title}' has been created!\n\n"
                . "Share your link: {$url}\n"
                . "Expires on: {$expiry}\n\n"
                . "Encourage friends & family to support you";

            $response = Http::post('https://v3.api.termii.com/api/sms/send', [
                'api_key' => config('services.termii.api_key'),
                'message_type' => 'NUMERIC',
                'to' => $formattedPhone,
                'from' => config('services.termii.sender_id'),
                'channel' => 'generic',
                'type' => 'plain',
                'sms' => $message
            ]);

            if (!$response->successful()) {
                Log::error('GiftRequest SMS failed', ['response' => $response->body()]);
            }
            Mail::to($user->email)->send(new GiftCreatedEmail(
                $user->name,
                $giftRequest->title,
                $url,
                $expiry
            ));
        } catch (Throwable $e) {
            Log::error('GiftRequest SMS error', ['error' => $e->getMessage()]);
        }

        session()->flash('message', 'Gift request created successfully!');
        return redirect()->route('user.gift.index');
    }

    public function render()
    {
        $user = Auth::user();

        // Check if contact info is complete
        if ($this->isContactInfoIncomplete($user)) {
            $this->loadUserContactInfo();
            $this->showContactModal = true;
        }

        // Check verification status
        elseif (!$user->phone_verified || !$user->email_verified) {
            $this->phone = $user->phone;
            $this->showVerificationModal = true;
        }

        return view('livewire.user.create-gift');
    }
}
