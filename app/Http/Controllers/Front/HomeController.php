<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MasterData\DeviceRepair;
use App\Models\Region\Province;
use App\Models\Region\Regency;
use App\Models\Region\District;
use App\Models\Cms\HeroSection;
use App\Models\Cms\Advantage;
use App\Models\Cms\AdvantageSection;
use App\Models\Cms\Service;
use App\Models\Cms\ServiceSection;
use App\Models\Cms\Step;
use App\Models\Cms\StepSection;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\View\View
     */
    public function __invoke(Request $request)
    {
        // Get active hero section
        $heroSection = HeroSection::active()->first();

        // Get active advantages (all active advantages, ordered)
        $advantages = Advantage::active()->ordered()->get();
        
        // Get active advantage section
        $advantageSection = AdvantageSection::active()->first();
        
        // Get active services (all active services, ordered)
        $services = Service::active()->ordered()->get();
        
        // Get active service section
        $serviceSection = ServiceSection::active()->first();
        
        // Get active steps (all active steps, ordered)
        $steps = Step::active()->ordered()->get();
        
        // Get active step section
        $stepSection = StepSection::active()->first();

        // Get distinct non-empty brands from device_repairs table, ordered alphabetically
        $brands = DeviceRepair::query()
            ->whereNotNull('brand')
            ->where('brand', '<>', '')
            ->select('brand')
            ->distinct()
            ->orderBy('brand')
            ->pluck('brand');

        // Get provinces for address selection
        $provinces = Province::orderBy('name')->get();

        return view('front.home.index', compact('heroSection', 'advantages', 'advantageSection', 'services', 'serviceSection', 'steps', 'stepSection', 'brands', 'provinces'));
    }

    public function cekStatus(Request $request)
    {
        $servis = null;
        $notFound = false;
        $searched = false;
        
        // Jika ada parameter pencarian nomor servis
        if ($request->has('no_servis') && !empty($request->no_servis)) {
            $searched = true;
            
            // Cari data berdasarkan nomor nota
            $servis = DeviceRepair::with('customers')
                ->where('nota_number', $request->no_servis)
                ->first();
            
            // Jika tidak ditemukan
            if (!$servis) {
                $notFound = true;
            }
        }
        
        return view('front.page.cekstatus', compact('servis', 'notFound', 'searched'));
    }
}
