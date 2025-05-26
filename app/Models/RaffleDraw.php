<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RaffleDraw extends Model
{
    use HasFactory;

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
