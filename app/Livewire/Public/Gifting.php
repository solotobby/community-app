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

        // Check for any pending bank transfer contributions and restore state
        $this->restorePendingBankTransfer();
    }

    /**
     * Restore pending bank transfer state from database
     */
    private function restorePendingBankTransfer()
    {
        // Look for recent pending bank transfer contribution for this gift
        // You might want to also match by session or user if you have authentication
        $pendingContribution = Contribution::where('gift_request_id', $this->gift?->id)
            ->where('status', 'pending')
            ->where('payment_method', 'bank_transfer')
            ->whereNotNull('virtual_account_details')
            ->where('created_at', '>=', now()->subHours(1)) // Only restore recent ones
            ->latest()
            ->first();

        if ($pendingContribution && $pendingContribution->virtual_account_details) {
            // Check if virtual account is still valid (not expired)
            $accountDetails = $pendingContribution->virtual_account_details;
            $expiresAt = isset($accountDetails['expires_at'])
                ? \Carbon\Carbon::parse($accountDetails['expires_at'])
                : null;

            if (!$expiresAt || $expiresAt->isFuture()) {
                $this->virtual_account = $accountDetails;
                $this->pending_contribution_id = $pendingContribution->id;
                $this->payment_method = 'bank_transfer';
                $this->contributor_name = $pendingContribution->contributor_name;
                $this->contributor_email = $pendingContribution->contributor_email;
                $this->amount = $pendingContribution->amount;
                $this->is_anonymous = $pendingContribution->is_anonymous;
            }
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
                return;
            }
        } elseif ($this->payment_method === 'bank_transfer') {
            $virtualAccount = $this->generateVirtualAccount($contribution);

            if ($virtualAccount) {
                // Save virtual account details to the contribution record
                $contribution->update([
                    'virtual_account_details' => $virtualAccount
                ]);

                $this->virtual_account = $virtualAccount;
                $this->pending_contribution_id = $contribution->id;

                session()->flash('message', 'Virtual account generated successfully. Please transfer the exact amount.');

                // Force re-render to show bank transfer details
                $this->dispatch('$refresh');
                return;
            } else {
                session()->flash('error', 'Failed to generate virtual account. Please try again.');
                return;
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

            Log::error('Paystack initialization failed', ['response' => $response->body()]);
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

            Log::info('Virtual account generation response', ['response' => $response->json()]);

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
        try {
            // 1. Check if customer exists
            $lookup = Http::withToken(config('services.paystack.secret_key'))
                ->get('https://api.paystack.co/customer', [
                    'email' => $contribution->contributor_email,
                ]);

            if ($lookup->successful() && !empty($lookup->json()['data']) && count($lookup->json()['data']) > 0) {
                return $lookup->json()['data'][0]['customer_code'];
            }

            // 2. Create new customer
            $create = Http::withToken(config('services.paystack.secret_key'))
                ->post('https://api.paystack.co/customer', [
                    'email'      => $contribution->contributor_email,
                    'first_name' => Str::before($contribution->contributor_name, ' ') ?? "Famlic",
                    'last_name'  => Str::after($contribution->contributor_name, ' ') ?? "Donor",
                ]);

            if ($create->successful()) {
                return $create->json()['data']['customer_code'];
            }

            Log::error('Failed to create Paystack customer', ['response' => $create->body()]);
            return null;
        } catch (\Throwable $e) {
            Log::error('Error getting/creating Paystack customer', ['error' => $e->getMessage()]);
            return null;
        }
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
                        'payment_data' => $data, // Store full payment response
                    ]);

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

    /**
     * Check if the current virtual account has expired
     */
    public function checkVirtualAccountExpiry()
    {
        if ($this->virtual_account && isset($this->virtual_account['expires_at'])) {
            $expiresAt = \Carbon\Carbon::parse($this->virtual_account['expires_at']);

            if ($expiresAt->isPast()) {
                // Mark contribution as expired and reset form
                if ($this->pending_contribution_id) {
                    $contribution = Contribution::find($this->pending_contribution_id);
                    if ($contribution) {
                        $contribution->update(['status' => 'expired']);
                    }
                }

                $this->resetForm();
                session()->flash('error', 'Virtual account has expired. Please generate a new one.');
                $this->dispatch('$refresh');
            }
        }
    }

    /**
     * Regenerate virtual account for existing contribution
     */
    public function regenerateVirtualAccount()
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

        $virtualAccount = $this->generateVirtualAccount($contribution);

        if ($virtualAccount) {
            // Update the existing contribution with new virtual account details
            $contribution->update([
                'virtual_account_details' => $virtualAccount,
                'status' => 'pending' // Reset status in case it was expired
            ]);

            $this->virtual_account = $virtualAccount;
            session()->flash('message', 'New virtual account generated successfully.');
            $this->dispatch('$refresh');
        } else {
            session()->flash('error', 'Failed to generate new virtual account. Please try again.');
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
