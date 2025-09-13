<?php

namespace App\Http\Controllers\Back\Cms;

use App\Http\Controllers\Controller;
use App\Models\Cms\HeroSection;
use App\Http\Requests\Cms\HeroSectionRequest;
use App\Services\Cms\HeroSectionService;
use Illuminate\Http\Request;

class HeroSectionController extends Controller
{
    protected $heroSectionService;

    public function __construct(HeroSectionService $heroSectionService)
    {
        $this->heroSectionService = $heroSectionService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('back.cms.hero.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('back.cms.hero.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HeroSectionRequest $request)
    {
        try {
            $this->heroSectionService->store($request);
            
            return redirect()
                ->route('admin.cms.hero.index')
                ->with('success', 'Hero Section berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan Hero Section: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(HeroSection $hero)
    {
        return view('back.cms.hero.show', compact('hero'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HeroSection $hero)
    {
        return view('back.cms.hero.edit', compact('hero'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(HeroSectionRequest $request, HeroSection $hero)
    {
        try {
            $this->heroSectionService->update($request, $hero);
            
            return redirect()
                ->route('admin.cms.hero.index')
                ->with('success', 'Hero Section berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui Hero Section: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HeroSection $hero)
    {
        try {
            $this->heroSectionService->destroy($hero);
            
            return response()->json([
                'success' => true,
                'message' => 'Hero Section berhasil dihapus!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus Hero Section: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get data for DataTables
     */
    public function data(Request $request)
    {
        return $this->heroSectionService->data(new HeroSection(), $request);
    }

    /**
     * Toggle active status
     */
    public function toggleStatus(HeroSection $hero)
    {
        try {
            $newStatus = !$hero->is_active;
            $hero->update(['is_active' => $newStatus]);
            
            if ($newStatus) {
                $message = "Hero Section berhasil diaktifkan! (Hero Section lain otomatis dinonaktifkan)";
            } else {
                $message = "Hero Section berhasil dinonaktifkan!";
            }
            
            return response()->json([
                'success' => true,
                'message' => $message
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah status: ' . $e->getMessage()
            ], 500);
        }
    }
}