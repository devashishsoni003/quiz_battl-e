<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WithdrawalSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'coins_per_usd',
        'usd_to_local_rate',
        'local_currency',
        'minimum_withdrawal_coins',
        'maximum_withdrawal_coins',
        'processing_time',
        'note',
        'status',
    ];
}
