<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\GiftRequest;
use App\Models\PhoneOtp;
use App\Models\EmailOtp;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Throwable;
use Illuminate\Support\Facades\Auth;

class GiftIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $statusFilter = 'all';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    public $showMyGifts = false;

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

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => 'all'],
        'sortBy' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
        'showMyGifts' => ['except' => false],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingShowMyGifts()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['search', 'statusFilter', 'sortBy', 'sortDirection', 'showMyGifts']);
        $this->resetPage();
    }

    public function createGift()
    {
        $user = auth()->user();

        // Check if contact info is complete
        if ($this->isContactInfoIncomplete($user)) {
            $this->loadUserContactInfo();
            $this->showContactModal = true;
            return;
        }

        // Check verification status
        if (!$user->phone_verified || !$user->email_verified) {
            $this->phone = $user->phone;
            $this->showVerificationModal = true;
            return;
        }

        return redirect()->route('user.gift.create-gift');
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
        $user = auth()->user();
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

        $user = auth()->user();
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
            session()->flash('success', 'Contact info saved. Please complete verification.');
        } else {
            session()->flash('success', 'Contact information updated successfully.');
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
                session()->flash('success', 'Phone verification code sent successfully.');
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

        auth()->user()->update([
            'phone_verified' => true,
            'phone_verified_at' => now(),
        ]);

        $otp->delete();
        session()->flash('success', 'Phone verified successfully!');

        $this->checkVerificationComplete();
    }

    // Email Verification
    public function sendEmailVerificationCode()
    {
        try {
            $code = rand(100000, 999999);
            $user = auth()->user();

            EmailOtp::updateOrCreate(
                ['email' => $user->email],
                ['code' => $code, 'expires_at' => now()->addMinutes(10)]
            );

            Mail::raw("Your verification code is: {$code}", function ($message) use ($user) {
                $message->to($user->email)
                    ->subject('Email Verification Code - Famlic');
            });

            $this->email_code_sent = true;
            session()->flash('success', 'Email verification code sent successfully.');
        } catch (Throwable $e) {
            Log::error('Email OTP error', ['error' => $e->getMessage()]);
            session()->flash('error', 'Failed to send email verification code.');
        }
    }

    public function verifyEmailAddress()
    {
        $this->validate(['email_verification_code' => 'required|digits:6']);

        $user = auth()->user();
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
        session()->flash('success', 'Email verified successfully!');

        $this->checkVerificationComplete();
    }

    private function checkVerificationComplete()
    {
        $user = auth()->user()->fresh();

        if ($user->phone_verified && $user->email_verified) {
            $this->closeVerificationModal();
            session()->flash('success', 'All verifications complete! You can now create your gift.');
            return redirect()->route('user.gift.create-gift');
        } else {
            $this->currentVerificationStep = 'choose';
        }
    }

    private function formatPhone($phone)
    {
        return Str::startsWith($phone, '+') ? $phone : '+234' . ltrim($phone, '0');
    }

    private function expirePastGifts(): void
    {
        GiftRequest::where('user_id', Auth::id())
            ->where('status', 'active')
            ->where('deadline', '<', now())
            ->update([
                'status'    => 'expired',
                'is_public' => false,
            ]);
    }

    public function render()
    {
        $this->expirePastGifts();
        $query = GiftRequest::with([
            'user',
            'completedContributions'
        ])->where('user_id', Auth::id());

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        $query->orderBy($this->sortBy, $this->sortDirection);
        $gifts = $query->paginate(12);

        $stats = [
            'total' => GiftRequest::where('user_id', Auth::id())->count(),
            'active' => GiftRequest::where('status', 'active')->where('user_id', Auth::id())->count(),
            'completed' => GiftRequest::where('status', 'completed')->where('user_id', Auth::id())->count(),
            'total_raised' => GiftRequest::where('user_id', Auth::id())->sum('current_amount'),
        ];

        return view('livewire.user.gift-index', [
            'gifts' => $gifts,
            'stats' => $stats
        ]);
    }
}
