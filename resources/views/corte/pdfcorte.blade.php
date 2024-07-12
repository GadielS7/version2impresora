<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Corte</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 19px;
        }

        h1 {
            text-align: center;
        }

        .header {
            text-align: right;
        }

        .tickets-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .tickets-table th, .tickets-table td {
            padding: 8px;
            text-align: center;
        }

        .tickets-table th {
            background-color: #f2f2f2;
            text-align: center;
        }

        .category-title {
            margin-top: 40px;
            text-align: left;
            font-size: 18px;
            font-weight: bold;
        }

        .total-row {
            font-weight: bold;
            text-align: right;
        }

        .total-cell {
            text-align: right;
        }

        .separator {
            margin-top: 40px;
            margin-bottom: 40px;
            border-top: 2px solid #000000;
        }
    </style>
</head>
<body>
    <h1>Reporte de Corte</h1>
    <div class="header">
        @if($esCorteDiario)
            <p><strong>Fecha de Corte:</strong> {{ date('d-m-Y', strtotime($fechaInicio)) }}</p>
        @else
            <p><strong>Fecha de inicio:</strong> {{ date('d-m-Y', strtotime($fechaInicio)) }}</p>
            <p><strong>Fecha de fin:</strong> {{ date('d-m-Y', strtotime($fechaFin)) }}</p>
        @endif
    </div>

    <div class="category-section">
        <h2 class="category-title">Mercancía - Efectivo</h2>
        <table class="tickets-table">
            <thead>
                <tr>
                    <th>Cantidad</th>
                    <th>Descripción</th>
                    <th>Pago</th>
                    <!-- Agrega más encabezados según tus necesidades -->
                </tr>
            </thead>
            <tbody>
                @php
                    $totalMercanciaEfectivo = 0; // Inicializa la variable para el total de mercancía pagada en efectivo
                @endphp
                @foreach($tickets as $ticket)
                    @if($ticket->tipoPago->tipoPago == 'EFECTIVO')
                        @foreach($ticket->concepto as $concepto)
                            @if($concepto->nombreConcepto?->categoria?->categoria == 'MERCANCIA')
                                <tr>
                                    <td>{{ $concepto->cantidad }}</td>
                                    <td>{{ $concepto->nombreConcepto->nombre }}</td>
                                    <td>${{ number_format($concepto->total, 2) }}</td>
                                    <!-- Aquí puedes agregar más columnas según necesites -->
                                </tr>
                                @php
                                    $totalMercanciaEfectivo += $concepto->total; // Suma el total del concepto al total de mercancía pagada en efectivo
                                @endphp
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </tbody>
        </table>
        <p class="total-row">TOTAL MERCANCÍA - EFECTIVO: <span class="total-cell">${{ number_format($totalMercanciaEfectivo, 2) }}</span></p>
    </div>

    <div class="separator"></div> <!-- Línea separadora -->

    <div class="category-section">
        <h2 class="category-title">Mercancía - Transferencia</h2>
        <table class="tickets-table">
            <thead>
                <tr>
                    <th>Cantidad</th>
                    <th>Descripción</th>
                    <th>Pago</th>
                    <!-- Agrega más encabezados según tus necesidades -->
                </tr>
            </thead>
            <tbody>
                @php
                    $totalMercanciaTransferencia = 0; // Inicializa la variable para el total de mercancía pagada por transferencia
                @endphp
                @foreach($tickets as $ticket)
                    @if($ticket->tipoPago->tipoPago == 'TRANSFERENCIA')
                        @foreach($ticket->concepto as $concepto)
                            @if($concepto->nombreConcepto?->categoria?->categoria == 'MERCANCIA')
                                <tr>
                                    <td>{{ $concepto->cantidad }}</td>
                                    <td>{{ $concepto->nombreConcepto->nombre }}</td>
                                    <td>${{ number_format($concepto->total, 2) }}</td>
                                    <!-- Aquí puedes agregar más columnas según necesites -->
                                </tr>
                                @php
                                    $totalMercanciaTransferencia += $concepto->total; // Suma el total del concepto al total de mercancía pagada por transferencia
                                @endphp
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </tbody>
        </table>
        <p class="total-row">TOTAL MERCANCÍA - TRANSFERENCIA: <span class="total-cell">${{ number_format($totalMercanciaTransferencia, 2) }}</span></p>
    </div>

    <div class="separator"></div> <!-- Línea separadora -->

    <div class="category-section">
        <h2 class="category-title">Servicio - Efectivo</h2>
        <table class="tickets-table">
            <thead>
                <tr>
                    <th>Cantidad</th>
                    <th>Descripción</th>
                    <th>Pago</th>
                    <!-- Agrega más encabezados según tus necesidades -->
                </tr>
            </thead>
            <tbody>
                @php
                    $totalServicioEfectivo = 0; // Inicializa la variable para el total de servicio pagado en efectivo
                @endphp
                @foreach($tickets as $ticket)
                    @if($ticket->tipoPago->tipoPago == 'EFECTIVO')
                        @foreach($ticket->concepto as $concepto)
                            @if($concepto->nombreConcepto?->categoria?->categoria == 'SERVICIO')
                                <tr>
                                    <td>{{ $concepto->cantidad }}</td>
                                    <td>{{ $concepto->nombreConcepto->nombre }}</td>
                                    <td>${{ number_format($concepto->total, 2) }}</td>
                                    <!-- Aquí puedes agregar más columnas según necesites -->
                                </tr>
                                @php
                                    $totalServicioEfectivo += $concepto->total; // Suma el total del concepto al total de servicio pagado en efectivo
                                @endphp
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </tbody>
        </table>
        <p class="total-row">TOTAL SERVICIO - EFECTIVO: <span class="total-cell">${{ number_format($totalServicioEfectivo, 2) }}</span></p>
    </div>

    <div class="separator"></div> <!-- Línea separadora -->

    <div class="category-section">
        <h2 class="category-title">Servicio - Transferencia</h2>
        <table class="tickets-table">
            <thead>
                <tr>
                    <th>Cantidad</th>
                    <th>Descripción</th>
                    <th>Pago</th>
                    <!-- Agrega más encabezados según tus necesidades -->
                </tr>
            </thead>
            <tbody>
                @php
                    $totalServicioTransferencia = 0; // Inicializa la variable para el total de servicio pagado por transferencia
                @endphp
                @foreach($tickets as $ticket)
                    @if($ticket->tipoPago->tipoPago == 'TRANSFERENCIA')
                        @foreach($ticket->concepto as $concepto)
                            @if($concepto->nombreConcepto?->categoria?->categoria == 'SERVICIO')
                                <tr>
                                    <td>{{ $concepto->cantidad }}</td>
                                    <td>{{ $concepto->nombreConcepto->nombre }}</td>
                                    <td>${{ number_format($concepto->total, 2) }}</td>
                                    <!-- Aquí puedes agregar más columnas según necesites -->
                                </tr>
                                @php
                                    $totalServicioTransferencia += $concepto->total; // Suma el total del concepto al total de servicio pagado por transferencia
                                @endphp
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </tbody>
        </table>
        <p class="total-row">TOTAL SERVICIO - TRANSFERENCIA: <span class="total-cell">${{ number_format($totalServicioTransferencia, 2) }}</span></p>
    </div>

    <div class="separator"></div> <!-- Línea separadora -->

    <div class="category-section">
        @php
            $totalFinal = $totalMercanciaEfectivo + $totalMercanciaTransferencia + $totalServicioEfectivo + $totalServicioTransferencia;
            $usuario = auth()->user()->nombre;
        @endphp
        <h2 class="category-title">Total Final</h2>
        <p class="total-row">TOTAL FINAL: <span class="total-cell">${{ number_format($totalFinal, 2) }}</span></p>
        <p class="total-row">CORTE GENERADO POR: <span class="total-cell">{{ $usuario }}</span></p>
    </div>
    
</body>
</html>
