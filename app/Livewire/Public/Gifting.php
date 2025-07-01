<?php

namespace App\Livewire\Public;

use Illuminate\Support\Str;
use Livewire\Component;
use App\Models\GiftRequest;
use Livewire\Attributes\Layout;
use App\Models\Contribution;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

#[Layout('components.layouts.public')]
class Gifting extends Component
{
    public $gift;
    public $showContributeForm = false;

    public $contributor_name = '';
    public $contributor_email = '';
    public $amount = '';
    public $message = '';
    public $is_anonymous = false;
    public $payment_method = 'card';
    public $virtual_account = null;
    public $pending_contribution_id = null;

    public function mount($slug)
    {
        $this->gift = GiftRequest::where('slug', $slug)
            // ->where('is_public', true)
            ->first();

        if (!$this->gift) {
            $this->gift = null;
        }
    }

    protected function rules()
    {
        $rules = [
            'contributor_name' => 'required|string|max:255',
            'contributor_email' => 'nullable|email|max:255',
            'amount' => 'required|numeric|min:1',
            'message' => 'nullable|string|max:500',
            'is_anonymous' => 'boolean',
            'payment_method' => 'required|in:card,bank_transfer',
        ];

        if ($this->gift && isset($this->gift->settings['min_contribution'])) {
            $rules['amount'] .= '|min:' . $this->gift->settings['min_contribution'];
        }

        return $rules;
    }

    public function toggleContributeForm()
    {
        if (!$this->gift || !$this->gift->canReceiveContributions()) {
            session()->flash('error', 'This gift request is no longer accepting contributions.');
            return;
        }

        $this->showContributeForm = !$this->showContributeForm;
    }

    public function contribute()
    {
        if (!$this->gift || !$this->gift->canReceiveContributions()) {
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
            'status' => 'pending',
            'payment_method' => $this->payment_method
        ]);

        if ($this->payment_method === 'card') {

            $paymentUrl = $this->initializePaystackPayment($contribution);

            if ($paymentUrl) {
                return redirect()->away($paymentUrl);
            } else {
                session()->flash('error', 'Failed to initialize payment. Please try again.');
            }
        } else {
            $virtualAccount = $this->generateVirtualAccount($contribution);

            if ($virtualAccount) {
                $this->virtual_account = $virtualAccount;
                $this->pending_contribution_id = $contribution->id;

                  Cache::put("virtual_account_{$contribution->id}", $virtualAccount, 45 * 60);

                session()->flash('message', 'Virtual account generated successfully. Please transfer the exact amount.');
            } else {
                session()->flash('error', 'Failed to generate virtual account. Please try again.');
            }
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

    private function generateVirtualAccount($contribution): ?array
    {
        try {
            $customerCode = $this->getOrCreatePaystackCustomer($contribution);

            if (!$customerCode) {
                Log::error('Unable to create/fetch Paystack customer for ' . $contribution->contributor_email);
                return null;
            }

            $payload = [
                'customer'       => $customerCode,
                'preferred_bank' => app()->environment('production') ? 'wema-bank' : 'test-bank',
                'country'        => 'NG',
                'type'           => 'nuban',
                'first_name' => Str::before($contribution->contributor_name, ' ') ?? "Famlic",
                'last_name'  => Str::after($contribution->contributor_name, ' ') ?? "Donor",
                'account_name'   => $contribution->contributor_name,
            ];

            $response = Http::withToken(config('services.paystack.secret_key'))
                ->post('https://api.paystack.co/dedicated_account', $payload);

            Log::info('Virtual account', ['response' => $response]);

            if (!$response->successful()) {
                Log::error('Paystack dedicated_account error', [
                    'status'  => $response->status(),
                    'body'    => $response->body(),
                ]);
                return null;
            }

            $data = $response->json()['data'];

            return [
                'account_number' => $data['account_number'],
                'account_name'   => $data['account_name'],
                'bank_name'      => $data['bank']['name'],
                'bank_code'      => $data['bank']['slug'],
                'created_at'     => now(),
                'expires_at'     => now()->addMinutes(30),
            ];
        } catch (\Throwable $e) {
            Log::error('Virtual account generation failed', ['error' => $e->getMessage()]);
            return null;
        }
    }

    private function getOrCreatePaystackCustomer($contribution): ?string
    {

        $lookup = Http::withToken(config('services.paystack.secret_key'))
            ->get('https://api.paystack.co/customer', [
                'email' => $contribution->contributor_email,
            ]);

        if ($lookup->successful() && !empty($lookup['data'][0]['customer_code'])) {
            return $lookup['data'][0]['customer_code'];
        }

        // 2. Create new customer
        $create = Http::withToken(config('services.paystack.secret_key'))
            ->post('https://api.paystack.co/customer', [
                'email'      => $contribution->contributor_email,
                'first_name' => Str::before($contribution->contributor_name, ' ') ?? "Famlic",
                'last_name'  => Str::after($contribution->contributor_name, ' ') ?? "Donor",
            ]);

        return $create->successful() ? $create['data']['customer_code'] : null;
    }
    public function verifyBankTransfer()
    {
        if (!$this->pending_contribution_id) {
            session()->flash('error', 'No pending contribution found.');
            return;
        }

        $contribution = Contribution::find($this->pending_contribution_id);

        if (!$contribution) {
            session()->flash('error', 'Contribution not found.');
            return;
        }

        $verified = $this->checkPaymentStatus($contribution);

        if ($verified) {
            session()->flash('message', 'Payment verified successfully! Thank you for your contribution.');
            $this->resetForm();
        } else {
            session()->flash('error', 'Payment not yet confirmed. Please wait a few minutes and try again, or contact support if you have already made the transfer.');
        }
    }

    private function checkPaymentStatus($contribution)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.paystack.secret_key'),
            ])->get("https://api.paystack.co/transaction/verify/{$contribution->payment_reference}");

            if ($response->successful()) {
                $data = $response->json()['data'];

                if ($data['status'] === 'success' && $data['amount'] == ($contribution->amount * 100)) {

                    $contribution->update([
                        'status' => 'completed',
                        'payment_verified_at' => now(),
                    ]);

                    // Clear cached virtual account
                    Cache::forget("virtual_account_{$contribution->id}");

                    return true;
                }
            }

            return false;
        } catch (Exception $e) {
            Log::error('Payment verification failed: ' . $e->getMessage());
            return false;
        }
    }

    private function resetForm()
    {
        $this->contributor_name = '';
        $this->contributor_email = '';
        $this->amount = '';
        $this->message = '';
        $this->is_anonymous = false;
        $this->payment_method = 'card';
        $this->virtual_account = null;
        $this->pending_contribution_id = null;
    }

    public function shareGift($platform)
    {
        if (!$this->gift) {
            return;
        }

        $url = urlencode($this->gift->getPublicUrl());
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
        if (!$this->gift) {
            return;
        }

        $this->dispatch('copyToClipboard', $this->gift->getPublicUrl());
        session()->flash('message', 'Link copied to clipboard!');
    }
    public function updatedPaymentMethod()
    {

        if ($this->payment_method === 'card') {
            $this->virtual_account = null;
            $this->pending_contribution_id = null;
        }
    }

    public function render()
    {
        $recentContributions = [];


        return view('gifting', [
            'recentContributions' => $recentContributions
        ]);
    }
}
