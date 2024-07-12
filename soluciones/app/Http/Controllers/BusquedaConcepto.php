<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NombreConcepto;
use Illuminate\Support\Facades\View;

class BusquedaConcepto extends Controller
{
    public function buscar(Request $request){

          // Obtener el término de búsqueda del parámetro 'query' en la solicitud
          $query = $request->input('query');

        // Realizar la búsqueda de conceptos que coincidan con el término de búsqueda

          $conceptos = NombreConcepto::where('nombre', 'like', '%' . $query . '%')
          ->select('nombre', 'precio', 'id_categoria')
          ->get();

          return response()->json($conceptos);

    }

    
}
