<?php

namespace App\Livewire\Admin\User;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\GiftRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CrowdfundingDetails extends Component
{
    use WithFileUploads;

    public $gift;
    public $giftId;
    public $showEditModal = false;
    public $showDeleteModal = false;

    public $platform;

    // Edit form properties
    public $title;
    public $reason;
    public $description;
    public $target_amount;
    public $deadline;
    public $gift_image;
    public $current_image;
    public $is_public;
    public $allow_messages;
    public $min_contribution;
    public $remove_image = false;
    public $user;

    protected $rules = [
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

    public function mount($giftId)
    {
        $this->giftId = $giftId;

        $this->gift = GiftRequest::with(['user', 'completedContributions'])
            ->findOrFail($giftId);

        $this->user = $this->gift->user;

        $this->initializeEditForm();
    }


    public function loadGift()
    {
        $this->gift = GiftRequest::with(['user', 'completedContributions'])
            ->findOrFail($this->giftId);

        $this->initializeEditForm();
    }


    public function initializeEditForm()
    {
        $this->title = $this->gift->title;
        $this->reason = $this->gift->reason;
        $this->description = $this->gift->description;
        $this->target_amount = $this->gift->target_amount;
        $this->deadline = $this->gift->deadline ? $this->gift->deadline->format('Y-m-d') : '';
        $this->current_image = $this->gift->gift_image;
        $this->is_public = $this->gift->is_public;

        $settings = $this->gift->settings ?? [];
        $this->allow_messages = $settings['allow_messages'] ?? true;
        $this->min_contribution = $settings['min_contribution'] ?? '';
    }

    public function toggleStatus()
    {

        // if ($this->gift->completedContributions()->count() > 0 && $this->gift->status === 'active') {
        //     session()->flash('error', 'Cannot pause gift with existing contributions.');
        //     return;
        // }

        $newStatus = $this->gift->is_public === true ? false : true;
        $this->gift->update(['is_public' => $newStatus]);


        session()->flash('message', "Gift Status Updated successfully.");
        $this->loadGift();
    }

    public function openEditModal()
    {
        $this->initializeEditForm();
        $this->showEditModal = true;
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->resetValidation();
        $this->gift_image = null;
        $this->remove_image = false;
    }

    public function updateGift()
    {
        $this->validate();

        $updateData = [
            'title' => $this->title,
            'reason' => $this->reason,
            'description' => $this->description,
            'target_amount' => $this->target_amount,
            'deadline' => $this->deadline ?: null,
            'is_public' => $this->is_public,
            'settings' => [
                'allow_messages' => $this->allow_messages,
                'min_contribution' => $this->min_contribution ?: null,
            ]
        ];

        if ($this->gift_image) {
            if ($this->current_image) {
                Storage::disk('public')->delete($this->current_image);
            }
            $updateData['gift_image'] = $this->gift_image->store('gift-images', 'public');
        } elseif ($this->remove_image && $this->current_image) {
            Storage::disk('public')->delete($this->current_image);
            $updateData['gift_image'] = null;
        }

        $this->gift->update($updateData);

        session()->flash('message', 'Gift updated successfully.');
        $this->closeEditModal();
        $this->loadGift();
    }

    public function openDeleteModal()
    {
        $this->showDeleteModal = true;
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
    }

    public function deleteGift()
    {
        if ($this->gift->completedContributions()->count() > 0) {
            session()->flash('error', 'Cannot delete gift with existing contributions.');
            $this->closeDeleteModal();
            return;
        }

        if ($this->gift->gift_image) {
            Storage::disk('public')->delete($this->gift->gift_image);
        }

        $this->gift->delete();

        session()->flash('message', 'Gift deleted successfully.');
        return redirect()->route('livewire.admin.user.user-crowdfunding');
    }


    public function shareGift($platform)
    {
        $url = urlencode($this->gift->getPublicUrl());
        $text = urlencode("Help donate to: " . $this->gift->title);

        $shareUrls = [
            'facebook' => "https://www.facebook.com/sharer/sharer.php?u={$url}",
            'twitter' => "https://twitter.com/intent/tweet?url={$url}&text={$text}",
            'whatsapp' => "https://wa.me/?text={$text}%20{$url}",
            'telegram' => "https://t.me/share/url?url={$url}&text={$text}",
        ];

        if (isset($shareUrls[$platform])) {
            $this->dispatch('openWindow', $shareUrls[$platform]);
        }
    }

    public function copyLink()
    {
        $this->dispatch('copyToClipboard', $this->gift->getPublicUrl());
        session()->flash('message', 'Link copied to clipboard!');
    }

    public function render()
    {
        return view('livewire.admin.user.crowdfunding-details', [
            'gift' => $this->gift,
            'contributions' => $this->gift->completedContributions()->latest()->take(10)->get(),
            'stats' => [
                'total_contributors' => $this->gift->completedContributions()->distinct('contributor_email')->count(),
                'total_contributions' => $this->gift->completedContributions()->count(),
                'average_contribution' => $this->gift->completedContributions()->avg('amount') ?: 0,
                'progress_percentage' => $this->gift->target_amount > 0 ?
                    min(100, ($this->gift->current_amount / $this->gift->target_amount) * 100) : 0
            ]
        ]);
    }
}
