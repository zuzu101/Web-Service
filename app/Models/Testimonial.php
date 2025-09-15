<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'rating',
        'content',
        'is_active',
        'order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'rating' => 'integer'
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc')->orderBy('created_at', 'desc');
    }

    // Accessors
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return Storage::url($this->image);
        }
        return asset('images/default-avatar.png');
    }

    public function getStarsAttribute()
    {
        $stars = '';
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $this->rating) {
                $stars .= '<i class="fas fa-star me-1"></i>';
            } else {
                $stars .= '<i class="far fa-star me-1"></i>';
            }
        }
        return $stars;
    }

    public function getStarsTextAttribute()
    {
        return str_repeat('★', $this->rating) . str_repeat('☆', 5 - $this->rating);
    }

    // Mutators
    public function setImageAttribute($value)
    {
        if ($value && is_file($value)) {
            // Delete old image if exists
            if ($this->image && Storage::exists($this->image)) {
                Storage::delete($this->image);
            }
            
            $path = $value->store('testimonials', 'public');
            $this->attributes['image'] = $path;
        } elseif (is_string($value)) {
            $this->attributes['image'] = $value;
        }
    }

    // Methods
    public function deleteImage()
    {
        if ($this->image && Storage::exists($this->image)) {
            Storage::delete($this->image);
        }
    }

    // Boot method to handle model events
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($testimonial) {
            $testimonial->deleteImage();
        });
    }
}
