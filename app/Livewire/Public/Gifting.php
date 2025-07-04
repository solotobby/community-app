<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\GiftRequest;
use Livewire\Attributes\Layout;
use App\Models\Contribution;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

#[Layout('components.layouts.public')] class Gifting extends Component
{
    public $gift;
    public $showContributeForm = false;

    // Contribution form fields
    public $contributor_name = '';
    public $contributor_email = '';
    public $amount = '';
    public $message = '';
    public $is_anonymous = false;

    public function mount($slug)
    {
        $this->gift = GiftRequest::where('slug', $slug)
            ->where('is_public', true)
            ->firstOrFail();
    }

    protected function rules()
    {
        $rules = [
            'contributor_name' => 'required|string|max:255',
            'contributor_email' => 'nullable|email|max:255',
            'amount' => 'required|numeric|min:1',
            'message' => 'nullable|string|max:500',
            'is_anonymous' => 'boolean',
        ];

        // Add minimum contribution rule if set
        if ($this->gift->settings['min_contribution'] ?? null) {
            $rules['amount'] .= '|min:' . $this->gift->settings['min_contribution'];
        }

        return $rules;
    }

    public function toggleContributeForm()
    {
        if (!$this->gift->canReceiveContributions()) {
            session()->flash('error', 'This gift request is no longer accepting contributions.');
            return;
        }

        $this->showContributeForm = !$this->showContributeForm;
    }

    public function contribute()
    {
        if (!$this->gift->canReceiveContributions()) {
            session()->flash('error', 'This gift request is no longer accepting contributions.');
            return;
        }

        $this->validate();

        // Create contribution
        $contribution = Contribution::create([
            'gift_request_id' => $this->gift->id,
            'contributor_name' => $this->contributor_name,
            'contributor_email' => $this->contributor_email,
            'amount' => $this->amount,
            'message' => $this->message,
            'is_anonymous' => $this->is_anonymous,
            'payment_reference' => 'GIFT-' . uniqid(),
            'status' => 'pending'
        ]);

        // Initialize Paystack payment
        $paymentUrl = $this->initializePaystackPayment($contribution);

        // $contribution->markAsCompleted();

        // Reset form
        // $this->reset(['contributor_name', 'contributor_email', 'amount', 'message', 'is_anonymous']);

         if ($paymentUrl) {
            // Redirect to Paystack payment page
            return redirect()->away($paymentUrl);
        } else {

            session()->flash('error', 'Failed to initialize payment. Please try again.');
        }

    }

    private function initializePaystackPayment($contribution)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.paystack.secret_key'),
                'Content-Type' => 'application/json',
            ])->post('https://api.paystack.co/transaction/initialize', [
                'email' => $contribution->contributor_email,
                'amount' => $contribution->amount * 100,
                'reference' => $contribution->payment_reference,
                'callback_url' => route('payment.gifting.callback'),
                'metadata' => [
                    'gift_request_id' => $contribution->gift_request_id,
                    'transaction_id' => $contribution->id,
                    'type' => 'gifting'
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['data']['authorization_url'] ?? null;
            }

            return null;
        } catch (Exception $e) {
            Log::error('Paystack initialization failed: ' . $e->getMessage());
            return null;
        }
    }
    public function shareGift($platform)
    {
        $url = urlencode(request()->url());
        $text = urlencode("Help contribute to: " . $this->gift->title);

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
        $this->dispatch('copyToClipboard', request()->url());
        session()->flash('message', 'Link copied to clipboard!');
    }

    public function render()
    {
        $recentContributions = $this->gift->completedContributions()
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('gifting',  [
            'recentContributions' => $recentContributions
        ]);
    }
}
