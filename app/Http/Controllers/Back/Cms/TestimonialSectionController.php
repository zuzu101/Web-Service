<?php

namespace App\Http\Controllers\Back\Cms;

use App\Http\Controllers\Controller;
use App\Models\TestimonialSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TestimonialSectionController extends Controller
{
    public function index()
    {
        $testimonialSection = TestimonialSection::first();
        return view('back.cms.testimonial-section.index', compact('testimonialSection'));
    }

    public function create()
    {
        return view('back.cms.testimonial-section.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        TestimonialSection::create($data);

        return redirect()->route('admin.cms.testimonial-section.index')
            ->with('success', 'Section testimoni berhasil dibuat!');
    }

    public function update(Request $request, TestimonialSection $testimonialSection)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        $testimonialSection->update($data);

        return redirect()->route('admin.cms.testimonial-section.index')
            ->with('success', 'Section testimoni berhasil diupdate!');
    }

    public function updateTitle(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $testimonialSection = TestimonialSection::first();
        
        if (!$testimonialSection) {
            // Create new section if doesn't exist
            TestimonialSection::create([
                'title' => $request->title,
                'is_active' => true
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Judul section berhasil dibuat.'
            ]);
        }
        
        $testimonialSection->update(['title' => $request->title]);
        
        return response()->json([
            'success' => true,
            'message' => 'Judul section berhasil diupdate.'
        ]);
    }

    public function getTitle()
    {
        $testimonialSection = TestimonialSection::first();
        
        return response()->json([
            'title' => $testimonialSection ? $testimonialSection->title : 'Apa Kata Pelanggan Kami?'
        ]);
    }
}