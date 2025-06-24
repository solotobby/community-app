<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LevelItem extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'level_id',
        'item_name',
        'item_url',
        'price',
        'currency',
        'created_by',
    ];

    public function level()
    {
        return $this->belongsTo(Level::class, 'level_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
