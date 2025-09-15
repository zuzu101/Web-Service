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
            return $video->delete();
        } catch (Exception $e) {
            throw new Exception('Failed to delete video: ' . $e->getMessage());
        }
    }
}