<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Promo extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'discount_text',
        'features',
        'button_text',
        'whatsapp_template',
        'is_active'
    ];

    protected $casts = [
        'features' => 'array',
        'is_active' => 'boolean'
    ];

    /**
     * Scope to get only active promos
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get image URL attribute
     */
    public function getImageUrlAttribute()
    {
        if ($this->image && Storage::disk('public')->exists($this->image)) {
            return Storage::url($this->image);
        }
        return asset('images/diskon1.png'); // fallback image
    }

    /**
     * Get formatted created at attribute
     */
    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at->format('d/m/Y H:i');
    }

    /**
     * Get WhatsApp URL with encoded message
     */
    public function getWhatsappUrlAttribute()
    {
        $phoneNumber = '6287823330830'; // Phone number from config or settings
        $message = $this->whatsapp_template ?: "Halo, saya tertarik dengan promo {$this->title}. Mohon informasi lebih lanjut.";
        
        return "https://wa.me/{$phoneNumber}?text=" . urlencode($message);
    }

    /**
     * Get features as HTML list
     */
    public function getFeaturesListAttribute()
    {
        if (!$this->features || !is_array($this->features)) {
            return '';
        }

        $html = '<ul class="body-1-card color-navy mb-5">';
        foreach ($this->features as $feature) {
            $html .= '<li>' . htmlspecialchars($feature) . '</li>';
        }
        $html .= '</ul>';

        return $html;
    }
}