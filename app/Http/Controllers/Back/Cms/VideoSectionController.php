<?php

namespace App\Http\Controllers\Back\Cms;

use App\Http\Controllers\Controller;
use App\Models\Cms\VideoSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class VideoSectionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = VideoSection::latest();

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    $badgeClass = $row->is_active ? 'bg-success' : 'bg-secondary';
                    $statusText = $row->is_active ? 'Aktif' : 'Tidak Aktif';
                    return '<span class="badge ' . $badgeClass . '">' . $statusText . '</span>';
                })
                ->addColumn('background_preview', function ($row) {
                    if ($row->background_image_url) {
                        return '<img src="' . $row->background_image_url . '" class="img-thumbnail" style="max-width: 100px; max-height: 60px;">';
                    }
                    return '<span class="text-muted">No Image</span>';
                })
                ->addColumn('action', function ($row) {
                    return '
                        <div class="btn-group" role="group">
                            <a href="' . route('admin.cms.video-section.edit', $row->id) . '" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <button type="button" class="btn btn-sm ' . ($row->is_active ? 'btn-secondary' : 'btn-success') . '" 
                                    onclick="toggleStatus(' . $row->id . ')">
                                <i class="fas fa-toggle-' . ($row->is_active ? 'on' : 'off') . '"></i> 
                                ' . ($row->is_active ? 'Nonaktifkan' : 'Aktifkan') . '
                            </button>
                            <button type="button" class="btn btn-sm btn-danger" onclick="deleteVideoSection(' . $row->id . ')">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </div>
                    ';
                })
                ->rawColumns(['status', 'background_preview', 'action'])
                ->make(true);
        }

        return view('back.cms.video-section.index');
    }

    public function create()
    {
        return view('back.cms.video-section.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string',
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        try {
            $data = $request->only(['title', 'subtitle', 'is_active']);
            $data['is_active'] = $request->has('is_active');

            // Handle background image upload
            if ($request->hasFile('background_image')) {
                $file = $request->file('background_image');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('video-sections', $filename, 'public');
                $data['background_image'] = $path;
            }

            VideoSection::create($data);

            return redirect()->route('admin.cms.video-section.index')
                ->with('success', 'Video Section berhasil ditambahkan!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan Video Section: ' . $e->getMessage());
        }
    }

    public function edit(VideoSection $videoSection)
    {
        return view('back.cms.video-section.edit', compact('videoSection'));
    }

    public function update(Request $request, VideoSection $videoSection)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string',
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        try {
            $data = $request->only(['title', 'subtitle', 'is_active']);
            $data['is_active'] = $request->has('is_active');

            // Handle background image upload
            if ($request->hasFile('background_image')) {
                // Delete old image if exists
                if ($videoSection->background_image && Storage::disk('public')->exists($videoSection->background_image)) {
                    Storage::disk('public')->delete($videoSection->background_image);
                }

                $file = $request->file('background_image');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('video-sections', $filename, 'public');
                $data['background_image'] = $path;
            }

            $videoSection->update($data);

            return redirect()->route('admin.cms.video-section.index')
                ->with('success', 'Video Section berhasil diperbarui!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui Video Section: ' . $e->getMessage());
        }
    }

    public function destroy(VideoSection $videoSection)
    {
        try {
            // Delete associated image
            if ($videoSection->background_image && Storage::disk('public')->exists($videoSection->background_image)) {
                Storage::disk('public')->delete($videoSection->background_image);
            }

            $videoSection->delete();

            return response()->json([
                'success' => true,
                'message' => 'Video Section berhasil dihapus!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus Video Section: ' . $e->getMessage()
            ], 500);
        }
    }

    public function toggleStatus(VideoSection $videoSection)
    {
        try {
            $videoSection->update([
                'is_active' => !$videoSection->is_active
            ]);

            $status = $videoSection->is_active ? 'diaktifkan' : 'dinonaktifkan';

            return response()->json([
                'success' => true,
                'message' => "Video Section berhasil {$status}!",
                'is_active' => $videoSection->is_active
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah status Video Section: ' . $e->getMessage()
            ], 500);
        }
    }
}