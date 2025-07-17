<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GiftReason extends Model
{
    protected $fillable = [
        'reason',
        'icon',
        'status',
    ];
}
