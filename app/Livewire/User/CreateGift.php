<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\GiftRequest;
use Illuminate\Support\Facades\Auth;
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

    // Settings
    public $is_public = true;
    public $allow_messages = true;
    public $min_contribution = '';

    protected function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'reason' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'target_amount' => 'required|numeric|min:1',
            'deadline' => 'nullable|date|after:today',
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
                'deadline' => 'nullable|date|after:today',
                'gift_image' => 'nullable|image|max:2048',
            ]);
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

        $giftRequest = GiftRequest::create([
            'user_id' => Auth::id(),
            'title' => $this->title,
            'reason' => $this->reason,
            'description' => $this->description,
            'target_amount' => $this->target_amount,
            'deadline' => $deadline = $this->deadline ?? now()->addDays(60)->toDateString(),
            'gift_image' => $imagePath,
            'is_public' => $this->is_public,
            'settings' => $settings,
        ]);

        session()->flash('message', 'Gift request created successfully!');
        session()->flash('gift_url', $giftRequest->getPublicUrl());

        return redirect()->route('user.gift.index');
    }

    public function render()
    {
        return view('livewire.user.create-gift');
    }
}
