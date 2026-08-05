<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'image',
        'title',
        'sorting',
        'status',
    ];

    /**
     * Get the full URL of the image.
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/categories/' . $this->image);
        }
        return null;
    }

    /**
     * Get the quiz levels for the category.
     */
    public function quizLevels()
    {
        return $this->hasMany(QuizLevel::class);
    }
}
