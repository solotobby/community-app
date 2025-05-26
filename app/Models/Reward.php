<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Reward extends Model
{
    use HasUuids;

    protected $fillable = [
        'user_id',
        'referrer_id',
        'reward_type',
        'reward_status',
        'is_claim',
        'amount',
        'currency',
        'status',
        'claim_expired'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function referrer()
    {
        return $this->belongsTo(User::class, 'referrer_id');
    }
}
