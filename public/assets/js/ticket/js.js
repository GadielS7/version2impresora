function buscarRecibos() {
    // Obtener el valor del campo de entrada con el id 'searchInput'
    var searchTerm = document.getElementById('searchInput').value;
    
    // Definir la URL a la que se enviará la solicitud AJAX
    var url = '/buscarTicket'; // Utilizar la URL absoluta o relativa según corresponda
    
    // Realizar una solicitud AJAX al servidor
    $.ajax({
        // Especificar la URL a la que se enviará la solicitud
        url: url,
        
        // Especificar el método HTTP que se utilizará para la solicitud
        type: 'GET',
        
        // Especificar los datos que se enviarán con la solicitud
        data: { search: searchTerm }, // En este caso, se envía el término de búsqueda
        
        // Manejar la respuesta exitosa de la solicitud
        success: function(response) {
            // Actualizar el contenido del elemento HTML con el id 'recibosBody'
            // con el HTML devuelto por el servidor en la propiedad 'recibosBodyHtml' de la respuesta
            $('#recibosBody').html(response.recibosBodyHtml);
            
            // Actualizar el contenido del elemento HTML con el id 'totalTiposEquipo'
            // con el texto que indica el total de tipos de equipo recibidos,
            // utilizando el valor devuelto por el servidor en la propiedad 'totalTiposEquipo' de la respuesta
           
        },
        
        // Manejar cualquier error que ocurra durante la solicitud
        error: function(jqXHR, textStatus, errorThrown) {
            // Imprimir un mensaje de error en la consola con los detalles del error
            console.log('Error en la conexión con el controlador:', textStatus, errorThrown);
        }
    });
}

//validar entrada de datos de concepto
var conceptoInput = document.getElementById('conceptoInput');
var conceptoError = document.getElementById('conceptoError');

conceptoInput.addEventListener('keydown', function(event) {
    // Obtener el código ASCII de la tecla presionada
    var key = event.key;
    var isAllowed = /^[A-Za-z0-9 ]$/.test(key) || event.code === 'Space';

    // Permitir teclas de navegación y eliminación (Backspace, Delete, flechas)
    if (event.code.includes('Arrow') || event.code === 'Backspace' || event.code === 'Delete') {
        isAllowed = true;
    }

    // Mostrar o ocultar mensaje de error según la validez del carácter ingresado
    if (!isAllowed) {
        conceptoError.style.display = 'block';
        event.preventDefault(); // Evitar que el carácter no permitido se escriba
    } else {
        conceptoError.style.display = 'none';
    }
});

// Validar también al pegar texto usando el evento input
conceptoInput.addEventListener('input', function() {
    var valor = this.value.trim(); // Obtener el valor del input y eliminar espacios al inicio y final

    // Verificar si el valor cumple con el patrón permitido
    if (/^[A-Za-z0-9 ]*$/.test(valor)) {
        conceptoError.style.display = 'none'; // Ocultar mensaje de error si es válido
    } else {
        conceptoError.style.display = 'block'; // Mostrar mensaje de error si hay caracteres no permitidos
    }
});
// Función para buscar conceptos y mostrar sugerencias
function buscarConceptoInput(query, container) {
    if (query.length >= 3) {
        fetch('/buscarConcepto?query=' + query)
            .then(response => response.json())
            .then(data => {
                displaySuggestions(data, container);
            })
            .catch(error => {
                console.error('Error al buscar conceptos:', error);
            });
    } else {
        container.innerHTML = ''; // Limpiar el contenedor de sugerencias si la búsqueda es corta
        container.style.display = 'none';
    }
}

// Evento para buscar conceptos al escribir en el input
document.getElementById('conceptoInput').addEventListener('input', function() {
    var query = this.value.trim(); // Capturar el valor del input y limpiar espacios en blanco
    var suggestionsContainer = document.getElementById('suggestions');
    buscarConceptoInput(query, suggestionsContainer); // Llamar a la función con el valor capturado y el contenedor
});

// Función para mostrar sugerencias en el contenedor especificado
function displaySuggestions(suggestions, container) {
    // Crear un fragmento de HTML para todas las sugerencias
    var suggestionHtml = '';
    if (suggestions.length > 0) {
        suggestions.forEach(suggestion => {
            suggestionHtml += '<input type="checkbox" name="conceptoSugerido" value="' + suggestion.id + '"> ' + suggestion.nombre + ' - $' + suggestion.precio + ' - ' + suggestion.id_categoria + '<br>';
        });
        container.innerHTML = suggestionHtml; // Agregar todas las sugerencias al contenedor
        container.style.display = 'block'; // Mostrar el contenedor de sugerencias
    } else {
        container.innerHTML = ''; // Limpiar el contenedor si no hay sugerencias
        container.style.display = 'none'; // Ocultar el contenedor si no hay sugerencias
    }
}

