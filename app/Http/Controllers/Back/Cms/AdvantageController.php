<?php

namespace App\Http\Controllers\Back\Cms;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cms\AdvantageRequest;
use App\Models\Cms\Advantage;
use App\Services\Cms\AdvantageService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class AdvantageController extends Controller
{
    protected $advantageService;

    public function __construct(AdvantageService $advantageService)
    {
        $this->advantageService = $advantageService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            $advantages = Advantage::ordered()->get();

            return DataTables::of($advantages)
                ->addIndexColumn()
                ->addColumn('icon', function ($advantage) {
                    return $advantage->icon ? 
                        '<img src="' . $advantage->icon_url . '" alt="Icon" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">' : 
                        '<span class="text-muted">Tidak ada icon</span>';
                })
                ->addColumn('status', function ($advantage) {
                    $badgeClass = $advantage->is_active ? 'badge-success' : 'badge-secondary';
                    $badgeText = $advantage->is_active ? 'Aktif' : 'Nonaktif';
                    
                    return '<span class="badge ' . $badgeClass . '">' . $badgeText . '</span>';
                })
                ->addColumn('action', function ($advantage) {
                    $editBtn = '<a href="' . route('admin.cms.advantage.edit', $advantage->id) . '" class="btn btn-outline-info btn-sm d-inline-flex align-items-center mb-1">
                        <i class="fas fa-edit mr-1"></i> Edit
                    </a>';
                    
                    $toggleBtn = '<a href="javascript:void(0)" onclick="toggleStatus(' . $advantage->id . ')" class="btn btn-outline-warning btn-sm d-inline-flex align-items-center mb-1">
                        <i class="fas fa-toggle-on mr-1"></i> Toggle
                    </a>';
                    
                    $deleteBtn = '<a href="javascript:void(0)" onclick="deleteAdvantage(' . $advantage->id . ')" class="btn btn-outline-danger btn-sm d-inline-flex align-items-center">
                        <i class="fas fa-trash mr-1"></i> Hapus
                    </a>';
                    
                    return '<div class="btn-group-vertical">' . $editBtn . $toggleBtn . $deleteBtn . '</div>';
                })
                ->rawColumns(['icon', 'status', 'action'])
                ->make(true);
        }

        return view('back.cms.advantage.index');
    }

    /**
     * Show reorder page
     */
    public function reorderPage(): View
    {
        $advantages = Advantage::ordered()->get();
        return view('back.cms.advantage.reorder', compact('advantages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('back.cms.advantage.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdvantageRequest $request)
    {
        try {
            $this->advantageService->store($request->validated());
            
            return redirect()->route('admin.cms.advantage.index')
                           ->with('success', 'Keunggulan berhasil ditambahkan.');
        } catch (Exception $e) {
            return redirect()->back()
                           ->with('error', 'Gagal menambahkan keunggulan: ' . $e->getMessage())
                           ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Advantage $advantage): View
    {
        return view('back.cms.advantage.show', compact('advantage'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Advantage $advantage): View
    {
        return view('back.cms.advantage.edit', compact('advantage'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdvantageRequest $request, Advantage $advantage)
    {
        try {
            $this->advantageService->update($advantage, $request->validated());
            
            return redirect()->route('admin.cms.advantage.index')
                           ->with('success', 'Keunggulan berhasil diupdate.');
        } catch (Exception $e) {
            return redirect()->back()
                           ->with('error', 'Gagal mengupdate keunggulan: ' . $e->getMessage())
                           ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Advantage $advantage): JsonResponse
    {
        try {
            $this->advantageService->delete($advantage);
            
            return response()->json([
                'success' => true,
                'message' => 'Keunggulan berhasil dihapus.'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus keunggulan: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Toggle advantage status (active/inactive)
     */
    public function toggleStatus(Advantage $advantage): JsonResponse
    {
        try {
            $advantage->update([
                'is_active' => !$advantage->is_active
            ]);
            
            $statusText = $advantage->is_active ? 'Aktif' : 'Nonaktif';
            
            return response()->json([
                'success' => true,
                'is_active' => $advantage->is_active,
                'status_text' => $statusText,
                'message' => "Status berhasil diubah menjadi {$statusText}"
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah status: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Reorder advantages
     */
    public function reorder(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'order' => 'required|array',
                'order.*.id' => 'required|integer|exists:advantages,id',
                'order.*.order_number' => 'nullable|integer|min:1'
            ]);

            $success = $this->advantageService->reorder($request->order);
            
            if ($success) {
                return response()->json([
                    'success' => true,
                    'message' => 'Urutan keunggulan berhasil diupdate.'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengupdate urutan keunggulan.'
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate urutan: ' . $e->getMessage()
            ]);
        }
    }
}
