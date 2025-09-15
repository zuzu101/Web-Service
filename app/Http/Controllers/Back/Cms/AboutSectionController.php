<?php

namespace App\Http\Controllers\Back\Cms;

use App\Http\Controllers\Controller;
use App\Models\AboutSection;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Exception;

class AboutSectionController extends Controller
{
    /**
     * Display a listing with DataTable
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $aboutSections = AboutSection::select(['id', 'title', 'image', 'is_active', 'created_at']);

            return DataTables::of($aboutSections)
                ->addIndexColumn()
                ->addColumn('image_display', function ($aboutSection) {
                    if ($aboutSection->image) {
                        return '<img src="' . $aboutSection->image_url . '" alt="' . $aboutSection->title . '" class="img-thumbnail" style="max-width: 80px; max-height: 60px;">';
                    }
                    return '<img src="' . asset('images/aboutUS.png') . '" alt="Default" class="img-thumbnail" style="max-width: 80px; max-height: 60px;">';
                })
                ->addColumn('status', function ($aboutSection) {
                    $badgeClass = $aboutSection->is_active ? 'badge-success' : 'badge-secondary';
                    $badgeText = $aboutSection->is_active ? 'Aktif' : 'Nonaktif';
                    
                    return '<span class="badge ' . $badgeClass . '">' . $badgeText . '</span>';
                })
                ->addColumn('action', function ($aboutSection) {
                    $editBtn = '<a href="' . route('admin.cms.about-section.edit', $aboutSection->id) . '" class="btn btn-outline-info btn-sm d-inline-flex align-items-center mb-1">
                        <i class="fas fa-edit mr-1"></i> Edit
                    </a>';
                    
                    $toggleBtn = '<a href="javascript:void(0)" onclick="toggleStatus(' . $aboutSection->id . ')" class="btn btn-outline-warning btn-sm d-inline-flex align-items-center mb-1">
                        <i class="fas fa-toggle-on mr-1"></i> Toggle
                    </a>';
                    
                    $deleteBtn = '<a href="javascript:void(0)" onclick="deleteAboutSection(' . $aboutSection->id . ')" class="btn btn-outline-danger btn-sm d-inline-flex align-items-center">
                        <i class="fas fa-trash mr-1"></i> Hapus
                    </a>';
                    
                    return '<div class="btn-group-vertical">' . $editBtn . $toggleBtn . $deleteBtn . '</div>';
                })
                ->rawColumns(['image_display', 'status', 'action'])
                ->make(true);
        }

        return view('back.cms.about-section.index');
    }

    /**
     * Show the form for creating a new resource
     */
    public function create()
    {
        return view('back.cms.about-section.create');
    }

    /**
     * Store a newly created resource
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'content' => 'required|string',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        $aboutSection = AboutSection::create($data);

        // If this section is set to active, activate it (deactivates others)
        if ($data['is_active']) {
            $aboutSection->activate();
        }

        return redirect()->route('admin.cms.about-section.index')
            ->with('success', 'Section Tentang Kami berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource
     */
    public function edit(AboutSection $aboutSection)
    {
        return view('back.cms.about-section.edit', compact('aboutSection'));
    }

    /**
     * Update the specified resource
     */
    public function update(Request $request, AboutSection $aboutSection)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'content' => 'required|string',
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
        if ($request->hasFile('image')) {
            $aboutSection->uploadImage($request->file('image'));
            unset($data['image']);
        } else {
            unset($data['image']);
        }

        $aboutSection->update($data);

        // If this section is set to active, activate it (deactivates others)
        if ($data['is_active']) {
            $aboutSection->activate();
        }

        return redirect()->route('admin.cms.about-section.index')
            ->with('success', 'Section Tentang Kami berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage
     */
    public function destroy(AboutSection $aboutSection)
    {
        try {
            $aboutSection->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Section berhasil dihapus!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus section: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Toggle About section status (single active logic)
     */
    public function toggleStatus(AboutSection $aboutSection): JsonResponse
    {
        try {
            // If trying to activate an inactive section, activate it (deactivates others)
            if (!$aboutSection->is_active) {
                $aboutSection->activate();
                $message = 'Section Tentang Kami berhasil diaktifkan!';
            } else {
                // If trying to deactivate the active section, just keep it active
                // In single active system, at least one should be active
                $message = 'Section Tentang Kami sudah aktif!';
            }
            
            return response()->json([
                'success' => true,
                'message' => $message
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah status: ' . $e->getMessage()
            ]);
        }
    }
}
