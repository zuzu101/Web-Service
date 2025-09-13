<?php

namespace App\Http\Controllers\Back\Cms;

use App\Http\Controllers\Controller;
use App\Models\Cms\AdvantageSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdvantageSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $advantageSection = AdvantageSection::active()->first();
        return view('back.cms.advantage-section.index', compact('advantageSection'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('back.cms.advantage-section.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'background_image' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
        ]);

        $data = $request->only(['title']);
        $data['is_active'] = $request->has('is_active');

        // Handle background image upload
        if ($request->hasFile('background_image')) {
            $data['background_image'] = $request->file('background_image')->store('advantage-sections', 'public');
        }

        AdvantageSection::create($data);

        return redirect()->route('admin.cms.advantage-section.index')
                       ->with('success', 'Section keunggulan berhasil dibuat.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AdvantageSection $advantageSection): View
    {
        return view('back.cms.advantage-section.edit', compact('advantageSection'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AdvantageSection $advantageSection)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'background_image' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
        ]);

        $data = $request->only(['title']);
        $data['is_active'] = $request->has('is_active');

        // Handle background image upload
        if ($request->hasFile('background_image')) {
            // Delete old image if exists
            if ($advantageSection->background_image) {
                Storage::disk('public')->delete($advantageSection->background_image);
            }
            $data['background_image'] = $request->file('background_image')->store('advantage-sections', 'public');
        }

        $advantageSection->update($data);

        return redirect()->route('admin.cms.advantage-section.index')
                       ->with('success', 'Section keunggulan berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AdvantageSection $advantageSection)
    {
        // Delete background image if exists
        if ($advantageSection->background_image) {
            Storage::disk('public')->delete($advantageSection->background_image);
        }

        $advantageSection->delete();

        return redirect()->route('admin.cms.advantage-section.index')
                       ->with('success', 'Section keunggulan berhasil dihapus.');
    }

    /**
     * Get current section title for quick edit
     */
    public function getTitle()
    {
        $advantageSection = AdvantageSection::active()->first();
        
        if ($advantageSection) {
            return response()->json([
                'success' => true,
                'title' => $advantageSection->title
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

        $advantageSection = AdvantageSection::active()->first();
        
        if (!$advantageSection) {
            // Create new section if none exists
            $advantageSection = AdvantageSection::create([
                'title' => $request->title,
                'is_active' => true
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Judul section berhasil dibuat.'
            ]);
        }
        
        $advantageSection->update(['title' => $request->title]);
        
        return response()->json([
            'success' => true,
            'message' => 'Judul section berhasil diupdate.'
        ]);
    }
}
