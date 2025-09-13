<?php

namespace App\Http\Controllers\Back\Cms;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cms\ServiceRequest;
use App\Models\Cms\Service;
use App\Services\Cms\ServiceService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class ServiceController extends Controller
{
    protected $serviceService;

    public function __construct(ServiceService $serviceService)
    {
        $this->serviceService = $serviceService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            $services = Service::ordered()->get();

            return DataTables::of($services)
                ->addIndexColumn()
                ->addColumn('image', function ($service) {
                    return $service->image ? 
                        '<img src="' . $service->image_url . '" alt="Service Image" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">' : 
                        '<span class="text-muted">Tidak ada gambar</span>';
                })
                ->addColumn('description', function ($service) {
                    return strlen($service->description) > 100 ? 
                        substr($service->description, 0, 100) . '...' : 
                        $service->description;
                })
                ->addColumn('status', function ($service) {
                    $badgeClass = $service->is_active ? 'badge-success' : 'badge-secondary';
                    $badgeText = $service->is_active ? 'Aktif' : 'Nonaktif';
                    
                    return '<span class="badge ' . $badgeClass . '">' . $badgeText . '</span>';
                })
                ->addColumn('action', function ($service) {
                    $editBtn = '<a href="' . route('admin.cms.service.edit', $service->id) . '" class="btn btn-outline-info btn-sm d-inline-flex align-items-center mb-1">
                        <i class="fas fa-edit mr-1"></i> Edit
                    </a>';
                    
                    $toggleBtn = '<a href="javascript:void(0)" onclick="toggleStatus(' . $service->id . ')" class="btn btn-outline-warning btn-sm d-inline-flex align-items-center mb-1">
                        <i class="fas fa-toggle-on mr-1"></i> Toggle
                    </a>';
                    
                    $deleteBtn = '<a href="javascript:void(0)" onclick="deleteService(' . $service->id . ')" class="btn btn-outline-danger btn-sm d-inline-flex align-items-center">
                        <i class="fas fa-trash mr-1"></i> Hapus
                    </a>';
                    
                    return '<div class="btn-group-vertical">' . $editBtn . $toggleBtn . $deleteBtn . '</div>';
                })
                ->rawColumns(['image', 'status', 'action'])
                ->make(true);
        }

        return view('back.cms.service.index');
    }

    /**
     * Show reorder page
     */
    public function reorderPage(): View
    {
        $services = Service::ordered()->get();
        return view('back.cms.service.reorder', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('back.cms.service.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ServiceRequest $request)
    {
        try {
            $this->serviceService->store($request->validated());
            
            return redirect()->route('admin.cms.service.index')
                           ->with('success', 'Layanan berhasil ditambahkan.');
        } catch (Exception $e) {
            return redirect()->back()
                           ->with('error', 'Gagal menambahkan layanan: ' . $e->getMessage())
                           ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service): View
    {
        return view('back.cms.service.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service): View
    {
        return view('back.cms.service.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ServiceRequest $request, Service $service)
    {
        try {
            $this->serviceService->update($service, $request->validated());
            
            return redirect()->route('admin.cms.service.index')
                           ->with('success', 'Layanan berhasil diupdate.');
        } catch (Exception $e) {
            return redirect()->back()
                           ->with('error', 'Gagal mengupdate layanan: ' . $e->getMessage())
                           ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service): JsonResponse
    {
        try {
            $this->serviceService->delete($service);
            
            return response()->json([
                'success' => true,
                'message' => 'Layanan berhasil dihapus.'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus layanan: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Toggle service status (active/inactive)
     */
    public function toggleStatus(Service $service): JsonResponse
    {
        try {
            $service->update([
                'is_active' => !$service->is_active
            ]);
            
            $statusText = $service->is_active ? 'Aktif' : 'Nonaktif';
            
            return response()->json([
                'success' => true,
                'is_active' => $service->is_active,
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
     * Reorder services
     */
    public function reorder(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'order' => 'required|array',
                'order.*.id' => 'required|integer|exists:services,id',
                'order.*.order_number' => 'required|integer|min:1'
            ]);

            $success = $this->serviceService->reorder($request->order);
            
            if ($success) {
                return response()->json([
                    'success' => true,
                    'message' => 'Urutan layanan berhasil diupdate.'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengupdate urutan layanan.'
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
