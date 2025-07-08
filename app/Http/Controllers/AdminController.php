<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function fundAdminWallet($amount, $reason)
    {
        return DB::transaction(function () use ($amount, $reason) {
            Transaction::create([
                'reference'          => 'ADM_' . Str::upper(Str::random(15)),
                'user_id'            => 0,
                'transaction_type'   => 'admin',
                'transaction_reason' => $reason,
                'level_id'           => 0,
                'amount'             => $amount,
                'status'             => 'success',
            ]);

            $wallet = Wallet::firstOrCreate(
                ['user_id' => 0],
                ['balance' => 0]
            );

            $wallet->increment('balance', $amount);

            return true;
        });
    }
}
