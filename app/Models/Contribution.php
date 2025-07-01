<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Contribution extends Model
{
    use HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'gift_request_id',
        'contributor_name',
        'contributor_email',
        'amount',
        'currency',
        'message',
        'is_anonymous',
        'payment_reference',
        'status',
        'payment_data',
        'payment_method',
        'payment_verified_at',
        'virtual_account_details',

    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'is_anonymous' => 'boolean',
        'payment_data' => 'array',
        'payment_verified_at' => 'datetime',
        'virtual_account_details' => 'array',

    ];

    // Relationships
    public function giftRequest()
    {
        return $this->belongsTo(GiftRequest::class);
    }

    // Accessors
    public function getDisplayNameAttribute()
    {
        return $this->is_anonymous ? 'Anonymous' : $this->contributor_name;
    }

    // Methods
    public function markAsCompleted()
    {
        $this->status = 'completed';
        $this->save();

        $this->giftRequest->updateCurrentAmount();
    }

    public function markAsFailed()
    {
        $this->status = 'failed';
        $this->save();
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isFailed(): bool
    {
        return $this->status === 'failed';
    }

    public function isCardPayment(): bool
    {
        return $this->payment_method === 'card';
    }

    public function isBankTransfer(): bool
    {
        return $this->payment_method === 'bank_transfer';
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeCardPayments($query)
    {
        return $query->where('payment_method', 'card');
    }

    public function scopeBankTransfers($query)
    {
        return $query->where('payment_method', 'bank_transfer');
    }
}
