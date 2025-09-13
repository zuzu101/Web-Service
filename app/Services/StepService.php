<?php

namespace App\Services;

use App\Models\Cms\Step;
use Illuminate\Support\Facades\Storage;

class StepService
{
    public function create(array $data)
    {
        // Handle file upload for icon if present
        if (isset($data['icon']) && is_file($data['icon'])) {
            $data['icon'] = $this->uploadIcon($data['icon']);
        }

        return Step::create($data);
    }

    public function update(Step $step, array $data)
    {
        // Handle file upload for icon if present
        if (isset($data['icon']) && is_file($data['icon'])) {
            // Delete old icon if exists
            if ($step->icon && file_exists(public_path('images/' . $step->icon))) {
                unlink(public_path('images/' . $step->icon));
            }
            
            $data['icon'] = $this->uploadIcon($data['icon']);
        }

        return $step->update($data);
    }

    public function delete(Step $step)
    {
        // Delete icon file if exists
        if ($step->icon && file_exists(public_path('images/' . $step->icon))) {
            unlink(public_path('images/' . $step->icon));
        }

        return $step->delete();
    }

    public function reorder(array $orderData)
    {
        try {
            foreach ($orderData as $item) {
                Step::where('id', $item['id'])
                    ->update(['order' => $item['order_number']]);
            }
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    private function uploadIcon($file)
    {
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('images'), $filename);
        return $filename;
    }
}