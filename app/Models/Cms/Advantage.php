<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Advantage extends Model
{
    use HasFactory;

    protected $table = 'advantages';

    protected $fillable = [
        'title',
        'description',
        'icon',
        'order_number',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order_number' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Scope for active advantages
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope for ordered advantages
    public function scopeOrdered($query)
    {
        return $query->orderBy('order_number', 'asc')->orderBy('id', 'asc');
    }

    // Accessor for formatted creation date
    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at->format('d/m/Y H:i');
    }

    // Accessor for icon URL
    public function getIconUrlAttribute()
    {
        return $this->icon ? asset('storage/' . $this->icon) : null;
    }
}
