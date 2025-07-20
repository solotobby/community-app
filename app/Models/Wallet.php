<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $fillable = [
        'user_id',
        'balance',
        'processing_balance',
        'withdrawable_balance',
        'currency',
        'user_role'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
