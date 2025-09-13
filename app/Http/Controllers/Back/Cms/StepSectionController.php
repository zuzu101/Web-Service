<?php

namespace App\Http\Controllers\Back\Cms;

use App\Http\Controllers\Controller;
use App\Models\Cms\StepSection;
use Illuminate\Http\Request;

class StepSectionController extends Controller
{
    public function index()
    {
        $stepSection = StepSection::first();
        return view('back.cms.step-section.index', compact('stepSection'));
    }

    public function getSectionData()
    {
        $stepSection = StepSection::first();
        return response()->json($stepSection);
    }

    public function create()
    {
        return view('back.cms.step-section.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string',
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
        ]);

        // Delete all existing step sections first (only allow one)
        $existingSections = StepSection::all();
        foreach ($existingSections as $section) {
            if ($section->background_image && file_exists(public_path('images/' . $section->background_image))) {
                unlink(public_path('images/' . $section->background_image));
            }
            $section->delete();
        }

        $data = $request->only(['title', 'subtitle', 'is_active']);
        $data['is_active'] = true; // Force active since it's the only one
        
        if ($request->hasFile('background_image')) {
            $image = $request->file('background_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);
            $data['background_image'] = $imageName;
        }

        StepSection::create($data);

        return redirect()->route('admin.cms.step-section.index')
                        ->with('success', 'Step section created successfully.');
    }

    public function edit(StepSection $stepSection)
    {
        return view('back.cms.step-section.edit', compact('stepSection'));
    }

    public function update(Request $request, StepSection $stepSection)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string',
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
        ]);

        // Delete all other step sections (only allow one)
        $otherSections = StepSection::where('id', '!=', $stepSection->id)->get();
        foreach ($otherSections as $section) {
            if ($section->background_image && file_exists(public_path('images/' . $section->background_image))) {
                unlink(public_path('images/' . $section->background_image));
            }
            $section->delete();
        }

        $data = $request->only(['title', 'subtitle', 'is_active']);
        $data['is_active'] = true; // Force active since it's the only one
        
        if ($request->hasFile('background_image')) {
            // Delete old image if exists
            if ($stepSection->background_image && file_exists(public_path('images/' . $stepSection->background_image))) {
                unlink(public_path('images/' . $stepSection->background_image));
            }
            
            $image = $request->file('background_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);
            $data['background_image'] = $imageName;
        }

        $stepSection->update($data);

        return redirect()->route('admin.cms.step-section.index')
                        ->with('success', 'Step section updated successfully.');
    }

    public function destroy(StepSection $stepSection)
    {
        // Delete image if exists
        if ($stepSection->background_image && file_exists(public_path('images/' . $stepSection->background_image))) {
            unlink(public_path('images/' . $stepSection->background_image));
        }
        
        $stepSection->delete();

        return response()->json(['message' => 'Step section deleted successfully.']);
    }
}