// Evento para manejar la selección de sugerencias
document.getElementById('suggestions').addEventListener('change', function(event) {
    if (event.target.type === 'checkbox' && event.target.name === 'conceptoSugerido') {
        if (event.target.checked) {
            var nombre = event.target.nextSibling.textContent.trim().split(' - ')[0];
            var precio = event.target.nextSibling.textContent.trim().split(' - ')[1].replace('$', ''); // Eliminar el símbolo de $

            var categoria = event.target.nextSibling.textContent.trim().split(' - ')[2];

            var conceptoInput = document.getElementById('conceptoInput');
            conceptoInput.value = nombre;

            var precioInput = document.getElementById('precioInput');
            precioInput.value = precio;

            var categoriaInput = document.getElementById('categoria');
            categoriaInput.value = categoria;
            
            // Limpiar el contenedor de sugerencias después de seleccionar una sugerencia
            this.innerHTML = '';
            this.style.display = 'none';
        }
    }
});


/////////////////////////////////////////////////////////////////

function confirmarGenerarTicket(idRecibos) {
    if (confirm('¿Estás seguro de generar el ticket?')) {
        // Si el usuario confirma, abre la modal
        document.getElementById('myModal').style.display = 'block';
        document.getElementById('recibos_id').value = idRecibos; // Establecer el valor del campo tipo_equipos_id
    } else {
        // Si el usuario cancela, no hagas nada
        alert("Se canceló la generación del ticket.");
    }
}

// Función para restablecer el contenido de la modal
function resetearModal() {
    // Restablecer el valor del campo tipo_equipos_id
    document.getElementById('recibos_id').value = '';
    
    // Limpiar el contenido de los campos de entrada del concepto
    var conceptoInputs = document.querySelectorAll('input[name="concepto[]"]');
    conceptoInputs.forEach(function(input) {
        input.value = '';
    });
    
    var cantidadInputs = document.querySelectorAll('input[name="cantidad[]"]');
    cantidadInputs.forEach(function(input) {
        input.value = '';
    });
    
    var precioInputs = document.querySelectorAll('input[name="precio_unitario[]"]');
    precioInputs.forEach(function(input) {
        input.value = '';
    });

    var categoriaInputs = document.querySelectorAll('select[name="categoria[]"]');
    categoriaInputs.forEach(function(input) {
        input.value = '';
    });

    
    var suggestionsContainer = document.getElementById('suggestions');
    suggestionsContainer.innerHTML = '';
    suggestionsContainer.style.display = 'none';
    
    var totalInputs = document.querySelectorAll('input[name="total[]"]');
    totalInputs.forEach(function(input) {
        input.value = '';
    });
    
    // Restablecer el total general
    document.getElementById('total_general').value = '$0.00';
}

// Cuando el usuario haga clic en el botón de cerrar (x), cierra la modal y restablece su contenido
document.getElementsByClassName('close')[0].addEventListener('click', function() {
    document.getElementById('myModal').style.display = 'none';
    resetearModal(); // Restablecer el contenido de la modal
});

// Cuando el usuario haga clic fuera del modal, cierra la modal y restablece su contenido
/*window.addEventListener('click', function(event) {
    if (event.target == document.getElementById('myModal')) {
        document.getElementById('myModal').style.display = 'none';
        resetearModal(); // Restablecer el contenido de la modal
    }
});
*/
//aceptar puros numero en precio unitario
document.getElementById('precioInput').addEventListener('input', function(event) {
    this.value = this.value.replace(/\D/g, '');});
// Función para convertir el texto a mayúsculas
function convertirAMayusculas(event) {
    // Verificar si el elemento es un campo de entrada de texto
    if (event.target.nodeName === 'INPUT' && event.target.type === 'text') {
        // Convertir el valor del campo a mayúsculas y asignarlo de nuevo
        event.target.value = event.target.value.toUpperCase();
    }
}

// Agregar un evento de escucha para el evento 'input' en todo el documento
document.addEventListener('input', convertirAMayusculas);

