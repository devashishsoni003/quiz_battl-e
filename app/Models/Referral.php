<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    use HasFactory;

    protected $fillable = [
        'referrer_id',
        'referred_user_id',
        'referral_code',
        'reward_amount',
        'status',
        'joined_at',
        'rewarded_at',
    ];

    protected $casts = [
        'joined_at' => 'datetime',
        'rewarded_at' => 'datetime',
    ];

    public function referrer()
    {
        return $this->belongsTo(\App\Models\User::class, 'referrer_id');
    }

    public function referredUser()
    {
        return $this->belongsTo(\App\Models\User::class, 'referred_user_id');
    }
}
