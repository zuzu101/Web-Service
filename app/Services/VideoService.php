<?php

namespace App\Services;

use App\Models\Cms\Video;
use Exception;

class VideoService
{
    public function create(array $data)
    {
        try {
            return Video::create($data);
        } catch (Exception $e) {
            throw new Exception('Failed to create video: ' . $e->getMessage());
        }
    }

    public function update(Video $video, array $data)
    {
        try {
            $video->update($data);
            return $video;
        } catch (Exception $e) {
            throw new Exception('Failed to update video: ' . $e->getMessage());
        }
    }

    public function delete(Video $video)
    {
        try {
            // Delete thumbnail file if it is a local file (not a YouTube URL)
            if ($video->thumbnail_url && !preg_match('/^https?:\/\//', $video->thumbnail_url)) {
                $thumbnailPath = public_path($video->thumbnail_url);
                if (file_exists($thumbnailPath)) {
                    @unlink($thumbnailPath);
                }
            }
            return $video->delete();
        } catch (Exception $e) {
            throw new Exception('Failed to delete video: ' . $e->getMessage());
        }
    }
}