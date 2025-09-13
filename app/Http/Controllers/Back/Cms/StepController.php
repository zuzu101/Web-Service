<?php

namespace App\Http\Controllers\Back\Cms;

use App\Http\Controllers\Controller;
use App\Http\Requests\StepRequest;
use App\Models\Cms\Step;
use App\Services\StepService;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class StepController extends Controller
{
    protected $stepService;

    public function __construct(StepService $stepService)
    {
        $this->stepService = $stepService;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Step::select(['id', 'title', 'description', 'icon', 'is_active', 'order', 'created_at'])->orderBy('order', 'asc');
            
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('icon_image', function ($step) {
                    return $step->icon ? 
                        '<img src="' . asset('images/' . $step->icon) . '" alt="Step Icon" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">' : 
                        '<span class="text-muted">Tidak ada icon</span>';
                })
                ->editColumn('description', function ($step) {
                    return strlen($step->description) > 100 ? 
                        substr($step->description, 0, 100) . '...' : 
                        $step->description;
                })
                ->addColumn('status_badge', function ($step) {
                    $badgeClass = $step->is_active ? 'badge-success' : 'badge-secondary';
                    $badgeText = $step->is_active ? 'Aktif' : 'Nonaktif';
                    
                    return '<span class="badge ' . $badgeClass . '">' . $badgeText . '</span>';
                })
                ->addColumn('action', function ($step) {
                    $editBtn = '<a href="' . route('admin.cms.step.edit', $step->id) . '" class="btn btn-outline-info btn-sm d-inline-flex align-items-center mb-1">
                        <i class="fas fa-edit mr-1"></i> Edit
                    </a>';
                    
                    $toggleBtn = '<a href="javascript:void(0)" onclick="toggleStatus(' . $step->id . ')" class="btn btn-outline-warning btn-sm d-inline-flex align-items-center mb-1">
                        <i class="fas fa-toggle-on mr-1"></i> Toggle
                    </a>';
                    
                    $deleteBtn = '<a href="javascript:void(0)" onclick="deleteStep(' . $step->id . ')" class="btn btn-outline-danger btn-sm d-inline-flex align-items-center">
                        <i class="fas fa-trash mr-1"></i> Hapus
                    </a>';
                    
                    return '<div class="btn-group-vertical">' . $editBtn . $toggleBtn . $deleteBtn . '</div>';
                })
                ->rawColumns(['icon_image', 'status_badge', 'action'])
                ->make(true);
        }

        return view('back.cms.step.index');
    }

    public function create()
    {
        return view('back.cms.step.create');
    }

    public function store(StepRequest $request)
    {
        $this->stepService->create($request->validated());

        return redirect()->route('admin.cms.step.index')
                        ->with('success', 'Step created successfully.');
    }

    public function edit(Step $step)
    {
        return view('back.cms.step.edit', compact('step'));
    }

    public function update(StepRequest $request, Step $step)
    {
        $this->stepService->update($step, $request->validated());

        return redirect()->route('admin.cms.step.index')
                        ->with('success', 'Step updated successfully.');
    }

    public function destroy(Step $step)
    {
        $this->stepService->delete($step);

        return response()->json(['message' => 'Step deleted successfully.']);
    }

    public function toggleStatus(Request $request, Step $step)
    {
        $newStatus = !$step->is_active;
        $step->update(['is_active' => $newStatus]);

        $statusText = $newStatus ? 'Aktif' : 'Nonaktif';

        return response()->json([
            'success' => true,
            'status' => $newStatus,
            'status_text' => $statusText,
            'message' => "Status berhasil diubah menjadi {$statusText}"
        ]);
    }

    public function reorderPage()
    {
        $steps = Step::active()->ordered()->get();
        return view('back.cms.step.reorder', compact('steps'));
    }

    public function reorder(Request $request)
    {
        try {
            $request->validate([
                'order' => 'required|array',
                'order.*.id' => 'required|integer|exists:steps,id',
                'order.*.order_number' => 'required|integer|min:1'
            ]);

            $success = $this->stepService->reorder($request->order);
            
            if ($success) {
                return response()->json([
                    'success' => true,
                    'message' => 'Urutan step berhasil diupdate.'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengupdate urutan step.'
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