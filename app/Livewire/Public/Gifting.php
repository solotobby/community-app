<?php

namespace App\Livewire\Public;

use App\Http\Controllers\PaystackController;
use App\Models\Contribution;
use App\Models\GiftRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Exception;
use Throwable;

#[Layout('components.layouts.public')]
class Gifting extends Component
{
    public $gift;
    public $showContributeForm = false;
    public $resetForm = false;
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
            ->first();

        if (!$this->gift) {
            $this->gift = null;
        }
        $this->restorePendingBankTransfer();
    }

    /**
     * Restore pending bank transfer state from database
     */
    private function restorePendingBankTransfer()
    {
        $pendingContribution = Contribution::where('gift_request_id', $this->gift?->id)
            ->where('status', 'pending')
            ->where('payment_method', 'bank_transfer')
            ->whereNotNull('virtual_account_details')
            ->where('created_at', '>=', now()->subMinutes(30))
            ->latest()
            ->first();

        if ($pendingContribution && $pendingContribution->virtual_account_details) {
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
            $paystackController = app(PaystackController::class);
            $authorizationUrl = $paystackController->initializeFunding(
                $contribution->contributor_email,
                $contribution->amount,
                $contribution->payment_reference,
                route('payment.gifting.callback'),
                [
                    'gift_request_id' => $contribution->gift_request_id,
                    'transaction_id' => $contribution->id,
                    'type' => 'gifting',
                ]
            );

            if ($authorizationUrl) {
                return $authorizationUrl;
            } else {
                return back()->with('error', 'Unable to initialize payment. Please try again.');
            }
        } catch (Exception $e) {
            Log::error('Paystack initialization failed: ' . $e->getMessage());
            return null;
        }
    }

    private function generateVirtualAccount($contribution): ?array
    {
        try {
            $paystackController = app(PaystackController::class);
            $customerCode  = $paystackController->getOrCreatePaystackCustomer($contribution);

            if (!$customerCode) {
                Log::error(
                    'Unable to create/fetch Paystack customer for ' . $contribution->contributor_email
                );
                return null;
            }

            $payload = [
                'customer' => $customerCode,
                'preferred_bank' => app()->environment('local') ? 'test-bank' : 'wema-bank',
                'country' => 'NG',
                'type' => 'nuban',
                'first_name' => Str::before($contribution->contributor_name, ' ') ?? 'Famlic',
                'last_name' => Str::after($contribution->contributor_name, ' ') ?? 'Donor',
                'account_name' => $contribution->contributor_name,
            ];

            $data = $paystackController->createDedicatedAccount($payload);

            return [
                'account_number' => $data['account_number'],
                'account_name' => $data['account_name'],
                'bank_name' => $data['bank']['name'],
                'bank_code' => $data['bank']['slug'],
                'created_at' => now(),
                'expires_at' => now()->addMinutes(30),
            ];
        } catch (Throwable $e) {
            Log::error('Virtual account generation failed', ['error' => $e->getMessage()]);
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

    public function resetForm()
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
        $text = urlencode('Help contribute to: ' . $this->gift->title);

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
                'status' => 'pending'  // Reset status in case it was expired
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
