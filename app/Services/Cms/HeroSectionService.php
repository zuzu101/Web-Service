<?php

namespace App\Services\Cms;

use App\Helpers\ErrorHandling;
use App\Helpers\ImageHelpers;
use App\Http\Requests\Cms\HeroSectionRequest;
use App\Models\Cms\HeroSection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class HeroSectionService
{
    protected $imageHelper;

    public function __construct()
    {
        $this->imageHelper = new ImageHelpers('back_assets/img/CMS/HeroSection/');
    }

    public function store(HeroSectionRequest $request)
    {
        $request->validated();

        try {
            $data = $request->all();

            // Handle image1 upload
            if ($request->hasFile('image1')) {
                $file = $request->file('image1');
                $filename = 'hero_image_' . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('cms/hero', $filename, 'public');
                $data['image1'] = $path;
            }

            // Ensure is_active is set
            $data['is_active'] = $request->has('is_active') ? 1 : 0;

            HeroSection::create($data);

            return true;
        } catch (\Exception $e) {
            Log::error('HeroSection store error: ' . $e->getMessage());
            throw $e;
        } catch (\Error $e) {
            Log::error('HeroSection store error: ' . $e->getMessage());
            ErrorHandling::environmentErrorHandling($e->getMessage());
            throw $e;
        }
    }

    public function update(HeroSectionRequest $request, HeroSection $heroSection)
    {
        $request->validated();

        try {
            $data = $request->all();

            // Handle image1 upload
            if ($request->hasFile('image1')) {
                // Delete old image if exists
                if ($heroSection->image1 && Storage::disk('public')->exists($heroSection->image1)) {
                    Storage::disk('public')->delete($heroSection->image1);
                }

                $file = $request->file('image1');
                $filename = 'hero_image_' . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('cms/hero', $filename, 'public');
                $data['image1'] = $path;
            }

            // Ensure is_active is set
            $data['is_active'] = $request->has('is_active') ? 1 : 0;

            $heroSection->update($data);

            return true;
        } catch (\Exception $e) {
            Log::error('HeroSection update error: ' . $e->getMessage());
            throw $e;
        } catch (\Error $e) {
            ErrorHandling::environmentErrorHandling($e->getMessage());
            throw $e;
        }
    }

    public function destroy(HeroSection $heroSection)
    {
        try {
            // Delete associated images
            if ($heroSection->image1 && Storage::disk('public')->exists($heroSection->image1)) {
                Storage::disk('public')->delete($heroSection->image1);
            }

            $heroSection->delete();

            return true;
        } catch (\Exception $e) {
            Log::error('HeroSection destroy error: ' . $e->getMessage());
            throw $e;
        } catch (\Error $e) {
            ErrorHandling::environmentErrorHandling($e->getMessage());
            throw $e;
        }
    }

    public function data(object $heroSection, $request = null)
    {
        $query = $heroSection->orderBy('id', 'desc');

        // Apply status filter if provided
        if ($request && $request->has('status_filter') && $request->status_filter != '') {
            $query->where('is_active', $request->status_filter);
        }

        $array = $query->get(['id', 'title', 'title2', 'description', 'image1', 'is_active', 'created_at']);

        $data = [];
        $no = 0;

        foreach ($array as $item) {
            $no++;
            $nestedData['no'] = $no;
            $nestedData['title'] = $item->title;
            $nestedData['title2'] = $item->title2 ?? '-';
            $nestedData['description'] = Str::limit($item->description, 100);

            // Image column
            if ($item->image1) {
                $nestedData['image1'] = '<a href="' . Storage::url($item->image1) . '" target="_blank" class="btn btn-outline-info btn-sm">
                    <i class="fas fa-image mr-1"></i> Lihat
                </a>';
            } else {
                $nestedData['image1'] = '<span class="text-muted">-</span>';
            }

            // Status column with toggle
            $statusClass = $item->is_active ? 'badge bg-success' : 'badge bg-secondary';
            $statusText = $item->is_active ? 'Aktif' : 'Nonaktif';
            $nestedData['status'] = '<span class="' . $statusClass . '">' . $statusText . '</span>';

            $nestedData['created_at'] = $item->formatted_created_at;

            // Actions column
            $nestedData['actions'] = '
                <div class="btn-group-vertical">
                    <a href="' . route('admin.cms.hero.edit', $item->id) . '" class="btn btn-outline-info btn-sm d-inline-flex align-items-center mb-1">
                        <i class="fas fa-edit mr-1"></i> Edit
                    </a>
                    <a href="javascript:void(0)" onclick="toggleStatus(' . $item->id . ')" class="btn btn-outline-warning btn-sm d-inline-flex align-items-center mb-1">
                        <i class="fas fa-toggle-on mr-1"></i> Toggle
                    </a>
                    <a href="javascript:void(0)" onclick="deleteHeroSection(' . $item->id . ')" class="btn btn-outline-danger btn-sm d-inline-flex align-items-center">
                        <i class="fas fa-trash mr-1"></i> Hapus
                    </a>
                </div>
            ';

            $data[] = $nestedData;
        }

        return DataTables::of($data)->rawColumns(['image1', 'status', 'actions'])->toJson();
    }
}