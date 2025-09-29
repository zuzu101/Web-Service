<?php

namespace App\Http\Controllers\Back\Cms;

use App\Http\Controllers\Controller;
use App\Http\Requests\VideoRequest;
use App\Models\Cms\Video;
use App\Models\Cms\VideoSection;
use App\Services\VideoService;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class VideoController extends Controller
{
    protected $videoService;

    public function __construct(VideoService $videoService)
    {
        $this->videoService = $videoService;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Video::select(['id', 'title', 'description', 'video_url', 'video_id', 'is_active', 'created_at'])->latest();
            
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('video_preview', function ($video) {
                    if ($video->video_id) {
                        return '<img src="' . $video->thumbnail . '" alt="Video Thumbnail" class="img-thumbnail" style="width: 80px; height: 60px; object-fit: cover;">';
                    }
                    return '<span class="text-muted">No preview</span>';
                })
                ->editColumn('description', function ($video) {
                    return strlen($video->description) > 100 ? 
                        substr($video->description, 0, 100) . '...' : 
                        $video->description;
                })
                ->addColumn('status_badge', function ($video) {
                    $badgeClass = $video->is_active ? 'badge-success' : 'badge-secondary';
                    $badgeText = $video->is_active ? 'Aktif' : 'Nonaktif';
                    
                    return '<span class="badge ' . $badgeClass . '">' . $badgeText . '</span>';
                })
                ->addColumn('action', function ($video) {
                    $editBtn = '<a href="' . route('admin.cms.video.edit', $video->id) . '" class="btn btn-outline-info btn-sm d-inline-flex align-items-center mb-1">
                        <i class="fas fa-edit mr-1"></i> Edit
                    </a>';
                    
                    $toggleBtn = '<a href="javascript:void(0)" onclick="toggleStatus(' . $video->id . ')" class="btn btn-outline-warning btn-sm d-inline-flex align-items-center mb-1">
                        <i class="fas fa-toggle-on mr-1"></i> Toggle
                    </a>';
                    
                    $deleteBtn = '<a href="javascript:void(0)" onclick="deleteVideo(' . $video->id . ')" class="btn btn-outline-danger btn-sm d-inline-flex align-items-center">
                        <i class="fas fa-trash mr-1"></i> Hapus
                    </a>';
                    
                    return '<div class="btn-group-vertical">' . $editBtn . $toggleBtn . $deleteBtn . '</div>';
                })
                ->rawColumns(['video_preview', 'status_badge', 'action'])
                ->make(true);
        }

        return view('back.cms.video.index');
    }

    public function create()
    {
        return view('back.cms.video.create');
    }

    public function store(VideoRequest $request)
    {
        $this->videoService->create($request->validated());

        return redirect()->route('admin.cms.video.index')
            ->with('success', 'Video berhasil ditambahkan.');
    }

    public function edit(Video $video)
    {
        return view('back.cms.video.edit', compact('video'));
    }

    public function update(VideoRequest $request, Video $video)
    {
        $this->videoService->update($video, $request->validated());

        return redirect()->route('admin.cms.video.index')
            ->with('success', 'Video berhasil diperbarui.');
    }

    public function destroy(Video $video)
    {
        try {
            $this->videoService->delete($video);
            return response()->json([
                'success' => true,
                'message' => 'Video berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus video: ' . $e->getMessage()
            ], 500);
        }
    }

    public function toggleStatus(Request $request, Video $video)
    {
        $newStatus = !$video->is_active;
        $video->update(['is_active' => $newStatus]);

        $statusText = $newStatus ? 'Aktif' : 'Nonaktif';

        return response()->json([
            'success' => true,
            'status' => $newStatus,
            'status_text' => $statusText,
            'message' => "Status berhasil diubah menjadi {$statusText}"
        ]);
    }

    // Video Section Methods
    public function getSectionTitle()
    {
        $section = VideoSection::active()->first();
        
        return response()->json([
            'success' => true,
            'data' => [
                'title' => $section ? $section->title : '',
                'subtitle' => $section ? $section->subtitle : ''
            ]
        ]);
    }

    public function updateSectionTitle(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string'
        ]);

        try {
            $section = VideoSection::active()->first();
            
            if ($section) {
                $section->update([
                    'title' => $request->title,
                    'subtitle' => $request->subtitle
                ]);
            } else {
                VideoSection::create([
                    'title' => $request->title,
                    'subtitle' => $request->subtitle,
                    'is_active' => true
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Judul dan subtitle section berhasil diperbarui!'
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui section: ' . $e->getMessage()
            ], 500);
        }
    }
}
