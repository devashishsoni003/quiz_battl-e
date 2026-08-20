<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'mobile_number',
        'username',
        'image',
        'dob',
        'gender',
        'password',
        'referral_code',
        'referred_by',
        'coins',
        'total_referrals',
        'total_referral_coins',
        'u_id',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (empty($user->referral_code)) {
                $user->referral_code = static::generateUniqueReferralCode();
            }
            if (empty($user->u_id)) {
                $user->u_id = static::generateUniqueUId();
            }
        });
    }

    /**
     * Generate a unique referral code.
     */
    public static function generateUniqueReferralCode()
    {
        do {
            $letters = chr(mt_rand(65, 90)) . chr(mt_rand(65, 90)) . chr(mt_rand(65, 90));
            $numbers = mt_rand(10000, 99999);
            $code = $letters . $numbers;
        } while (static::where('referral_code', $code)->exists());

        return $code;
    }

    /**
     * Generate a unique serial-wise user ID.
     */
    public static function generateUniqueUId()
    {
        $lastUser = static::orderBy('id', 'desc')->first();
        if ($lastUser && $lastUser->u_id) {
            $lastNumber = (int) substr($lastUser->u_id, 2);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 10001;
        }

        return 'QB' . $nextNumber;
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'image_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'dob' => 'date',
        ];
    }

    /**
     * Get the full URL for the user's profile image.
     */
    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? url($this->image) : null;
    }
}
