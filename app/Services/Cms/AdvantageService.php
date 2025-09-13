<?php

namespace App\Services\Cms;

use App\Models\Cms\Advantage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class AdvantageService
{
    /**
     * Store a new advantage
     */
    public function store(array $data): Advantage
    {
        // Handle icon upload
        if (isset($data['icon']) && $data['icon'] instanceof UploadedFile) {
            $data['icon'] = $this->uploadIcon($data['icon']);
        }

        // Set order number (next in sequence)
        $data['order_number'] = Advantage::max('order_number') + 1;

        return Advantage::create($data);
    }

    /**
     * Update an existing advantage
     */
    public function update(Advantage $advantage, array $data): Advantage
    {
        // Handle icon upload
        if (isset($data['icon']) && $data['icon'] instanceof UploadedFile) {
            // Delete old icon if exists
            if ($advantage->icon) {
                Storage::disk('public')->delete($advantage->icon);
            }
            
            $data['icon'] = $this->uploadIcon($data['icon']);
        }

        $advantage->update($data);
        return $advantage->fresh();
    }

    /**
     * Delete an advantage
     */
    public function delete(Advantage $advantage): bool
    {
        // Delete icon file if exists
        if ($advantage->icon) {
            Storage::disk('public')->delete($advantage->icon);
        }

        return $advantage->delete();
    }

    /**
     * Upload icon image
     */
    private function uploadIcon(UploadedFile $file): string
    {
        // Create unique filename
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        
        // Store in advantages folder
        return $file->storeAs('advantages', $filename, 'public');
    }

    /**
     * Reorder advantages
     */
    public function reorder(array $orderData): bool
    {
        try {
            foreach ($orderData as $item) {
                Advantage::where('id', $item['id'])
                         ->update(['order_number' => $item['order']]);
            }
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}