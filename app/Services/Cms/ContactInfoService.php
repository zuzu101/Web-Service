<?php

namespace App\Services\Cms;

use App\Models\ContactInfo;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ContactInfoService
{
    /**
     * Store a new contact info
     */
    public function store(array $data): ContactInfo
    {
        // Handle icon upload
        if (isset($data['icon']) && $data['icon'] instanceof UploadedFile) {
            $data['icon'] = $this->uploadIcon($data['icon']);
        }

        // Auto-generate order number (next highest order)
        $maxOrder = ContactInfo::max('order') ?? 0;
        $data['order'] = $maxOrder + 1;

        return ContactInfo::create($data);
    }

    /**
     * Update an existing contact info
     */
    public function update(ContactInfo $contactInfo, array $data): ContactInfo
    {
        // Handle icon upload
        if (isset($data['icon']) && $data['icon'] instanceof UploadedFile) {
            // Delete old icon if exists
            if ($contactInfo->icon) {
                Storage::disk('public')->delete($contactInfo->icon);
            }
            
            $data['icon'] = $this->uploadIcon($data['icon']);
        }

        // Don't update order field here, keep existing order
        $dataToUpdate = collect($data)->except('order')->toArray();
        $contactInfo->update($dataToUpdate);
        return $contactInfo->fresh();
    }

    /**
     * Delete a contact info
     */
    public function delete(ContactInfo $contactInfo): bool
    {
        // Delete icon file if exists
        if ($contactInfo->icon) {
            Storage::disk('public')->delete($contactInfo->icon);
        }

        return $contactInfo->delete();
    }

    /**
     * Upload icon image
     */
    private function uploadIcon(UploadedFile $file): string
    {
        // Create unique filename
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        
        // Store in contact-info folder
        return $file->storeAs('contact-info', $filename, 'public');
    }

    /**
     * Reorder contact info
     */
    public function reorder(array $orderData): bool
    {
        try {
            foreach ($orderData as $item) {
                ContactInfo::where('id', $item['id'])
                         ->update(['order' => $item['order']]);
            }
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}