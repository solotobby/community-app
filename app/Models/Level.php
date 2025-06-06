<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Level extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'registration_amount',
        'entry_gift',
        'referral_bonus',
        'currency',
        'created_by',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function levelItems()
    {
        return $this->hasMany(LevelItem::class);
    }
}
