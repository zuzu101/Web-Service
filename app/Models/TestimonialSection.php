<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class TestimonialSection extends Model
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

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Accessors
    public function getBackgroundImageUrlAttribute()
    {
        if ($this->background_image) {
            return Storage::url($this->background_image);
        }
        return asset('images/BGtesti.png'); // fallback to default
    }

    // Mutators
    public function setBackgroundImageAttribute($value)
    {
        if ($value && is_file($value)) {
            // Delete old image if exists
            if ($this->background_image && Storage::exists($this->background_image)) {
                Storage::delete($this->background_image);
            }
            
            $path = $value->store('testimonial-sections', 'public');
            $this->attributes['background_image'] = $path;
        } elseif (is_string($value)) {
            $this->attributes['background_image'] = $value;
        }
    }

    // Methods
    public function deleteBackgroundImage()
    {
        if ($this->background_image && Storage::exists($this->background_image)) {
            Storage::delete($this->background_image);
        }
    }

    // Boot method to handle model events
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($section) {
            $section->deleteBackgroundImage();
        });
    }
}
