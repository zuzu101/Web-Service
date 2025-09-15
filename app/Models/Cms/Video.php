<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'video_url',
        'video_id',
        'thumbnail_url',
        'is_active',
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
            
            // Extract video ID and generate thumbnail
            $model->processYouTubeUrl();
        });

        static::updating(function ($model) {
            if ($model->is_active && $model->isDirty('is_active') && !$model->activated_at) {
                $model->activated_at = now();
            }
            
            // Re-process YouTube URL if changed
            if ($model->isDirty('video_url')) {
                $model->processYouTubeUrl();
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
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

    public function getEmbedUrlAttribute()
    {
        if ($this->video_id) {
            return "https://www.youtube.com/embed/{$this->video_id}";
        }
        
        return $this->convertToEmbedUrl($this->video_url);
    }

    public function getThumbnailAttribute()
    {
        if ($this->thumbnail_url) {
            return $this->thumbnail_url;
        }
        
        if ($this->video_id) {
            return "https://img.youtube.com/vi/{$this->video_id}/maxresdefault.jpg";
        }
        
        return null;
    }

    private function processYouTubeUrl()
    {
        if ($this->video_url) {
            $this->video_id = $this->extractYouTubeId($this->video_url);
            
            if ($this->video_id && !$this->thumbnail_url) {
                $this->thumbnail_url = "https://img.youtube.com/vi/{$this->video_id}/maxresdefault.jpg";
            }
        }
    }

    private function extractYouTubeId($url)
    {
        $patterns = [
            '/youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/',
            '/youtube\.com\/embed\/([a-zA-Z0-9_-]+)/',
            '/youtu\.be\/([a-zA-Z0-9_-]+)/',
        ];
        
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                return $matches[1];
            }
        }
        
        return null;
    }

    private function convertToEmbedUrl($url)
    {
        $videoId = $this->extractYouTubeId($url);
        
        if ($videoId) {
            return "https://www.youtube.com/embed/{$videoId}";
        }
        
        return $url;
    }
}
