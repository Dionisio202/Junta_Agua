<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Mediciones</title>
    <link rel="stylesheet" href="/Junta_Agua/public/styles/mediciones.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="container2">
    <h1>Registro de Mediciones</h1>

    <!-- Formulario para registrar nueva medición -->
    <form id="form-medicion">
        <div class="form-group flex-group">
            <div class="form-item">
                <label for="idmedidor">ID del Medidor</label>
                <input type="text" name="idmedidor" id="idmedidor" class="form-control" required>
            </div>
            <div class="form-item">
                <label for="fecha_lectura">Fecha de Lectura</label>
                <input type="date" name="fecha_lectura" id="fecha_lectura" class="form-control" required>
            </div>
            <div class="form-item">
                <label for="lectura_actual">Lectura Actual</label>
                <input type="number" name="lectura_actual" id="lectura_actual" class="form-control" step="0.01" required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary" id="btn-registrar" disabled>Registrar Medición</button>
    </form>

    <!-- Modal para mostrar información del cliente -->
    <div id="modal-cliente" class="modal">
        <div class="modal-content">
            <span id="close-modal" class="close-btn">&times;</span>
            <h3>Información del Cliente</h3>
            <p id="cliente-info"></p>
        </div>
    </div>
</div>


<script>
$(document).ready(function () {
    let idCliente = null; // Variable para almacenar el ID del cliente validado

    // Validar el medidor al presionar Enter
    $("#idmedidor").on("keydown", function (e) {
        if (e.key === "Enter") {
            e.preventDefault();
            validarMedidor($(this).val());
        }
    });

    function validarMedidor(idMedidor) {
        $.ajax({
            url: "/Junta_Agua/public/api/validar_medidor.php",
            method: "GET",
            data: { id_medidor: idMedidor },
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    idCliente = response.cliente.id_cliente;
                    $("#cliente-info").text(`Cliente: ${response.cliente.nombre}, Cédula: ${response.cliente.cedula}`);
                    $("#modal-cliente").show();
                    $("#btn-registrar").prop("disabled", false);
                } else {
                    idCliente = null;
                    alert(response.message);
                    $("#btn-registrar").prop("disabled", true);
                }
            },
            error: function (xhr) {
                alert("Error al validar el medidor.");
                console.error(xhr.responseText);
            }
        });
    }

  // Registrar la medición
$("#form-medicion").on("submit", function (e) {
    e.preventDefault();

    if (!idCliente) {
        alert("Debe validar el medidor antes de registrar.");
        return;
    }

    const data = {
        id_medidor: $("#idmedidor").val(),
        id_cliente: idCliente,
        fecha_lectura: $("#fecha_lectura").val(),
        lectura_actual: $("#lectura_actual").val()
    };

    $.ajax({
        url: "/Junta_Agua/public/index.php?view=mediciones&action=registrarMedicion",
        method: "POST",
        data: data,
        dataType: "json",
        success: function (response) {
            if (response.success) {
                alert(response.message);
                location.reload(); // Recarga la página
            } else {
                alert(response.message); // Mensaje de error del servidor
            }
        },
        error: function (xhr) {
    console.error("Error al registrar la medición:", xhr.responseText);

    // Intentar parsear como JSON
    try {
        const response = JSON.parse(xhr.responseText);
        alert(response.message);
    } catch (e) {
        // Si no es JSON, mostrar error genérico
        alert("Hubo un error inesperado. Revisa la consola para más detalles.");
    }
}

    });
});


    // Cerrar el modal
    $("#close-modal").on("click", function () {
        $("#modal-cliente").hide();
    });
});
</script>
</body>
</html>
