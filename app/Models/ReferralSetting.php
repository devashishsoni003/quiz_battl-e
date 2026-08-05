<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReferralSetting extends Model
{
    protected $fillable = [
        'banner_image',
        'title',
        'description',
        'reward_per_referral',
        'new_user_bonus',
        'share_title',
        'share_message',
        'share_link',
        'status',
    ];

    /**
     * Get the full URL of the banner image.
     */
    public function getBannerUrlAttribute()
    {
        if ($this->banner_image) {
            return asset('storage/referral/' . $this->banner_image);
        }
        return null;
    }
}
