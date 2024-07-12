@extends('layouts.completados.app-master')

@section('content')


    <h1 class="titulo">Trabajos Completados</h1>
    
    @if (session('success'))
    <div id="success-alert-modal" class="modal-alert">
        <div class="modal-alert-content alert alert-success alert-dismissible fade-out custom-alert" role="alert">
            {{ session('success') }}
            <div class="progress-bar" id="success-progress-bar"></div>
        </div>
    </div>
    @endif

    @if ($errors->any())
        <div id="error-alert-modal" class="modal-alert">
            <div class="modal-alert-content custom-error-message">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    <div class="progress-bar" id="error-progress-bar"></div>
                </ul>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div id="error-alert" class="modal-alert alert alert-danger alert-dismissible fade-out custom-alert" role="alert">
            {{ session('error') }}
            <div class="progress-bar" id="error-progress-bar"></div>
        </div>
    @endif
     <!-- Input para búsqueda en tiempo real con estilos de Bootstrap -->
     <div class="input-group mb-3" style="max-width: 700px;">
        <!-- Ajusta el ancho máximo según tus necesidades -->
        <input type="text" id="searchInput" class="form-control" placeholder="Buscar recibo..." onkeyup="buscarRecibos()">
        
        <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="button">Buscar</button>
        </div>
    </div>
    
    <div class="d-flex justify-content-between align-items-center mb-3">
        <strong><h2>Total De Ordenes Completadas: {{ $totalRecibos }}</h2></strong>
        <div class="d-flex">
            <form action="{{ route('generar.reporte') }}" method="POST" target="_blank" style="margin-right: 10px;">
                @csrf
                <input type="hidden" name="fechaInicio" value="{{ now()->startOfDay()->toDateString() }}">
                <input type="hidden" name="fechaFin" value="{{ now()->endOfDay()->toDateString() }}">
                <button type="submit" class="btn btn-success">Generar Corte</button>
            </form>
            <button id="btnGenerarCorteDinamico" class="btn btn-primary" data-toggle="modal" data-target="#modalCorte">Generar Corte Dinámico</button>
        </div>
    </div>


<!-- Modal -->
<div class="modal fade" id="modalCorte" tabindex="-1" role="dialog" aria-labelledby="modalCorteLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- Agrega el formulario con action y method -->
            <form action="{{ route('generar.reporte') }}" method="POST" target="_blank">
            @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCorteLabel">Seleccionar Rango de Fechas</h5>
                    <button type="button" class="close close-button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Contenido del cuerpo de la modal -->
                    <label for="fechaInicio">Fecha de Inicio:</label>
                    <input type="date" id="fechaInicio" name="fechaInicio" class="form-control" required>
                    <label for="fechaFin">Fecha de Fin:</label>
                    <input type="date" id="fechaFin" name="fechaFin" class="form-control" required>
                </div>
                <div class="modal-footer">
                    <!-- Cambia el tipo de elemento a submit para enviar el formulario -->
                    <button type="submit" class="btn btn-primary">Generar Corte</button>
                </div>
            </form>
        </div>
    </div>
</div>


    <table class="tabla">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Fecha de Recibido</th>
                <th>Fecha de Reparado</th>
                <th>Recibo</th>
                <th>Ticket</th>
            </tr>
        </thead>
        <tbody id="recibosBody">
            @foreach($recibos as $recibo)
            <tr>
                <td>
                    @if(isset($recibo->tipoEquipo[0]->cliente))
                        {{ $recibo->tipoEquipo[0]->cliente->nombre}}
                    @else
                        Cliente No Encontrado
                    @endif
                </td>
                </td>
                <td>{{ date('d-m-Y', strtotime($recibo->created_at)) }}</td>
                <td>{{ date('d-m-Y', strtotime($recibo->fechaReparacion)) }}</td>

                <td>
                    <form action="{{ route('recibos.pdf', ['id' => $recibo->id]) }}" method="GET" target="_blank">
                        @csrf
                        <button type="submit" style="border: none; background-color: transparent; padding: 0;">
                            <img src="{{ url('assets/iconos/file-earmark-arrow-down-fill.svg') }}" width="24" height="24" style="display: block;">
                        </button>
                    </form>
                </td>

                <td>
                @if($recibo->ticket)
                        <form action="{{ route('completados.pdf', ['id' => $recibo->ticket->id]) }}" method="GET" target="_blank">
                            @csrf
                            <button type="submit" style="border: none; background-color: transparent; padding: 0;">
                                <img src="{{ url('assets/iconos/file-earmark-arrow-down-fill1.svg') }}" width="24" height="24" style="display: block;">
                            </button>
                        </form>
                    @endif
                </td>
            </tr>
            @endforeach
            
        </tbody>
    </table>
    <nav aria-label="...">
            <ul class="pagination">
                {{ $recibos->links() }}
            </ul>
    </nav>
@endsection
