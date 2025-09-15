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
use App\Models\Cms\Video;
use App\Models\Cms\VideoSection;
use App\Models\Cms\Promo;
use App\Models\Cms\PromoSection;
use App\Models\Testimonial;
use App\Models\TestimonialSection;
use App\Models\AboutSection;
use App\Models\CtaSection;
use App\Models\ContactInfo;
use App\Models\ContactSection;

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
        
        // Get active videos (all active videos, ordered by created_at desc)
        $videos = Video::active()->orderBy('created_at', 'desc')->get();
        
        // Get active video section
        $videoSection = VideoSection::active()->first();

        // Get active promos
        $promos = Promo::active()->get();
        
        // Get active promo section
        $promoSection = PromoSection::active()->first();

        // Get active testimonials (ordered by order field and created_at desc)
        $testimonials = Testimonial::active()->ordered()->get();
        
        // Get active testimonial section
        $testimonialSection = TestimonialSection::active()->first();

        // Get active about section
        $aboutSection = AboutSection::getActive();

        // Get active CTA section (single active CTA section)
        $ctaSection = CtaSection::getActive();

        // Get active contact info (ordered)
        $contactInfos = ContactInfo::active()->ordered()->get();

        // Get active contact section
        $contactSection = ContactSection::getActive();

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

        return view('front.home.index', compact('heroSection', 'advantages', 'advantageSection', 'services', 'serviceSection', 'steps', 'stepSection', 'videos', 'videoSection', 'promos', 'promoSection', 'testimonials', 'testimonialSection', 'aboutSection', 'ctaSection', 'contactInfos', 'contactSection', 'brands', 'provinces'));
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
