<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\BusquedaClientesController;
use App\Http\Controllers\BuscarColoniasController;
use App\Http\Controllers\ColoniasController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\RegistroEquipoCliente;
use App\Http\Controllers\ReciboController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\ConceptoController;
use App\Http\Controllers\FinalizadoController;
use App\Http\Controllers\BusquedaRecibo;
use App\Http\Controllers\buscarTicket;
use App\Http\Controllers\BusquedaCompleto;
use App\Http\Controllers\BuscarCliente;
use App\Http\Controllers\BuscarUsuario;
use App\Http\Controllers\BusquedaConcepto;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\RechazadoController;
use Illuminate\Http\Request;
use App\Models\Marca;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Route::get('/', function () {
  // return view('auth.login');
//})->name('login');

/*Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('home.index');
    }
    return view('auth.login');
})->name('login');*/

Route::get('/', function () {
  return view('auth.login');
})->name('login')->middleware('guest');


Route::post('/register',[RegisterController::class,'register'])->middleware('auth');

Route::get('/register',[RegisterController::class,'show'])->middleware('auth');

Route::get('/login', [LoginController::class, 'show'])->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest');
// Rutas protegidas por el middleware 'auth'
//Route::middleware('auth')->group(function () {
  //  Route::get('/home', [HomeController::class, 'index'])->name('home.index');
    //Route::post('/login',[LoginController::class,'login']);
//});


Route::get('/home',[HomeController::class,'index'])->name('home.index')->middleware('auth');
Route::get('/logout',[LogoutController::class,'logout'])->middleware('auth');
 
Route::resource('users',UserController::Class)
->except(['create', 'show'])
->middleware('auth')
->names('users');

Route::resource('clientes', ClientesController::class)
->except(['create', 'show'])
->middleware('auth');

Route::resource('colonias', ColoniasController::class)
->except(['create', 'show'])
->middleware('auth');

Route::resource('marcas', MarcaController::class)
->except(['create', 'show'])
->middleware('auth');


Route::resource('tipo_equipos', EquipoController::class)
->except(['create', 'show'])
->middleware('auth');

Route::resource('recibos', ReciboController::class)
->except(['create', 'store', 'show', 'edit', 'update', 'destroy'])
->middleware('auth');

Route::resource('ticket', TicketController::class)
->except(['create', 'store', 'show', 'edit', 'update', 'destroy'])
->middleware('auth');

Route::resource('conceptos', ConceptoController::class)
->except(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'])
->middleware('auth');

Route::post('/conceptos', [ConceptoController::class, 'guardar'])->name('conceptos.guardar')->middleware('auth');


// Ruta para buscar clientes en tiempo real
Route::get('/home/buscar', [BusquedaClientesController::class, 'buscar'])->middleware('auth');

// Ruta para seleccionar un cliente específico y cargar su información
Route::get('/home/seleccionarCliente/{id}', [BusquedaClientesController::class, 'seleccionarCliente'])->middleware('auth');

Route::get('/buscarUsuario', [BuscarUsuario::class, 'buscar'])->middleware('auth');
Route::get('/buscarCliente', [BuscarCliente::class, 'buscar'])->middleware('auth');
Route::get('/buscarCompleto', [BusquedaCompleto::class, 'buscar'])->middleware('auth');
Route::get('/buscarTicket', [buscarTicket::class, 'buscar'])->middleware('auth');
Route::get('/buscarConcepto', [BusquedaConcepto::class, 'buscar'])->middleware('auth');
Route::get('/buscarRecibo', [BusquedaRecibo::class, 'buscar'])->name('recibos.buscar')->middleware('auth');
Route::get('/buscarRechazado', [RechazadoController::class, 'buscar'])->middleware('auth');


Route::get('recibos/pdf/{id}', [ReciboController::class, 'pdf'])->name('recibos.pdf')->middleware('auth');
Route::get('recibos/pdfImprimir/{id}', [ReciboController::class, 'pdfImprimir'])->name('pdfImprimir.pdfImprimir')->middleware('auth');
Route::post('completados/reporte', [ReporteController::class, 'generarReporte'])->name('generar.reporte')->middleware('auth');
                                                                          
                                                                                
Route::get('recibos/estado/{id}', [RegistroEquipoCliente::class, 'estado'])->name('recibos.estado')->middleware('auth');
Route::get('recibos/cancelado/{id}', [RegistroEquipoCliente::class, 'cancelado'])->name('recibos.cancelado')->middleware('auth');
Route::get('recibos/rechazado', [ReciboController::class, 'rechazado'])->name('recibos.rechazado')->middleware('auth');

Route::get('/imprimir', [ConceptoController::class, 'imprimir'])->middleware('auth');


Route::get('/home/buscarColonia', [BuscarColoniasController::class, 'buscarColonia'])->middleware('auth');

Route::post('/home/registroEquipoCliente', [RegistroEquipoCliente::class, 'recepcion'])->middleware('auth');
Route::post('/home/validarMarca', function (Request $request) {
  $marcaExiste = Marca::where('marca', $request->marca)->exists();
  return response()->json(['exists' => $marcaExiste]);
});
Route::get('completados',[FinalizadoController::class,'index'])->name('completados.index')->middleware('auth');
Route::get('completados/pdf/{id}',[FinalizadoController::class,'pdf'])->name('completados.pdf')->middleware('auth');

