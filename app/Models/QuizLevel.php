<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuizLevel extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'title',
        'icon',
        'entry_coins',
        'color',
        'sorting',
        'status',
    ];

    /**
     * Get the category that owns the quiz level.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the full URL of the icon.
     */
    public function getIconUrlAttribute()
    {
        if ($this->icon) {
            return asset('storage/quiz-levels/' . $this->icon);
        }
        return null;
    }
}
