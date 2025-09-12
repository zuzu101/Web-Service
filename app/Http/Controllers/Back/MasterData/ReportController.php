<?php

namespace App\Http\Controllers\Back\MasterData;

use App\Http\Controllers\Controller;
use App\Services\MasterData\ReportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{
    protected $reportService;
    
    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    /**
     * Display main report dashboard
     */
    public function index()
    {
        return view('back.MasterData.Report.index');
    }

    /**
     * Brand report
     */
    public function brand()
    {
        $brands = $this->reportService->getAvailableBrands();
        return view('back.MasterData.Report.brand', compact('brands'));
    }

    /**
     * Dashboard report - combines all transaction analysis
     */
    public function dashboard()
    {
        return view('back.MasterData.Report.dashboard');
    }

    /**
     * Get brand report data
     */
    public function brandData(Request $request)
    {
        return $this->reportService->getBrandReport($request);
    }

    /**
     * Get dashboard data
     */
    public function dashboardData(Request $request)
    {
        return $this->reportService->getTransactionHistory($request);
    }

    /**
     * Get dashboard summary
     */
    public function dashboardSummary(Request $request)
    {
        return response()->json($this->reportService->getTransactionHistorySummary($request));
    }

    /**
     * Export report to PDF
     */
    public function exportPdf(Request $request)
    {
        $type = $request->get('type'); // daily, weekly, monthly, brand, issue
        $date = $request->get('date');
        
        return $this->reportService->exportToPdf($type, $date);
    }

    /**
     * Export report to Excel
     */
    public function exportExcel(Request $request)
    {
        $type = $request->get('type'); // daily, weekly, monthly, brand, issue
        $date = $request->get('date');
        
        return $this->reportService->exportToExcel($type, $date);
    }
}
