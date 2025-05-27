<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\Reward;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
}
