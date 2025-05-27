<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RaffleDraw extends Model
{
    use HasFactory;

    const STATUS_PENDING = 'pending';
    const STATUS_EARNED = 'earned';
    const STATUS_EXPIRED = 'expired';
    protected $fillable = [
        'user_id',
        'reward',
        'price',
        'currency',
        'used_type',
        'status',
        'claimed_at',
        'expired_at',
    ];

     protected $casts = [
        'claimed_at' => 'datetime',
        'expired_at' => 'datetime',
        'price' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function isClaimable(): bool
    {
        return $this->status === self::STATUS_WON &&
            $this->expired_at->isFuture() &&
            is_null($this->claimed_at);
    }

     public function isExpired()
    {
        return $this->expired_at && now()->gt($this->expired_at);
    }

    public function canBeClaimed()
    {
        return $this->status === self::STATUS_PENDING && !$this->isExpired();
    }   

}
