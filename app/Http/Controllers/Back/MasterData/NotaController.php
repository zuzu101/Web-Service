<?php

namespace App\Http\Controllers\Back\MasterData;

use App\Http\Controllers\Controller;
use App\Http\Requests\MasterData\NotaRequest;
use App\Models\MasterData\DeviceRepair;
use App\Services\MasterData\NotaService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class NotaController extends Controller
{
    protected $notaService;
    
    public function __construct(NotaService $notaService)
    {
        $this->notaService = $notaService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('back.MasterData.Nota.index');
    }

    /**
     * Get data for DataTables
     */
    public function data(DeviceRepair $deviceRepair)
    {
        return $this->notaService->data($deviceRepair);
    }

    /**
     * Print nota (thermal print view)
     */
    public function print($id, Request $request = null)
    {
        $deviceRepair = $this->notaService->getNotaData($id);
        $notaNumber = $this->notaService->generateNotaNumber($deviceRepair);
        
        // Get payment info from request (support both GET and POST)
        $paidAmount = $request ? $request->get('paid_amount', 0) : 0;
        $change = max(0, $paidAmount - ($deviceRepair->price ?? 0));

        return view('back.MasterData.Nota.print', compact('deviceRepair', 'notaNumber', 'paidAmount', 'change'));
    }

    /**
     * Generate PDF nota
     */
    public function pdf($id, Request $request = null)
    {
        $deviceRepair = $this->notaService->getNotaData($id);
        $notaNumber = $this->notaService->generateNotaNumber($deviceRepair);
        
        // Get payment info from request (support both GET and POST)
        $paidAmount = $request ? $request->get('paid_amount', 0) : 0;
        $change = max(0, $paidAmount - ($deviceRepair->price ?? 0));
        
        $pdf = Pdf::loadView('back.MasterData.Nota.pdf', compact('deviceRepair', 'notaNumber', 'paidAmount', 'change'));
        $pdf->setPaper([0,0,165.025984252, 9321.122834646], 'portrait');
        
        return $pdf->download($notaNumber . '.pdf');
    }
}
