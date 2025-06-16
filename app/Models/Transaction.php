<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Transaction extends Model
{
    use HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'reference',
        'user_id',
        'transaction_type',
        'transaction_reason',
        'level_id',
        'amount',
        'status',
        'metadata'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class)->with('level');
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }
}
