<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Str;

class GiftRequest extends Model
{
    use HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'title',
        'reason',
        'description',
        'slug',
        'target_amount',
        'current_amount',
        'currency',
        'deadline',
        'gift_image',
        'status',
        'is_public',
        'settings'
    ];

    protected $casts = [
        'target_amount' => 'decimal:2',
        'current_amount' => 'decimal:2',
        'deadline' => 'date',
        'is_public' => 'boolean',
        'settings' => 'array'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($giftRequest) {
            if (empty($giftRequest->slug)) {
                $giftRequest->slug = Str::slug($giftRequest->title) . '-' . Str::random(8);
            }
        });
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function contributions()
    {
        return $this->hasMany(Contribution::class);
    }

    public function completedContributions()
    {
        return $this->hasMany(Contribution::class)->where('status', 'completed');
    }

    public function wallet()
    {
        return $this->belongsTo(Wallet::class, 'user_id', 'user_id');
    }


    // Accessors & Mutators
    public function getProgressPercentageAttribute()
    {
        if ($this->target_amount <= 0) return 0;
        return min(100, ($this->current_amount / $this->target_amount) * 100);
    }

    public function getRemainingAmountAttribute()
    {
        return max(0, $this->target_amount - $this->current_amount);
    }

    public function getIsExpiredAttribute()
    {
        return $this->deadline && $this->deadline->isPast();
    }

    public function getContributorsCountAttribute()
    {
        return $this->completedContributions()->count();
    }

    // Methods
    public function updateCurrentAmount()
    {
        $this->current_amount = $this->completedContributions()->sum('amount');
        $this->save();
    }

    public function getPublicUrl()
    {
        return route('gift.public', $this->slug);
    }

    public function canReceiveContributions()
    {
        return $this->status === 'active' &&
            $this->is_public &&
            !$this->isExpired() &&
            $this->current_amount < $this->target_amount;
    }

    public function isTargetReached(): bool
    {
        return $this->current_amount >= $this->target_amount;
    }

    public function isExpired(): bool
    {
        return $this->deadline <= now();
    }

    public function getDaysRemainingAttribute(): int
    {
        if ($this->is_expired) {
            return 0;
        }

        return max(now()->diffInDays($this->deadline, false), 0);
    }

    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    public function scopeActive($query)
    {
        return $query->where('is_public', true)
            ->where('deadline', '>', now());
    }

    public function scopeExpired($query)
    {
        return $query->where('deadline', '<=', now());
    }
}
