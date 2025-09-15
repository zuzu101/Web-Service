<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PromoSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'background_image',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    /**
     * Scope to get only active section
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get background image URL attribute
     */
    public function getBackgroundImageUrlAttribute()
    {
        if ($this->background_image && Storage::disk('public')->exists($this->background_image)) {
            return Storage::url($this->background_image);
        }
        return null;
    }

    /**
     * Get formatted created at attribute
     */
    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at->format('d/m/Y H:i');
    }
}