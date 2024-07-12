function buscarRecibos() {
    // Obtener el valor del campo de entrada con el id 'searchInput'
    var searchTerm = document.getElementById('searchInput').value;
    
    // Definir la URL a la que se enviará la solicitud AJAX
    var url = '/buscarRecibo'; // Utilizar la URL absoluta o relativa según corresponda
    
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


function buscarRechazado() {
    // Obtener el valor del campo de entrada con el id 'searchInput'
    var searchTerm = document.getElementById('searchInput').value;
    
    // Definir la URL a la que se enviará la solicitud AJAX
    var url = '/buscarRechazado'; // Utilizar la URL absoluta o relativa según corresponda
    
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

// Función para abrir el modal de confirmación
 // Función para abrir el modal de confirmación de reparación
 function abrirModalConfirmacion(idRecibos) {
    var modal = document.getElementById("confirmacionModal");
    modal.style.display = "block";
    document.getElementById("confirmarReparacionButton").setAttribute("data-id", idRecibos);
}

// Función para cerrar el modal de confirmación de reparación
function cerrarModalConfirmacion() {
    var modal = document.getElementById("confirmacionModal");
    modal.style.display = "none";
}

// Función para confirmar la reparación de un recibo
function confirmarReparacion() {
    var idRecibos = document.getElementById("confirmarReparacionButton").getAttribute("data-id");
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '/recibos/estado/' + idRecibos, true);
    xhr.setRequestHeader("Content-Type", "application/json");

    xhr.onload = function () {
        cerrarModalConfirmacion(); // Cerrar el modal después de la respuesta
        if (xhr.status === 200) {
            var respuesta = JSON.parse(xhr.responseText);
            localStorage.setItem('message', respuesta.message);
            localStorage.setItem('messageType', 'success');
        } else {
            var error = JSON.parse(xhr.responseText);
            localStorage.setItem('message', error.error);
            localStorage.setItem('messageType', 'error');
        }
        window.location.reload(true); // Recargar la página después del éxito o error
    };

    xhr.send();
}

//cancelar reparacion
function confirmarCancelarReparacion() {
    var idRecibo = document.getElementById("cancelarReparacion").getAttribute("data-id");
    var confirmar = confirm("¿Está seguro de cancelar la reparación de este recibo?");
    
    if (confirmar) {
        cancelarReparacion(idRecibo);
    } else {
        // Aquí puedes añadir código adicional si el usuario cancela la acción
    }
}

function cancelarReparacion(idRecibo) {
    // Realizar la solicitud AJAX para cambiar el estado del recibo
    $.ajax({
        url: '/recibos/cancelado/' + idRecibo,
        type: 'GET',
        success: function(response) {
            localStorage.setItem('message', response.message);
            localStorage.setItem('messageType', 'success');
            window.location.reload(true); // Recargar la página después del éxito
        },
        error: function(jqXHR, textStatus, errorThrown) {
            localStorage.setItem('message', 'Error al cancelar la reparación del recibo');
            localStorage.setItem('messageType', 'error');
            window.location.reload(true); // Recargar la página en caso de error
        }
    });
}

window.onload = function() {
    var message = localStorage.getItem('message');
    var messageType = localStorage.getItem('messageType');
    if (message && messageType) {
        if (messageType === 'success') {
            mostrarMensajeExito(message);
        } else if (messageType === 'error') {
            mostrarMensajeError(message);
        }
        localStorage.removeItem('message');
        localStorage.removeItem('messageType');
    }
};

function mostrarMensajeExito(message) {
    var successAlertModal = document.getElementById('success-alert-modal');
    var successMessageElement = document.getElementById('success-message');
    var successProgressBar = document.getElementById('success-progress-bar');

    successMessageElement.textContent = message;
    successAlertModal.classList.remove('hidden');
    successAlertModal.classList.add('show');

    setTimeout(function() {
        successProgressBar.style.width = '100%';
    }, 10);

    setTimeout(function() {
        successAlertModal.classList.add('hidden');
        successAlertModal.classList.remove('show');
        setTimeout(function() {
            successAlertModal.style.display = 'none';
            successProgressBar.style.width = '0%'; // Reinicia la barra de progreso
        }, 500);
    }, 3000); // Esperar 3 segundos antes de ocultar el mensaje
}

function mostrarMensajeError(message) {
    var errorAlertModal = document.getElementById('error-alert-modal');
    var errorMessageElement = document.getElementById('error-message');
    var errorProgressBar = document.getElementById('error-progress-bar');

    errorMessageElement.textContent = message;
    errorAlertModal.classList.remove('hidden');
    errorAlertModal.classList.add('show');

    setTimeout(function() {
        errorProgressBar.style.width = '100%';
    }, 10);

    setTimeout(function() {
        errorAlertModal.classList.add('hidden');
        errorAlertModal.classList.remove('show');
        setTimeout(function() {
            errorAlertModal.style.display = 'none';
            errorProgressBar.style.width = '0%'; // Reinicia la barra de progreso
        }, 2000);
    }, 3000); // Esperar 3 segundos antes de ocultar el mensaje
}