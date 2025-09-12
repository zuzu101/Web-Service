<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MasterData\DeviceRepair;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;

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

        return view('front.home.index', compact('brands', 'provinces'));
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
