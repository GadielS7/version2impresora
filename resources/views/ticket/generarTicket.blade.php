<div id="modalContainer">
    <!-- The Modal -->
    <div id="myModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">×</span> 
            <h2>Generar Ticket de Pago</h2>

            <form id="ticketForm" action="{{ route('conceptos.guardar') }}" method="post">
                @csrf
                <input type="hidden" name="recibos_id" id="recibos_id" value="">
                <div id="conceptoContainer">
                    <div class="concepto-group">
                    <label for="concepto">Concepto:</label>
                    <input type="text" name="concepto[]" id="conceptoInput" required>
                    <div id="conceptoError" style="color: red; display: none;">Solo se permiten letras, números y espacios.</div>
                        <br>
                        <div id="suggestions" style="display: none;"></div>

                        <label for="cantidad">Cantidad:</label>
                        <input type="number" name="cantidad[]" required>
                        <label for="precio_unitario">Precio Unitario:</label>
                        <input type="number" step="0.01" class="form-control" name="precio_unitario[]" id="precioInput" placeholder="Ingrese el precio unitario" oninput="this.value = this.value.replace(/[^\d,]/g, '');" required>
                        <div class="containerss">
                            <label for="total" class="total-label">Total:</label>
                            <input class="total" type="text" name="total[]" id="total" readonly>

                            <select name="categoria[]" id="categoria" class="form-control" required>
                                <option value="" disabled selected>Seleccione una Categoria por favor</option>
                                @foreach($categorias as $categoria)
                                    <option value="{{ $categoria->id }}">{{ $categoria->categoria}}</option>
                                @endforeach 
                            </select>

                        </div>
                    </div>
                </div>
                
                <button type="button" id="agregarConcepto" class="btn btn-primary">Agregar Concepto</button>
                
                <br>
                <br>
                <div class="containerss" id="totalGeneralContainer">
                    <label for="total_general" class="total-label">Total General:</label>
                    <input class="total" type="text" name="total_general" id="total_general" readonly>
                </div>

                <div class="containerss">
                    <label for="tipo_pago">Tipo de Pago:</label>
                    <select name="tipo_pago" id="tipo_pago" class="form-control" aria-describedby="tipo_pago-desc" required>
                        <option value="" selected disabled>Selecciona una opción</option>
                        @foreach($pagos as $pago)
                            <option value="{{ $pago->id }}">{{ $pago->tipoPago}}</option>
                        @endforeach 
                    </select>
                </div>
                <br>
                <button type="submit" class="btn btn-success">Generar Ticket</button>
            </form>
        </div>
    </div>
</div>
