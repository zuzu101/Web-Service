<?php

namespace App\Http\Controllers\Back\Cms;

use App\Http\Controllers\Controller;
use App\Models\Cms\Promo;
use App\Models\Cms\PromoSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class PromoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $promos = Promo::latest()->get();

            return DataTables::of($promos)
                ->addIndexColumn()
                ->addColumn('image_preview', function ($promo) {
                    if ($promo->image) {
                        return '<img src="' . $promo->image_url . '" class="img-thumbnail" style="max-width: 80px; max-height: 60px;">';
                    }
                    return '<span class="text-muted">No Image</span>';
                })
                ->addColumn('discount_display', function ($promo) {
                    return $promo->discount_text ?: '-';
                })
                ->addColumn('features_preview', function ($promo) {
                    if ($promo->features && is_array($promo->features)) {
                        $preview = implode(', ', array_slice($promo->features, 0, 2));
                        $count = count($promo->features);
                        return $count > 2 ? $preview . '... (+' . ($count - 2) . ' more)' : $preview;
                    }
                    return '-';
                })
                ->addColumn('status_badge', function ($promo) {
                    $statusClass = $promo->is_active ? 'bg-success' : 'bg-secondary';
                    $statusText = $promo->is_active ? 'Aktif' : 'Nonaktif';
                    return '<span class="badge ' . $statusClass . '">' . $statusText . '</span>';
                })
                ->addColumn('action', function ($promo) {
                    $editBtn = '<a href="' . route('admin.cms.promo.edit', $promo->id) . '" class="btn btn-outline-info btn-sm d-inline-flex align-items-center mb-1">
                        <i class="fas fa-edit mr-1"></i> Edit
                    </a>';
                    
                    $toggleBtn = '<a href="javascript:void(0)" onclick="toggleStatus(' . $promo->id . ')" class="btn btn-outline-warning btn-sm d-inline-flex align-items-center mb-1">
                        <i class="fas fa-toggle-on mr-1"></i> Toggle
                    </a>';
                    
                    $deleteBtn = '<a href="javascript:void(0)" onclick="deletePromo(' . $promo->id . ')" class="btn btn-outline-danger btn-sm d-inline-flex align-items-center">
                        <i class="fas fa-trash mr-1"></i> Hapus
                    </a>';
                    
                    return '<div class="btn-group-vertical">' . $editBtn . $toggleBtn . $deleteBtn . '</div>';
                })
                ->rawColumns(['image_preview', 'status_badge', 'action'])
                ->make(true);
        }

        return view('back.cms.promo.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('back.cms.promo.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'discount_text' => 'nullable|string|max:255',
            'features' => 'nullable|array',
            'features.*' => 'string',
            'button_text' => 'required|string|max:255',
            'whatsapp_template' => 'nullable|string'
        ]);

        try {
            $data = $request->all();

            // Handle image upload
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = 'promo_' . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('cms/promo', $filename, 'public');
                $data['image'] = $path;
            }

            // Handle features array
            if ($request->has('features')) {
                $data['features'] = array_filter($request->features); // Remove empty features
            }

            $data['is_active'] = $request->has('is_active');

            Promo::create($data);

            return redirect()->route('admin.cms.promo.index')
                           ->with('success', 'Promo berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Gagal menambahkan promo: ' . $e->getMessage())
                           ->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Promo $promo)
    {
        return view('back.cms.promo.edit', compact('promo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Promo $promo)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'discount_text' => 'nullable|string|max:255',
            'features' => 'nullable|array',
            'features.*' => 'string',
            'button_text' => 'required|string|max:255',
            'whatsapp_template' => 'nullable|string'
        ]);

        try {
            $data = $request->all();

            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($promo->image && Storage::disk('public')->exists($promo->image)) {
                    Storage::disk('public')->delete($promo->image);
                }

                $file = $request->file('image');
                $filename = 'promo_' . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('cms/promo', $filename, 'public');
                $data['image'] = $path;
            }

            // Handle features array
            if ($request->has('features')) {
                $data['features'] = array_filter($request->features);
            }

            $data['is_active'] = $request->has('is_active');

            $promo->update($data);

            return redirect()->route('admin.cms.promo.index')
                           ->with('success', 'Promo berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Gagal memperbarui promo: ' . $e->getMessage())
                           ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Promo $promo)
    {
        try {
            // Delete image if exists
            if ($promo->image && Storage::disk('public')->exists($promo->image)) {
                Storage::disk('public')->delete($promo->image);
            }

            $promo->delete();

            return response()->json([
                'success' => true,
                'message' => 'Promo berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus promo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Toggle status of promo
     */
    public function toggleStatus(Promo $promo)
    {
        try {
            $promo->update(['is_active' => !$promo->is_active]);

            return response()->json([
                'success' => true,
                'message' => 'Status promo berhasil diubah.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah status promo.'
            ], 500);
        }
    }

    /**
     * Get section title
     */
    public function getSectionTitle()
    {
        $section = PromoSection::active()->first();
        
        return response()->json([
            'success' => true,
            'data' => [
                'title' => $section ? $section->title : '',
                'subtitle' => $section ? $section->subtitle : ''
            ]
        ]);
    }

    /**
     * Update section title
     */
    public function updateSectionTitle(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string'
        ]);

        try {
            $section = PromoSection::active()->first();
            
            if ($section) {
                $section->update([
                    'title' => $request->title,
                    'subtitle' => $request->subtitle
                ]);
            } else {
                PromoSection::create([
                    'title' => $request->title,
                    'subtitle' => $request->subtitle,
                    'is_active' => true
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Judul dan subtitle section berhasil diperbarui!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui section: ' . $e->getMessage()
            ], 500);
        }
    }
}