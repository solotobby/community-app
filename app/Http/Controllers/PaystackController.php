<?php

namespace App\Http\Controllers;

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
            $transaction->user->update(['has_subscribed' => true]);
            Auth::login($transaction->user);
            return redirect()->route('home')->with('success', 'Payment successful. Welcome!');
        } else {
            $transaction->update(['status' => 'failed']);
            return redirect()->route('home')->with('error', 'Payment failed.');
        }
    }
}
