<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomePromotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'image_2',
        'title',
        'description',
        'button_text',
        'link_type',
        'link_value',
        'sorting',
        'status',
    ];

    /**
     * Get the full URL of the image.
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/home/promotions/' . $this->image);
        }
        return null;
    }

    /**
     * Get the full URL of the second image.
     */
    public function getImage2UrlAttribute()
    {
        if ($this->image_2) {
            return asset('storage/home/promotions/' . $this->image_2);
        }
        return null;
    }
}
