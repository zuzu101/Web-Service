<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StepSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'background_image',
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Always ensure only one active step section exists
            static::query()->delete(); // Delete all existing records
            $model->is_active = true; // Force new record to be active
        });

        static::updating(function ($model) {
            // Delete all other records when updating
            static::where('id', '!=', $model->id)->delete();
            $model->is_active = true; // Force updated record to be active
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    public function getBackgroundImageUrlAttribute()
    {
        return $this->background_image ? asset('images/' . $this->background_image) : null;
    }

    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at->format('d M Y H:i');
    }

    public function getFormattedUpdatedAtAttribute()
    {
        return $this->updated_at->format('d M Y H:i');
    }
}