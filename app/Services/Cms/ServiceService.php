<?php

namespace App\Services\Cms;

use App\Models\Cms\Service;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ServiceService
{
    /**
     * Store a new service
     */
    public function store(array $data): Service
    {
        // Handle image upload
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            $data['image'] = $this->uploadImage($data['image']);
        }

        // Set order number (next in sequence)
        $data['order_number'] = Service::max('order_number') + 1;

        return Service::create($data);
    }

    /**
     * Update an existing service
     */
    public function update(Service $service, array $data): Service
    {
        // Handle image upload
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            // Delete old image if exists
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }
            
            $data['image'] = $this->uploadImage($data['image']);
        }

        $service->update($data);
        return $service->fresh();
    }

    /**
     * Delete a service
     */
    public function delete(Service $service): bool
    {
        // Delete image file if exists
        if ($service->image) {
            Storage::disk('public')->delete($service->image);
        }

        return $service->delete();
    }

    /**
     * Upload service image
     */
    private function uploadImage(UploadedFile $file): string
    {
        // Create unique filename
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        
        // Store in services folder
        return $file->storeAs('services', $filename, 'public');
    }

    /**
     * Reorder services
     */
    public function reorder(array $orderData): bool
    {
        try {
            foreach ($orderData as $item) {
                Service::where('id', $item['id'])
                       ->update(['order_number' => $item['order_number']]);
            }
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}