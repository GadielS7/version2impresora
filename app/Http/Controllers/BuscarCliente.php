<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clientes;
use Illuminate\Support\Facades\View;

class BuscarCliente extends Controller
{
    public function buscar(Request $request)
    {
        $searchTerm = $request->input('search');

        // Realizar la búsqueda por el nombre del cliente
        $clientes = Clientes::where('nombre', 'like', '%'.$searchTerm.'%')->paginate(5);

        // Cargar la vista parcial y pasar los datos de la búsqueda
        $recibosBodyHtml = View::make('clientes.clientes-body', compact('clientes'))->render();

        // Retornar la vista parcial como respuesta
        return response()->json(['recibosBodyHtml' => $recibosBodyHtml]);
    }

}
