<?php

namespace App\Http\Controllers;

use App\Models\Contribution;
use App\Models\Level;
use App\Models\Reward;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaystackController extends Controller
{
    public function initialize(Request $request)
    {
        $transaction = Transaction::where('reference', $request->reference)->firstOrFail();

        $paystackResponse = Http::withToken(config('services.paystack.secret_key'))->post(
            'https://api.paystack.co/transaction/initialize',
            [
                'email' => $transaction->user->email,
                'amount' => $transaction->amount * 100,
                'reference' => $transaction->reference,
                'callback_url' => route('paystack.payment.callback'),
            ]
        );

        Log::info('Paystack Init Response', [
            'status' => $paystackResponse->status(),
            'body' => $paystackResponse->json(),
        ]);

        $response = $paystackResponse->json();

        if (!$response['status']) {
            Log::error('Paystack error', [
                'response' => $response,
            ]);
            return back()->with('error', 'Payment failed: ' . $response['message']);
        }


        return redirect($response['data']['authorization_url']);
    }

    public function callback(Request $request)
    {
        $reference = $request->query('reference');
        $response = Http::withToken(config('services.paystack.secret_key'))
            ->get("https://api.paystack.co/transaction/verify/{$reference}")
            ->json();

        $transaction = Transaction::where('reference', $reference)->firstOrFail();

        if ($response['status'] && $response['data']['status'] === 'success') {
            $transaction->update(['status' => 'success']);

            $user = $transaction->user;
            $user->update([
                'registration_draw' => true,
                'has_subscribed' => true,
                'can_raffle' => true,
                'raffle_draw_count' => $user->raffle_draw_count + 1
            ]);

            $user->load('level', 'referrer');

            if ($user->referrer_id && $user->level) {
                $referrer = $user->referrer;

                $levelId = $user->level;
                $level =  Level::find($levelId);

                $bonus = $level->referral_bonus;

                Reward::create([
                    'user_id' => $referrer->id,
                    'referrer_id' => $user->id,
                    'reward_type' => 'referral',
                    'reward_status' => 'pending',
                    'is_claim' => false,
                    'amount' => $bonus,
                    'currency' => 'NGN',
                    'status' => 'active',
                ]);

                $referrer->update([
                    'can_raffle' => true,
                    'raffle_draw_count' => $referrer->raffle_draw_count + 1

                ]);
            }
            Auth::login($user);

            return redirect()->route('home')->with('success', 'Payment successful. Welcome!');
        } else {
            $transaction->update(['status' => 'failed']);
            return redirect()->route('home')->with('error', 'Payment failed.');
        }
    }

    public function giftingCallback(Request $request)
    {
        $reference = $request->query('reference');


        $response = Http::withToken(config('services.paystack.secret_key'))
            ->get("https://api.paystack.co/transaction/verify/{$reference}")
            ->json();

        $contribution = Contribution::where('payment_reference', $reference)->firstOrFail();

        if (data_get($response, 'status') && data_get($response, 'data.status') === 'success') {

            $contribution->markAsCompleted();
            $user = $contribution->giftRequest->user;

            $wallet = $user->wallet()->firstOrCreate([], ['balance' => 0]);

            $bonus = $contribution->amount;
            $wallet->increment('balance', $bonus);

            return redirect()
                ->route('gift.public', ['slug' => $contribution->giftRequest->slug])
                ->with('message', 'Payment successful. Thank you for your gifting!');
        }
        $contribution->update(['status' => 'failed']);

        return redirect()
            ->route('gift.public', ['slug' => $contribution->giftRequest->slug])
            ->with('error', 'Payment unsuccessful. Please try again.');
    }


    public function upgradeCallback(Request $request)
    {
        $reference = $request->query('reference');
        $response = Http::withToken(config('services.paystack.secret_key'))
            ->get("https://api.paystack.co/transaction/verify/{$reference}")
            ->json();

        $transaction = Transaction::where('reference', $reference)->firstOrFail();

        if ($response['status'] && $response['data']['status'] === 'success') {
            $transaction->update(['status' => 'success']);

            $user = $transaction->user;
            $metadata = json_decode($transaction->metadata);

            $user->update([
                'registration_draw' => true,
                'has_subscribed' => true,
                'can_raffle' => true,
                'level' => $metadata->to_level_id,
                'raffle_draw_count' => $user->raffle_draw_count + 1
            ]);


            $user->load('level', 'referrer');

            // if ($user->referrer_id && $user->level) {
            //     $referrer = $user->referrer;

            //     $levelId = $user->level;
            //     $level =  Level::find($levelId);

            //     $bonus = $level->referral_bonus;

            //     Reward::create([
            //         'user_id' => $referrer->id,
            //         'referrer_id' => $user->id,
            //         'reward_type' => 'referral',
            //         'reward_status' => 'pending',
            //         'is_claim' => false,
            //         'amount' => $bonus,
            //         'currency' => 'NGN',
            //         'status' => 'active',
            //     ]);

            //     $referrer->update([
            //         'can_raffle' => true,
            //         'raffle_draw_count' => $referrer->raffle_draw_count + 1

            //     ]);
            // }
            Auth::login($user);

            return redirect()->route('home')->with('success', 'Payment successful. Welcome!');
        } else {
            $transaction->update(['status' => 'failed']);
            return redirect()->route('home')->with('error', 'Payment failed.');
        }
    }

    public function resolveAccount($account_number, $bank_code)
    {
        $paystackSecretKey = config('services.paystack.secret_key');

        $response = Http::withToken($paystackSecretKey)
            ->get('https://api.paystack.co/bank/resolve', [
                'account_number' => $account_number,
                'bank_code' => $bank_code,
            ]);

        if ($response->successful() && $response->json('status')) {
            return [
                'status' => true,
                'recipient_code' => $response->json('data.recipient_code'),
                'data' => $response->json('data'),
            ];
        }

        return [
            'status' => false,
            'message' => $response->json('message') ?? 'Recipient creation failed',
        ];
    }

    public function createRecipient($name, $account_number, $bank_code, $currency)
    {
        $payload = [
            'type' => 'nuban',
            'name' => $name,
            'account_number' => $account_number,
            'bank_code' => $bank_code,
            'currency' => $currency,
        ];

        $paystackSecretKey = config('services.paystack.secret_key');

        $response = Http::withToken($paystackSecretKey)
            ->post('https://api.paystack.co/transferrecipient', $payload);

        if ($response->successful() && $response->json('status')) {
            return [
                'status' => true,
                'recipient_code' => $response->json('data.recipient_code'),
                'data' => $response->json('data'),
            ];
        }

        return [
            'status' => false,
            'message' => $response->json('message') ?? 'Recipient creation failed',
        ];
    }

    public function initializeTransfer($amount, $recipient_code, $reason = null, $txn = null)
    {
        $paystackSecretKey = config('services.paystack.secret_key');

        $response = Http::withToken($paystackSecretKey)
            ->post('https://api.paystack.co/transfer', [
                'source' => 'balance',
                'amount' => $amount * 100,
                'recipient' => $recipient_code,
                'reason' => $reason ?? 'Payout',
                'reference' => $txn,
            ]);

        if ($response->successful()) {
            return [
                'status' => true,
                'message' => 'Transfer initialized successfully',
                'data' => $response->json('data'),
            ];
        } else {
            return [
                'status' => false,
                'message' => $response->json('message') ?? 'Transfer failed',
                'errors' => $response->json(),
            ];
        }
    }

     public function handleWebhook(Request $request)
    {
        $signature = $request->header('x-paystack-signature');
        $computedSignature = hash_hmac('sha512', $request->getContent(), config('services.paystack.webhook_secret'));

        if (!hash_equals($signature, $computedSignature)) {
            Log::warning('Invalid Paystack webhook signature');
            return response('Invalid signature', 400);
        }

        $event = $request->input('event');
        $data = $request->input('data');

        Log::info('Paystack webhook received', ['event' => $event, 'reference' => $data['reference'] ?? 'N/A']);

        switch ($event) {
            case 'charge.success':
                $this->handleChargeSuccess($data);
                break;
            case 'transfer.success':
                $this->handleTransferSuccess($data);
                break;
            case 'dedicatedaccount.credit':
                $this->handleDedicatedAccountCredit($data);
                break;
            default:
                Log::info('Unhandled Paystack webhook event', ['event' => $event]);
        }

        return response('Webhook handled', 200);
    }

    private function handleChargeSuccess($data)
    {
        $reference = $data['reference'];
        $amount = $data['amount'] / 100;

        $contribution = Contribution::where('payment_reference', $reference)->first();

        if (!$contribution) {
            Log::warning('Contribution not found for reference', ['reference' => $reference]);
            return;
        }

        if ($contribution->status === 'completed') {
            Log::info('Contribution already completed', ['reference' => $reference]);
            return;
        }

        // Verify the amount matches
        if ($contribution->amount != $amount) {
            Log::warning('Amount mismatch for contribution', [
                'reference' => $reference,
                'expected' => $contribution->amount,
                'received' => $amount
            ]);
            return;
        }

        // Update contribution status
        $contribution->update([
            'status' => 'completed',
            'payment_verified_at' => now(),
        ]);

        Log::info('Contribution completed via webhook', ['reference' => $reference]);
    }

    private function handleDedicatedAccountCredit($data)
    {
        // This handles bank transfer payments to virtual accounts
        $reference = $data['reference'] ?? null;
        $amount = ($data['amount'] ?? 0) / 100; // Convert from kobo to naira
        $account_number = $data['account']['account_number'] ?? null;

        // Try to find contribution by various methods
        $contribution = null;

        // First, try to find by reference if available
        if ($reference) {
            $contribution = Contribution::where('payment_reference', $reference)->first();
        }

        // If not found by reference, try to find pending bank transfer contributions
        // that match the amount and have virtual account details
        if (!$contribution) {
            $contributions = Contribution::where('status', 'pending')
                ->where('payment_method', 'bank_transfer')
                ->whereNotNull('virtual_account_details')
                ->get();

            foreach ($contributions as $pendingContribution) {
                $virtualAccountDetails = $pendingContribution->virtual_account_details;

                if (isset($virtualAccountDetails['account_number']) &&
                    $virtualAccountDetails['account_number'] === $account_number &&
                    abs($pendingContribution->amount - $amount) < 0.01) { // Allow small floating point differences
                    $contribution = $pendingContribution;
                    break;
                }
            }
        }

        if (!$contribution) {
            Log::warning('No matching contribution found for dedicated account credit', [
                'account_number' => $account_number,
                'amount' => $amount,
                'reference' => $reference
            ]);
            return;
        }

        if ($contribution->status === 'completed') {
            Log::info('Contribution already completed', ['id' => $contribution->id]);
            return;
        }

        // Update contribution status
        $contribution->update([
            'status' => 'completed',
            'payment_verified_at' => now(),
        ]);

        // Clear cached virtual account details
        Cache::forget("virtual_account_{$contribution->id}");

        Log::info('Bank transfer contribution completed via webhook', [
            'contribution_id' => $contribution->id,
            'account_number' => $account_number,
            'amount' => $amount
        ]);
    }

    private function handleTransferSuccess($data)
    {
        // Handle successful transfers (if you implement payout functionality)
        Log::info('Transfer success webhook received', $data);
    }
}
