<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Frame extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'image',
        'required_level',
        'description',
        'sorting',
        'status',
    ];

    /**
     * Get the full URL of the image.
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/frames/' . $this->image);
        }
        return null;
    }
}
