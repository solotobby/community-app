<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\GiftRequest;
use App\Models\Contribution;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;


class GiftDetail extends Component
{
    use WithFileUploads, WithPagination;

    public $gift;
    public $giftId;
    public $showEditModal = false;
    public $showEndModal = false;
    public $showSmsModal = false;

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

    // SMS Modal properties
    public $selectedContributors = [];
    public $smsMessage = '';
    public $messageTemplate = '';
    public $customMessage = '';
    public $sendToAll = false;

    protected $rules = [
        'title' => 'required|string|max:255',
        'reason' => 'required|string|max:255',
        'description' => 'required|string|max:1000',
        'target_amount' => 'required|numeric|min:1',
        'deadline' => 'nullable|date|after:today',
        'gift_image' => 'nullable|image|max:2048',
        'is_public' => 'boolean',
        'allow_messages' => 'boolean',
        'min_contribution' => 'nullable|numeric|min:1',
        'smsMessage' => 'required|string|max:160',
        'selectedContributors' => 'required_unless:sendToAll,true|array|min:1',
        'selectedContributors.*' => 'exists:contributions,id'
    ];

    protected $paginationTheme = 'bootstrap';

    public function mount($giftId)
    {
        $this->giftId = $giftId;
        $this->loadGift();
    }

    public function loadGift()
    {
        $this->gift = GiftRequest::with(['user', 'completedContributions'])
            ->where('id', $this->giftId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

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

    public function getMessageTemplates()
    {
        $giftTitle = $this->gift->title;
        $userName = auth()->user()->name;

        $templates = [
            'birthday' => [
                "Thank you for turning my birthday into something unforgettable. Your gift through Famlic showed me that celebrations are sweeter when shared with amazing people like you!",
                "My birthday fundraiser on Famlic was a success because of you. I appreciate you for giving me the best gift — your love and support!",
                "Instead of just cake and candles, your donation gave me memories I'll always treasure. Thank you for celebrating me on Famlic!",
                "Every birthday wish is special, but your support on Famlic was priceless. Thank you for making my day brighter!"
            ],
            'anniversary' => [
                "Thank you for your thoughtful donation towards our anniversary celebration! Your kindness made our special day even more meaningful.",
                "Your contribution warmed our hearts on our anniversary. Thank you for helping us celebrate this milestone with such generosity!",
                "We appreciate your generous gift for our anniversary. Your support made our celebration truly memorable. Thank you!"
            ],
            'health' => [
                "Your support on Famlic has lifted a huge weight from my heart. Thank you for helping me settle these medical bills and for giving me peace of mind.",
                "Every naira you donated on Famlic has brought me closer to recovery. I'll never forget your kindness in my time of need.",
                "You didn't just give money, you gave me strength. Thank you for helping me fight this health challenge through Famlic.",
                "Medical bills can be overwhelming, but your donation on Famlic reminded me that I am not alone. God bless you!"
            ],
            'achievement' => [
                "Thank you for celebrating my achievement with your generous contribution! Your support means the world to me. Warmly appreciated!",
                "Your donation made my achievement celebration even more special. Thank you for being part of this milestone!",
                "We're grateful for your support in celebrating this achievement. Your encouragement fuels our success!"
            ],
            'appreciation' => [
                "Thank you for your generous donation! Your kindness and support mean so much to us. God bless you abundantly!",
                "Your contribution touched our hearts deeply. We're grateful for your thoughtfulness and generosity!",
                "We appreciate your wonderful gift. Your support brings us joy and encouragement. Many thanks!"
            ],
            'wedding' => [
                "Thank you for your wonderful gift for our wedding! Your blessing means the world to us as we start this journey together. With love!",
                "Your generous contribution filled our hearts with joy. Thank you for celebrating our special day with us!",
                "We're touched by your donation for our wedding. Your support for our new beginning is truly appreciated!"
            ],
            'new_baby' => [
                "Thank you for your sweet gift! Your kindness welcomes our little one with so much love through Famlic.",
                "Your contribution fills our hearts with gratitude. Thank you for blessing our new arrival through Famlic!",
                "We're touched by your donation. Your generosity celebrates our bundle of joy beautifully!"
            ],
            'condolence' => [
                "Thank you for your compassionate donation during this difficult time. Your support brings comfort to our family. Blessings to you!",
                "Your contribution shows your caring heart. Thank you for standing with us in our time of grief.",
                "We're grateful for your donation and kind support. Your compassion means everything during this loss."
            ],
            'retirement' => [
                "Thank you for your thoughtful contribution to celebrate my retirement! Your kindness makes this milestone extra special!",
                "Your donation for my retirement celebration touched my heart. Thank you for being part of this new chapter!",
                "We appreciate your generous gift for the retirement celebration. Your support makes this transition memorable!"
            ],
            'business_support' => [
                "Because of you, my small business can breathe again. Thank you for supporting me through Famlic — your donation is the seed of my success.",
                "Your contribution has given my business a new beginning. Famlic made it so easy to see who believed in me, and I'm grateful it's you.",
                "This journey of raising capital would have been impossible without your help on Famlic. Thank you for investing in my dream.",
                "Every product I sell tomorrow will carry the impact of your support. Thank you for supporting my hustle on Famlic."
            ],
            'school_fees' => [
                "Your support helped me clear my school fees and keep my dreams alive. Thank you for standing by me on Famlic.",
                "Because of your donation on Famlic, I can sit in class without worry. Your kindness is shaping my future.",
                "Education is expensive, but your support on Famlic showed me that I have people who care. Thank you for believing in me.",
                "Every book I read, every lecture I attend, will be because of your help. Thank you for supporting my education through Famlic."
            ],
            'charity' => [
                "Your donation through Famlic is helping out-of-school children find hope again. Thank you for being a part of this cause.",
                "Because of you, we can bring food to more families in need. Your support on Famlic is feeding hope as much as it's feeding people.",
                "You've proven that kindness can change lives. Thank you for supporting our charity campaign on Famlic.",
                "Your donation didn't just touch one person, it touched a community. Thank you for being part of our mission through Famlic."
            ],
            'others' => [
                "Thank you for your generous donation! Your kindness and support mean so much to us. God bless you abundantly!",
                "Your contribution touched our hearts deeply. We're grateful for your thoughtfulness and generosity through Famlic!",
                "We appreciate your wonderful gift. Your support brings us joy and encouragement. Many thanks!"
            ]
        ];


        $reason = strtolower($this->gift->reason);
        return $templates[$reason] ?? $templates['default'];
    }

    public function updatedMessageTemplate()
    {
        if ($this->messageTemplate === 'custom') {
            $this->smsMessage = $this->customMessage;
        } else {
            $templates = $this->getMessageTemplates();
            $this->smsMessage = $templates[$this->messageTemplate] ?? '';
        }
    }

    public function updatedCustomMessage()
    {
        if ($this->messageTemplate === 'custom') {
            $this->smsMessage = $this->customMessage;
        }
    }

    public function openSmsModal()
    {
        $this->selectedContributors = [];
        $this->messageTemplate = '0';
        $this->smsMessage = '';
        $this->customMessage = '';
        $this->sendToAll = false;
        $this->showSmsModal = true;

        // Set default message
        $templates = $this->getMessageTemplates();
        $this->smsMessage = $templates[0];
    }

    public function closeSmsModal()
    {
        $this->showSmsModal = false;
        $this->resetValidation();
        $this->selectedContributors = [];
        $this->smsMessage = '';
        $this->messageTemplate = '';
        $this->customMessage = '';
        $this->sendToAll = false;
    }

    public function sendSmsAppreciation()
    {
        $this->validate([
            'smsMessage' => 'required|string|max:160',
            'selectedContributors' => 'required_unless:sendToAll,true|array|min:1',
        ]);

        if ($this->sendToAll) {
            $contributors = $this->getEligibleContributors();
        } else {
            $contributors = Contribution::whereIn('id', $this->selectedContributors)
                ->where('amount', '>=', 10000)
                ->whereNotNull('contributor_phone')
                ->get();
        }

        $sentCount = 0;
        $failedCount = 0;

        foreach ($contributors as $contribution) {
            $personalizedMessage = $this->personalizeMessage($this->smsMessage, $contribution);

            if ($this->sendSMS($contribution->contributor_phone, $personalizedMessage)) {
                $sentCount++;
                // Log SMS sent
                $contribution->update(['sms_sent_at' => now()]);
            } else {
                $failedCount++;
            }
        }

        if ($sentCount > 0) {
            session()->flash('message', "SMS sent successfully to {$sentCount} contributor(s)" .
                ($failedCount > 0 ? " ({$failedCount} failed)" : ""));
        } else {
            session()->flash('error', 'Failed to send SMS messages.');
        }

        $this->closeSmsModal();
    }

    private function personalizeMessage($message, $contribution)
    {
        $name = $contribution->is_anonymous ? 'Valued Contributor' : $contribution->contributor_name;

        return str_replace(
            ['{name}', '{amount}'],
            [$name, number_format($contribution->amount)],
            $message
        );
    }


    private function sendSMS($phones, $message)
    {
        try {
            $phoneNumbers = is_array($phones)
                ? $phones
                : explode(',', $phones);

            $normalizedPhones = array_map(function ($phone) {
                $phone = trim($phone);
                return Str::startsWith($phone, '+')
                    ? $phone
                    : '+234' . ltrim($phone, '0');
            }, $phoneNumbers);

            $to = implode(',', $normalizedPhones);

            $payload = [
                'api_key' => config('services.termii.api_key'),
                'message_type' => 'NUMERIC',
                'to' => $to,
                'from' => config('services.termii.sender_id'),
                'channel' => 'generic',
                'type' => 'plain',
                'sms' => $message,
            ];

            $response = Http::post('https://v3.api.termii.com/api/sms/send', $payload);

            if ($response->successful()) {
                Log::info('SMS sent successfully', [
                    'response' => $response->body(),
                    'payload' => $payload
                ]);
                return true;
            } else {
                Log::error('SMS sending failed', [
                    'response' => $response->body(),
                    'payload' => $payload
                ]);
                return false;
            }
        } catch (\Throwable $e) {
            Log::error('SMS sending exception: ' . $e->getMessage());
            return false;
        }
    }


    private function getEligibleContributors()
    {
        return $this->gift->completedContributions()
            ->where('amount', '>=', 10000)
            ->whereNotNull('contributor_phone')
            ->whereNull('sms_sent_at')
            ->get();
    }

    public function toggleSelectAll()
    {
        if ($this->sendToAll) {
            $this->selectedContributors = $this->getEligibleContributors()->pluck('id')->toArray();
        } else {
            $this->selectedContributors = [];
        }
    }

    public function toggleStatus()
    {
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
            'description' => $this->description,
            'deadline' => $this->deadline ?: null,
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

    public function openEndModal()
    {
        $this->showEndModal = true;
    }

    public function closeEndModal()
    {
        $this->showEndModal = false;
    }

    public function endGift()
    {
        $user = auth()->user();
        $update = $this->gift->update([
            'is_public' => false,
            'status' => 'completed'
        ]);

        if ($update) {
            $user->wallet->decrement('processing_balance', $this->gift->current_amount);
            $user->wallet->increment('withdrawable_balance', $this->gift->current_amount);
        }

        session()->flash('message', 'Gift ended successfully.');
        $this->closeEndModal();
        $this->loadGift();
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
        $contributions = $this->gift->completedContributions()
            ->latest()
            ->paginate(10);

        $eligibleContributors = $this->getEligibleContributors();

        return view('livewire.user.gift-detail', [
            'gift' => $this->gift,
            'contributions' => $contributions,
            'eligibleContributors' => $eligibleContributors,
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
