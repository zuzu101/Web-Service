<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdvantageSection extends Model
{
    use HasFactory;

    protected $table = 'advantage_sections';

    protected $fillable = [
        'title',
        'background_image',
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

        // When creating or updating an advantage section
        static::saving(function ($advantageSection) {
            // If this advantage section is being set to active
            if ($advantageSection->is_active) {
                // Deactivate all other advantage sections (hanya boleh 1 aktif)
                static::where('id', '!=', $advantageSection->id)
                      ->where('is_active', true)
                      ->update(['is_active' => false]);
            }
        });
    }

    // Scope for active advantage section
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Accessor for formatted creation date
    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at->format('d/m/Y H:i');
    }

    // Accessor for background image URL
    public function getBackgroundImageUrlAttribute()
    {
        return $this->background_image ? asset('storage/' . $this->background_image) : null;
    }
}
