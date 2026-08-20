<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $table = 'faqs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'question',
        'answer',
        'icon',
        'sorting',
        'status',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = ['icon_url'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => 'boolean',
        'sorting' => 'integer',
    ];

    /**
     * Get the full URL of the FAQ icon.
     */
    public function getIconUrlAttribute()
    {
        if ($this->icon && file_exists(public_path('storage/faqs/' . $this->icon))) {
            return asset('storage/faqs/' . $this->icon);
        }
        return asset('assets/images/profile.jpg'); // Fallback placeholder
    }
}
