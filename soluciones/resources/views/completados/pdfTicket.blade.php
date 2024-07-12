<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{public_path('assets/css/pdfTicket/css.css')}}" type="text/css">
    <title>TICKET</title>
   
</head>
<body>
    <div class="ticket">
        <div class="header">
            <p>Soluciones PC</p>
            <p>RFC: ZARE881013I12</p>
            <p>Tel. 6161651227</P>   

        
        </div>
         
        <div class="fecha">
                 <p><strong>Fecha: </strong>{{ date('d/m/Y', strtotime($ticket->fecha)) }}</p>
            </div>

        <div class="info">
        <p><strong>Cliente: </strong>{{ $ticket->recibo->tipoEquipo[0]->cliente->nombre}}</p>
        <p><strong>Colonia: </strong>
            @if($ticket->recibo->tipoEquipo[0]->cliente->colonia)
                {{ $ticket->recibo->tipoEquipo[0]->cliente->colonia->colonia}}
            @else
                
            @endif
        </p>
        </div>
        
        <table class="ticket-table">
            <tr>
                <th class="cantidad-column">Cant.</th>
                <th class="concepto-column">Concepto</th>
                <th class="precio-column">Precio</th>
                <th class="total-column">Total</th>
            </tr>
            @foreach ($conceptos as $concepto)
            <tr>
                <td class="cantidad-column">{{ $concepto->cantidad }}</td>
                <td class="concepto-column">{{ $concepto->nombreConcepto->nombre }}</td>
                <td class="precio-column">${{ number_format($concepto->nombreConcepto->precio, 2) }}</td>
                <td class="total-column">${{ number_format($concepto->total, 2) }}</td>
                <!-- Otras columnas del concepto -->
            </tr>
            @endforeach
        </table>
 
        <div class="total">
            <p><strong>Total</strong>: ${{ number_format($ticket->total, 2) }}</p>
        </div>

        <div class="Pago">
            <p><strong>Pago</strong>: {{ $ticket->tipoPago->tipoPago}}</p>
        </div>

        <div class="caja">
          <p><strong>Cobrado Por: </strong>: {{ $ticket->usuario}}</p>
        </div>
    </div>
</body>
</html>
