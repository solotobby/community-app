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
        'payment_data'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'is_anonymous' => 'boolean',
        'payment_data' => 'array'
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
}
