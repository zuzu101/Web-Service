<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HeroSection extends Model
{
    use HasFactory;

    protected $table = 'hero_sections';

    protected $fillable = [
        'title',
        'title2',
        'description',
        'image1',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    protected static function boot()
    {
        parent::boot();

        // When creating or updating a hero section
        static::saving(function ($heroSection) {
            // If this hero section is being set to active
            if ($heroSection->is_active) {
                // Deactivate all other hero sections
                static::where('id', '!=', $heroSection->id)
                      ->where('is_active', true)
                      ->update(['is_active' => false]);
            }
        });
    }

    // Scope for active hero sections
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Accessor for formatted creation date
    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at->format('d/m/Y H:i');
    }

    // Accessor for image1 URL
    public function getImage1UrlAttribute()
    {
        return $this->image1 ? asset('storage/' . $this->image1) : null;
    }
}
