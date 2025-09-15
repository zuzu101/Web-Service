<?php

namespace App\Http\Controllers\Back\Cms;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cms\ContactInfoRequest;
use App\Models\ContactInfo;
use App\Models\ContactSection;
use App\Services\Cms\ContactInfoService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\DataTables;

class ContactInfoController extends Controller
{
    protected $contactInfoService;

    public function __construct(ContactInfoService $contactInfoService)
    {
        $this->contactInfoService = $contactInfoService;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = ContactInfo::query();
            
            // Apply status filter if provided
            if ($request->has('status_filter') && $request->status_filter !== '') {
                $query->where('is_active', $request->status_filter);
            }
            
            return DataTables::of($query->ordered())
                ->addIndexColumn()
                ->addColumn('icon_display', function ($row) {
                    return $row->icon ? 
                        '<img src="' . $row->icon_url . '" alt="Icon" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">' : 
                        '<span class="text-muted">Tidak ada icon</span>';
                })
                ->addColumn('status', function ($row) {
                    $badgeClass = $row->is_active ? 'success' : 'secondary';
                    $statusText = $row->is_active ? 'Aktif' : 'Nonaktif';
                    return '<span class="badge badge-' . $badgeClass . '">' . $statusText . '</span>';
                })
                ->addColumn('action', function ($row) {
                    $editBtn = '<a href="' . route('admin.cms.contact-info.edit', $row->id) . '" class="btn btn-outline-info btn-sm d-inline-flex align-items-center mb-1">
                        <i class="fas fa-edit mr-1"></i> Edit
                    </a>';
                    
                    $toggleBtn = '<a href="javascript:void(0)" onclick="toggleStatus(' . $row->id . ')" class="btn btn-outline-warning btn-sm d-inline-flex align-items-center mb-1">
                        <i class="fas fa-toggle-' . ($row->is_active ? 'on' : 'off') . ' mr-1"></i> Toggle
                    </a>';
                    
                    $deleteBtn = '<a href="javascript:void(0)" onclick="deleteContactInfo(' . $row->id . ')" class="btn btn-outline-danger btn-sm d-inline-flex align-items-center">
                        <i class="fas fa-trash mr-1"></i> Hapus
                    </a>';
                    
                    return '<div class="btn-group-vertical">' . $editBtn . $toggleBtn . $deleteBtn . '</div>';
                })
                ->rawColumns(['icon_display', 'status', 'action'])
                ->make(true);
        }
        
        return view('back.cms.contact-info.index');
    }

    public function create()
    {
        return view('back.cms.contact-info.create');
    }

    public function store(ContactInfoRequest $request)
    {
        try {
            $this->contactInfoService->store($request->validated());
            
            return redirect()->route('admin.cms.contact-info.index')
                ->with('success', 'Contact info berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan contact info: ' . $e->getMessage());
        }
    }

    public function edit(ContactInfo $contactInfo)
    {
        return view('back.cms.contact-info.edit', compact('contactInfo'));
    }

    public function update(ContactInfoRequest $request, ContactInfo $contactInfo)
    {
        try {
            $this->contactInfoService->update($contactInfo, $request->validated());
            
            return redirect()->route('admin.cms.contact-info.index')
                ->with('success', 'Contact info berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui contact info: ' . $e->getMessage());
        }
    }

    public function destroy(ContactInfo $contactInfo)
    {
        try {
            $this->contactInfoService->delete($contactInfo);
            
            return response()->json([
                'success' => true,
                'message' => 'Contact info berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus contact info: ' . $e->getMessage()
            ], 500);
        }
    }

    public function toggleStatus(ContactInfo $contactInfo)
    {
        try {
            $contactInfo->update(['is_active' => !$contactInfo->is_active]);
            
            $status = $contactInfo->is_active ? 'diaktifkan' : 'dinonaktifkan';
            
            return response()->json([
                'success' => true,
                'message' => "Contact info berhasil {$status}"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah status: ' . $e->getMessage()
            ], 500);
        }
    }

    public function reorderPage()
    {
        $contactInfos = ContactInfo::ordered()->get();
        return view('back.cms.contact-info.reorder', compact('contactInfos'));
    }

    public function updateOrder(Request $request)
    {
        try {
            $orderData = $request->input('order');
            $this->contactInfoService->reorder($orderData);
            
            return response()->json([
                'success' => true,
                'message' => 'Urutan contact info berhasil diperbarui'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui urutan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getMapsUrl()
    {
        try {
            $contactSection = ContactSection::getActive();
            
            return response()->json([
                'success' => true,
                'maps_embed_url' => $contactSection ? $contactSection->maps_embed_url : null
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil Google Maps URL: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateMaps(Request $request)
    {
        $request->validate([
            'maps_embed_url' => 'required|string|url'
        ], [
            'maps_embed_url.required' => 'Google Maps embed URL wajib diisi',
            'maps_embed_url.url' => 'Format URL tidak valid'
        ]);

        try {
            // Check if Google Maps embed URL is valid
            if (!str_contains($request->maps_embed_url, 'google.com/maps/embed')) {
                return response()->json([
                    'success' => false,
                    'message' => 'URL harus berupa Google Maps embed URL yang valid'
                ], 422);
            }

            // Get existing contact section or create new one
            $contactSection = ContactSection::getActive();
            
            if ($contactSection) {
                $contactSection->update([
                    'maps_embed_url' => $request->maps_embed_url,
                    'is_active' => true
                ]);
            } else {
                ContactSection::create([
                    'maps_embed_url' => $request->maps_embed_url,
                    'is_active' => true
                ]);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Google Maps URL berhasil disimpan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan Google Maps URL: ' . $e->getMessage()
            ], 500);
        }
    }
}
