<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeSlider extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
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
            return asset('storage/home/sliders/' . $this->image);
        }
        return null;
    }
}
