<?php

namespace App\Http\Controllers\Back\Cms;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Exception;

class TestimonialController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $testimonials = Testimonial::select(['id', 'name', 'image', 'rating', 'is_active', 'order']);

            return DataTables::of($testimonials)
                ->addIndexColumn()
                ->addColumn('image_display', function ($testimonial) {
                    if ($testimonial->image) {
                        return '<img src="' . $testimonial->image_url . '" alt="' . $testimonial->name . '" class="img-thumbnail" style="max-width: 80px; max-height: 60px;">';
                    }
                    return '<span class="text-muted">Tidak ada gambar</span>';
                })
                ->addColumn('stars', function ($testimonial) {
                    return $testimonial->stars;
                })
                ->addColumn('status', function ($testimonial) {
                    $badgeClass = $testimonial->is_active ? 'badge-success' : 'badge-secondary';
                    $badgeText = $testimonial->is_active ? 'Aktif' : 'Nonaktif';
                    
                    return '<span class="badge ' . $badgeClass . '">' . $badgeText . '</span>';
                })
                ->addColumn('action', function ($testimonial) {
                    $editBtn = '<a href="' . route('admin.cms.testimonial.edit', $testimonial->id) . '" class="btn btn-outline-info btn-sm d-inline-flex align-items-center mb-1">
                        <i class="fas fa-edit mr-1"></i> Edit
                    </a>';
                    
                    $toggleBtn = '<a href="javascript:void(0)" onclick="toggleStatus(' . $testimonial->id . ')" class="btn btn-outline-warning btn-sm d-inline-flex align-items-center mb-1">
                        <i class="fas fa-toggle-on mr-1"></i> Toggle
                    </a>';
                    
                    $deleteBtn = '<a href="javascript:void(0)" onclick="deleteTestimonial(' . $testimonial->id . ')" class="btn btn-outline-danger btn-sm d-inline-flex align-items-center">
                        <i class="fas fa-trash mr-1"></i> Hapus
                    </a>';
                    
                    return '<div class="btn-group-vertical">' . $editBtn . $toggleBtn . $deleteBtn . '</div>';
                })
                ->rawColumns(['image_display', 'stars', 'status', 'action'])
                ->make(true);
        }

        return view('back.cms.testimonial.index');
    }

    public function create()
    {
        return view('back.cms.testimonial.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');
        
        // Auto-increment order: get max order and add 1
        $data['order'] = (Testimonial::max('order') ?? 0) + 1;

        Testimonial::create($data);

        return redirect()->route('admin.cms.testimonial.index')
            ->with('success', 'Testimoni berhasil ditambahkan!');
    }

    public function edit(Testimonial $testimonial)
    {
        return view('back.cms.testimonial.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');
        
        // Keep existing order when updating, don't change it
        unset($data['order']);

        $testimonial->update($data);

        return redirect()->route('admin.cms.testimonial.index')
            ->with('success', 'Testimoni berhasil diupdate!');
    }

    public function destroy(Testimonial $testimonial)
    {
        try {
            $testimonial->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Testimoni berhasil dihapus!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus testimoni: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Toggle testimonial status (active/inactive)
     */
    public function toggleStatus(Testimonial $testimonial): JsonResponse
    {
        try {
            $testimonial->update([
                'is_active' => !$testimonial->is_active
            ]);
            
            $statusText = $testimonial->is_active ? 'Aktif' : 'Nonaktif';
            
            return response()->json([
                'success' => true,
                'message' => 'Status testimoni berhasil diubah menjadi ' . $statusText . '!'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah status: ' . $e->getMessage()
            ]);
        }
    }

    public function reorderPage()
    {
        $testimonials = Testimonial::ordered()->get();
        return view('back.cms.testimonial.reorder', compact('testimonials'));
    }

    public function updateOrder(Request $request)
    {
        try {
            $order = $request->get('order', []);
            
            foreach ($order as $index => $id) {
                Testimonial::where('id', $id)->update(['order' => $index + 1]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Urutan testimoni berhasil diupdate!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate urutan: ' . $e->getMessage()
            ], 500);
        }
    }
}