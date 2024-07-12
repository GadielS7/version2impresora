<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF; 
use App\Models\NombreConcepto;
use Carbon\Carbon;
use App\Models\Concepto;
use App\Models\Ticket;

class ReporteController extends Controller
{
    public function generarReporte(Request $request)
    {
         // Usar la fecha actual si no se proporcionan fechas
         $fechaInicio = $request->input('fechaInicio') ?? now()->startOfDay()->toDateString();
         $fechaFin = $request->input('fechaFin') ?? now()->endOfDay()->toDateString();
         $esCorteDiario = $fechaInicio == now()->startOfDay()->toDateString() && $fechaFin == now()->endOfDay()->toDateString();
        // Obtener los tickets dentro del rango de fechas
        $tickets = Ticket::whereBetween('fecha', [$fechaInicio, $fechaFin])->get(); //relacion ticket con concepto
        
        // Generar el PDF utilizando la librería PDF y pasando los datos a la vista
        $pdf = PDF::loadView('corte.pdfcorte', compact('tickets', 'fechaInicio', 'fechaFin', 'esCorteDiario'));
        // Devolver la respuesta del PDF para visualización en el navegador
        return $pdf->stream('reporteCorte.pdf');
    }

}
