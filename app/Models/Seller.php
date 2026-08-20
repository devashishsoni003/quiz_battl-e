<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Seller extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'sellers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'mobile_number',
        'email',
        'whatsapp_number',
        'image',
        'password',
        'status',
        'coins',
        'u_id',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($seller) {
            if (empty($seller->u_id)) {
                $seller->u_id = static::generateUniqueUId();
            }
        });
    }

    /**
     * Generate a unique 6-digit serial-wise seller ID.
     */
    public static function generateUniqueUId()
    {
        $lastSeller = static::orderBy('id', 'desc')->first();
        if ($lastSeller && $lastSeller->u_id) {
            $lastNumber = (int) $lastSeller->u_id;
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 100001;
        }

        return (string) $nextNumber;
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'status' => 'boolean',
            'coins' => 'integer',
        ];
    }

    /**
     * Get the seller's store/profile image URL.
     */
    public function getImageUrlAttribute()
    {
        if ($this->image && file_exists(public_path('storage/sellers/' . $this->image))) {
            return asset('storage/sellers/' . $this->image);
        }
        return asset('assets/images/profile.jpg');
    }

    /**
     * Get the transactions for the seller.
     */
    public function transactions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(SellerTransaction::class);
    }
}
