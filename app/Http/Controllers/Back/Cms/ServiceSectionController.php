<?php

namespace App\Http\Controllers\Back\Cms;

use App\Http\Controllers\Controller;
use App\Models\Cms\ServiceSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ServiceSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $serviceSection = ServiceSection::active()->first();
        return view('back.cms.service-section.index', compact('serviceSection'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('back.cms.service-section.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'background_image' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
        ]);

        $data = $request->only(['title', 'subtitle']);
        $data['is_active'] = $request->has('is_active');

        // Handle background image upload
        if ($request->hasFile('background_image')) {
            $data['background_image'] = $request->file('background_image')->store('service-sections', 'public');
        }

        ServiceSection::create($data);

        return redirect()->route('admin.cms.service-section.index')
                       ->with('success', 'Section layanan berhasil dibuat.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ServiceSection $serviceSection): View
    {
        return view('back.cms.service-section.edit', compact('serviceSection'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ServiceSection $serviceSection)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'background_image' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
        ]);

        $data = $request->only(['title', 'subtitle']);
        $data['is_active'] = $request->has('is_active');

        // Handle background image upload
        if ($request->hasFile('background_image')) {
            // Delete old image if exists
            if ($serviceSection->background_image) {
                Storage::disk('public')->delete($serviceSection->background_image);
            }
            $data['background_image'] = $request->file('background_image')->store('service-sections', 'public');
        }

        $serviceSection->update($data);

        return redirect()->route('admin.cms.service-section.index')
                       ->with('success', 'Section layanan berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServiceSection $serviceSection)
    {
        // Delete background image if exists
        if ($serviceSection->background_image) {
            Storage::disk('public')->delete($serviceSection->background_image);
        }

        $serviceSection->delete();

        return redirect()->route('admin.cms.service-section.index')
                       ->with('success', 'Section layanan berhasil dihapus.');
    }

    /**
     * Get current section title for quick edit
     */
    public function getTitle()
    {
        $serviceSection = ServiceSection::active()->first();
        
        if ($serviceSection) {
            return response()->json([
                'success' => true,
                'title' => $serviceSection->title
            ]);
        }
        
        return response()->json([
            'success' => false,
            'title' => null
        ]);
    }

    /**
     * Update section title via AJAX
     */
    public function updateTitle(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $serviceSection = ServiceSection::active()->first();
        
        if (!$serviceSection) {
            // Create new section if none exists
            $serviceSection = ServiceSection::create([
                'title' => $request->title,
                'is_active' => true
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Judul section berhasil dibuat.'
            ]);
        }
        
        $serviceSection->update(['title' => $request->title]);
        
        return response()->json([
            'success' => true,
            'message' => 'Judul section berhasil diupdate.'
        ]);
    }
}
