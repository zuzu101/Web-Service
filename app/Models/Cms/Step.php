<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Step extends Model
{
    use HasFactory;

    protected $fillable = [
        'icon',
        'title',
        'description',
        'is_active',
        'order',
        'activated_at',
    ];

    protected $casts = [
        'activated_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if ($model->is_active && !$model->activated_at) {
                $model->activated_at = now();
            }
        });

        static::updating(function ($model) {
            if ($model->is_active && $model->isDirty('is_active') && !$model->activated_at) {
                $model->activated_at = now();
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at->format('d M Y H:i');
    }

    public function getFormattedUpdatedAtAttribute()
    {
        return $this->updated_at->format('d M Y H:i');
    }

    public function getFormattedActivatedAtAttribute()
    {
        return $this->activated_at ? $this->activated_at->format('d M Y H:i') : null;
    }

    public function getIconUrlAttribute()
    {
        return $this->icon ? asset('images/' . $this->icon) : null;
    }
}