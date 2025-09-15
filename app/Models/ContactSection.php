<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'maps_embed_url',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Scope for active records
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the active Contact Section (single active record)
     */
    public static function getActive()
    {
        return static::where('is_active', true)->first() ?: static::getDefault();
    }

    /**
     * Get first or create default record
     */
    public static function getDefault()
    {
        return static::firstOrCreate(
            ['id' => 1],
            [
                'maps_embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d8093.253222490186!2d107.67920589074849!3d-6.915002802991967!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68dda5a21cc6bb%3A0xb7248e14780c4720!2sCV%20Lingkar%20Rasio%20Teknologi!5e0!3m2!1sid!2sid!4v1755229414217!5m2!1sid!2sid',
                'is_active' => true,
            ]
        );
    }

    /**
     * Get formatted created at
     */
    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at->format('d M Y H:i');
    }
}
