<?php

namespace App\Http\Controllers\Back\Cms;

use App\Http\Controllers\Controller;
use App\Models\CtaSection;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Exception;

class CtaSectionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $ctaSections = CtaSection::select(['id', 'title', 'background_image', 'is_active', 'created_at']);

            return DataTables::of($ctaSections)
                ->addIndexColumn()
                ->addColumn('background_display', function ($ctaSection) {
                    return '<img src="' . $ctaSection->background_image_url . '" alt="' . $ctaSection->title . '" class="img-thumbnail" style="max-width: 100px; max-height: 60px;">';
                })
                ->addColumn('status', function ($ctaSection) {
                    $badgeClass = $ctaSection->is_active ? 'badge-success' : 'badge-secondary';
                    $badgeText = $ctaSection->is_active ? 'Aktif' : 'Nonaktif';
                    
                    return '<span class="badge ' . $badgeClass . '">' . $badgeText . '</span>';
                })
                ->addColumn('action', function ($ctaSection) {
                    $editBtn = '<a href="' . route('admin.cms.cta-section.edit', $ctaSection->id) . '" class="btn btn-outline-info btn-sm d-inline-flex align-items-center mb-1">
                            <i class="fas fa-edit mr-1"></i> Edit
                        </a>';
                    
                    // Toggle button
                    $toggleBtn = '<a href="javascript:void(0)" onclick="toggleCtaSection(' . $ctaSection->id . ')" class="btn btn-outline-warning btn-sm d-inline-flex align-items-center mb-1">
                            <i class="fas fa-toggle-on mr-1"></i> Toggle
                        </a>';
                    
                    $deleteBtn = '<a href="javascript:void(0)" onclick="deleteCtaSection(' . $ctaSection->id . ')" class="btn btn-outline-danger btn-sm d-inline-flex align-items-center">
                            <i class="fas fa-trash mr-1"></i> Hapus
                        </a>';
                        
                    return '<div class="btn-group-vertical">' . $editBtn . $toggleBtn . $deleteBtn . '</div>';
                })
                ->rawColumns(['background_display', 'status', 'action'])
                ->make(true);
        }

        return view('back.cms.cta-section.index');
    }

    public function create()
    {
        return view('back.cms.cta-section.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        // Handle image upload
        if ($request->hasFile('background_image')) {
            $file = $request->file('background_image');
            $path = $file->store('cta-backgrounds', 'public');
            $data['background_image'] = $path;
        }

        $ctaSection = CtaSection::create($data);

        // If this CTA section is set to active, deactivate others
        if ($data['is_active']) {
            $ctaSection->activate();
        }

        return redirect()->route('admin.cms.cta-section.index')
            ->with('success', 'CTA Section berhasil ditambahkan!');
    }

    public function edit(CtaSection $ctaSection)
    {
        return view('back.cms.cta-section.edit', compact('ctaSection'));
    }

    public function update(Request $request, CtaSection $ctaSection)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');
        
        // Remove background_image from data to handle separately
        unset($data['background_image']);

        // Handle image upload
        if ($request->hasFile('background_image')) {
            $file = $request->file('background_image');
            $ctaSection->uploadBackgroundImage($file);
        }

        $ctaSection->update($data);

        // If this CTA section is set to active, deactivate others
        if ($data['is_active']) {
            $ctaSection->activate();
        }

        return redirect()->route('admin.cms.cta-section.index')
            ->with('success', 'CTA Section berhasil diupdate!');
    }

    public function destroy($id)
    {
        try {
            $ctaSection = CtaSection::findOrFail($id);
            $ctaSection->deleteBackgroundImage();
            $ctaSection->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'CTA Section berhasil dihapus!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus CTA Section: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Toggle CTA section status (single active logic)
     */
    public function toggle($id): JsonResponse
    {
        try {
            $ctaSection = CtaSection::findOrFail($id);
            
            // If trying to activate an inactive section, activate it (deactivates others)
            if (!$ctaSection->is_active) {
                $ctaSection->activate();
                $message = 'CTA Section berhasil diaktifkan!';
            } else {
                // If trying to deactivate the active section, just keep it active
                // In single active system, at least one should be active
                $message = 'CTA Section sudah aktif!';
            }
            
            return response()->json([
                'success' => true,
                'message' => $message
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah status CTA Section: ' . $e->getMessage()
            ]);
        }
    }
}