// Función para agregar un nuevo concepto al ticket
document.addEventListener('DOMContentLoaded', function() {
    var conceptoContainer = document.getElementById('conceptoContainer');
    var agregarConceptoBtn = document.getElementById('agregarConcepto');
    var totalGeneralInput = document.getElementById('total_general');

    agregarConceptoBtn.addEventListener('click', function() {
        // Clonar el primer grupo de concepto y añadirlo al contenedor
        var newConceptoGroup = conceptoContainer.firstElementChild.cloneNode(true);
        conceptoContainer.appendChild(newConceptoGroup);

        // Limpiar los valores de los campos de entrada del nuevo grupo de concepto
        var newConceptoInput = newConceptoGroup.querySelector('input[name="concepto[]"]');
        var newCantidadInput = newConceptoGroup.querySelector('input[name="cantidad[]"]');
        var newPrecioInput = newConceptoGroup.querySelector('input[name="precio_unitario[]"]');
        var newTotalInput = newConceptoGroup.querySelector('input[name="total[]"]');
        var newCategoriaInput = newConceptoGroup.querySelector('select[name="categoria[]"]');

        newConceptoInput.value = '';
        newCantidadInput.value = '';
        newPrecioInput.value = '';
        newTotalInput.value = '';
        newCategoriaInput.value = '';

        // Agregar un botón para eliminar este concepto
        var deleteButton = document.createElement('button');
        deleteButton.textContent = 'Eliminar Concepto';
        deleteButton.className = 'eliminar-concepto btn btn-danger'; // Agregar clases Bootstrap
        newConceptoGroup.appendChild(deleteButton);

        // Recalcular el total general cuando se agrega un nuevo concepto
        calcularTotalGeneral();

        // Obtener el nuevo input de concepto y su contenedor de sugerencias
        var newConceptoInputField = newConceptoGroup.querySelector('input[name="concepto[]"]');
        var suggestionsContainer = newConceptoGroup.querySelector('#suggestions');

        // Agregar evento 'input' al nuevo input de concepto para buscar sugerencias
        newConceptoInput.addEventListener('input', function() {
            var query = this.value.trim(); // Capturar el valor del input y limpiar espacios en blanco
            buscarConceptoInput(query, suggestionsContainer); // Llamar a la función con el valor capturado y el contenedor
        });

        // Evento para manejar la selección de sugerencias en el nuevo grupo de concepto
        suggestionsContainer.addEventListener('change', function(event) {
            if (event.target.type === 'checkbox' && event.target.name === 'conceptoSugerido') {
                if (event.target.checked) {
                    var nombre = event.target.nextSibling.textContent.trim().split(' - ')[0];
                    var precio = event.target.nextSibling.textContent.trim().split(' - ')[1].replace('$', ''); // Eliminar el símbolo de $
                    var categoria = event.target.nextSibling.textContent.trim().split(' - ')[2];

                    var conceptoInput = newConceptoGroup.querySelector('input[name="concepto[]"]');
                    conceptoInput.value = nombre;

                    var precioInput = newConceptoGroup.querySelector('input[name="precio_unitario[]"]');
                    precioInput.value = precio;

                    var categoriaInput = newConceptoGroup.querySelector('select[name="categoria[]"]');
                    categoriaInput.value = categoria;
                    
                    // Limpiar el contenedor de sugerencias después de seleccionar una sugerencia
                    suggestionsContainer.innerHTML = '';
                    suggestionsContainer.style.display = 'none';
                }
            }
        });

    });

    // Resto del código...

    // Función para calcular el total
    function calcularTotal() {
        var cantidadInputs = document.querySelectorAll('input[name="cantidad[]"]');
        var precioInputs = document.querySelectorAll('input[name="precio_unitario[]"]');
        var totalInputs = document.querySelectorAll('input[name="total[]"]');

        cantidadInputs.forEach(function(cantidadInput, index) {
            var cantidad = parseFloat(cantidadInput.value);
            var precioUnitario = parseFloat(precioInputs[index].value);
            var total = cantidad * precioUnitario;
            totalInputs[index].value = '$' + total.toFixed(2); // Limitar a dos decimales
        });
    }

    // Función para calcular el total general
    function calcularTotalGeneral() {
        var totalGeneral = 0;
        var totalInputs = document.querySelectorAll('input[name="total[]"]');
        
        totalInputs.forEach(function(totalInput) {
            var totalValue = parseFloat(totalInput.value.replace('$', ''));
            if (!isNaN(totalValue)) {
                totalGeneral += totalValue;
            }
        });
        
        // Mostrar el total general en el modal
        totalGeneralInput.value = '$' + totalGeneral.toFixed(2);
    }

    // Calcular el total cuando se cambie la cantidad o el precio
    document.getElementById('ticketForm').addEventListener('input', function() {
        calcularTotal();
        calcularTotalGeneral();
    });

    // Agregar un listener de eventos para eliminar el concepto
    conceptoContainer.addEventListener('click', function(event) {
        if (event.target.classList.contains('eliminar-concepto')) {
            event.target.parentElement.remove(); // Eliminar el grupo de concepto
            calcularTotal(); // Recalcular el total después de eliminar
            calcularTotalGeneral(); // Recalcular el total general después de eliminar
        }
    });
});
