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
            $expiry = \Carbon\Carbon::parse($giftRequest->deadline)->format('M d, Y');

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
        } catch (\Throwable $e) {
            Log::error('GiftRequest SMS error', ['error' => $e->getMessage()]);
        }

        session()->flash('message', 'Gift request created successfully!');
        return redirect()->route('user.gift.index');
    }

    private function formatPhone($phone)
    {
        return Str::startsWith($phone, '+') ? $phone : '+234' . ltrim($phone, '0');
    }


    public function render()
    {
        return view('livewire.user.create-gift');
    }
}
