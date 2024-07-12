<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\TipoEquipo;
use App\Models\Concepto;
use App\Models\Recibo;
use PDF;

class FinalizadoController extends Controller
{
    public function index()
    {
            
             // Recuperar los recibos completados (id_estado = 3) y ordenarlos por el ID del ticket en orden descendente
            $recibos = Recibo::where('id_estado', 3)
            ->join('tickets', 'recibos.id', '=', 'tickets.id_recibo') // Hacer join con la tabla tickets
            ->orderBy('tickets.id', 'DESC') // Ordenar por id de ticket en orden descendente
            ->select('recibos.*') // Seleccionar todas las columnas de recibos
            ->paginate(5);

            $totalRecibos = Recibo::where('id_estado', 3)->count(); 
             return view('completados.completados', compact('recibos','totalRecibos'));
    }

    public function pdf($id)
    {
        $ticket = Ticket::find($id);

        if (!$ticket) {
            // Manejo del caso cuando el ticket no existe
        }

        // Obtener los conceptos asociados al ticket
        $conceptos = $ticket->concepto;
        
        $pdf = PDF::loadView('completados.pdfTicket', ['ticket' => $ticket, 'conceptos' => $conceptos])->setPaper(array(0,0,360,792.00), 'portrait');
       // return view('completados.pdfTicket', ['ticket' => $ticket, 'conceptos' => $conceptos]);
        return $pdf->stream();
    }

}
