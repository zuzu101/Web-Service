<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class CtaSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'background_image',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the background image URL
     */
    public function getBackgroundImageUrlAttribute(): string
    {
        if ($this->background_image && Storage::disk('public')->exists($this->background_image)) {
            return asset('storage/' . $this->background_image);
        }
        
        return asset('images/BGalur.png'); // Default background image
    }

    /**
     * Upload and store background image
     */
    public function uploadBackgroundImage(UploadedFile $file): string
    {
        // Delete old image if exists
        if ($this->background_image && Storage::disk('public')->exists($this->background_image)) {
            Storage::disk('public')->delete($this->background_image);
        }

        // Store new image
        $path = $file->store('cta-backgrounds', 'public');
        
        // Update the model
        $this->update(['background_image' => $path]);
        
        return $path;
    }

    /**
     * Delete background image
     */
    public function deleteBackgroundImage(): bool
    {
        if ($this->background_image && Storage::disk('public')->exists($this->background_image)) {
            Storage::disk('public')->delete($this->background_image);
            $this->update(['background_image' => null]);
            return true;
        }
        
        return false;
    }

    /**
     * Scope for active records
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the single active CTA section (same pattern as Hero section)
     */
    public static function getActive()
    {
        return static::where('is_active', true)->first();
    }

    /**
     * Activate this CTA section and deactivate others (like Hero section)
     */
    public function activate()
    {
        // Deactivate all other CTA sections
        static::where('id', '!=', $this->id)->update(['is_active' => false]);
        
        // Activate this one
        $this->update(['is_active' => true]);
        
        return $this;
    }

    /**
     * Boot method to handle model events
     */
    protected static function boot()
    {
        parent::boot();

        // Delete associated image when model is deleted
        static::deleting(function ($ctaSection) {
            if ($ctaSection->background_image && Storage::disk('public')->exists($ctaSection->background_image)) {
                Storage::disk('public')->delete($ctaSection->background_image);
            }
        });
    }
}
