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