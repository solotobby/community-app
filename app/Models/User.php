<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'has_subscribed',
        'referral_code',
        'level',
        'referrer_id',
        'transaction_pin',
        'raffle_draw_count',
        'can_raffle',
        'address',
        'country',
        'lga',
        'state',
        'landmark',
        'address',
        'phone_verified_at',
        'phone_verified',
        'phone'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'transaction_pin',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->map(fn(string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }

    public static function booted()
    {
        static::creating(function ($user) {
            do {
                $code = Str::upper(Str::random(8));
            } while (self::where('referral_code', $code)->exists());

            $user->referral_code = $code;
        });
    }

    // The user who referred this user
    public function referrer()
    {
        return $this->belongsTo(User::class, 'referrer_id');
    }

    // The users this user has referred
    public function referrals()
    {
        return $this->hasMany(User::class, 'referrer_id');
    }

    public function bankInfo()
    {
        return $this->hasOne(BankInfo::class);
    }

    public function level()
    {
        return $this->belongsTo(Level::class, 'level');
    }

    public function raffleDraws()
    {
        return $this->hasMany(RaffleDraw::class);
    }
}
