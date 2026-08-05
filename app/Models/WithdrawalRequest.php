<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawalRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'withdrawal_account_id',
        'coins',
        'coins_rate',
        'usd_amount',
        'usd_rate',
        'final_amount',
        'currency',
        'status',
        'transaction_id',
        'admin_note',
        'approved_by',
        'approved_at',
        'rejected_at',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function withdrawalAccount()
    {
        return $this->belongsTo(\App\Models\WithdrawalAccount::class);
    }

    public function admin()
    {
        return $this->belongsTo(\App\Models\SuperAdmin::class, 'approved_by');
    }
}
