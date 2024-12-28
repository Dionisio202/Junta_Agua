<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Mediciones</title>
    <link rel="stylesheet" href="styles/styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="table-container">
        <h1>Registro de Mediciones</h1>

        <!-- Formulario para registrar nueva medición -->
        <form id="form-medicion" class="form">
            <div class="flex-group">
                <div class="form-group form-item">
                    <label for="idmedidor">ID del Medidor</label>
                    <input type="text" name="idmedidor" id="idmedidor" class="form-control" required>
                </div>
                <div class="form-group form-item">
                    <label for="fecha_lectura">Fecha de Lectura</label>
                    <input type="date" name="fecha_lectura" id="fecha_lectura" class="form-control" required>
                </div>
                <div class="form-group form-item">
                    <label for="lectura_actual">Lectura Actual</label>
                    <input type="number" name="lectura_actual" id="lectura_actual" class="form-control" step="1" min="0" required>
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

        <!-- Filtros -->
        <h2>Filtros</h2>
        <div class="filters">
            <input type="text" id="filter-medidor" class="filter-input" placeholder="Filtrar por Nro Medidor o Cédula">
            <div class="date-filter-container">
                <label for="filter-date-from">Desde:</label>
                <input type="date" id="filter-date-from" class="filter-input">
                <label for="filter-date-to">Hasta:</label>
                <input type="date" id="filter-date-to" class="filter-input">
            </div>
            <button type="button" id="reset-filters" class="reset-btn">Quitar Filtros</button>
        </div>
        <br>
        <!-- Lista de Mediciones -->
        <h2>Lista de Mediciones</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Nro Medidor</th>
                    <th>Cédula</th>
                    <th>Fecha Lectura</th>
                    <th>Consumo (m3)</th>
                    <th>Mes Facturado</th>
                </tr>
            </thead>
            <tbody id="table-body">
                <!-- Filas dinámicas -->
            </tbody>
        </table>

        <!-- Paginación -->
        <div id="pagination" class="pagination">
            <span id="prev-page" class="page-control">Anterior</span>
            <span id="current-page">1</span>
            <span id="next-page" class="page-control">Siguiente</span>
        </div>
    </div>

<script>
// Add scripts for table and filters without affecting the existing form logic
$(document).ready(function () {
    let mediciones = [];
    let currentPage = 1;
    const itemsPerPage = 5;
    let idCliente = null; // Variable para almacenar el ID del cliente validado

// Validar el medidor al presionar Enter
$("#idmedidor").on("keydown", function (e) {
    if (e.key === "Enter") {
        e.preventDefault();
        validarMedidor($(this).val());
    }
});
    function fetchMediciones() {
        $.ajax({
            url: "/Junta_Agua/public/index.php?view=mediciones&action=obtenerMediciones",
            method: "GET",
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    mediciones = response.data;
                    updateTable();
                } else {
                    alert("Error al obtener mediciones.");
                }
            },
            error: function (xhr) {
                console.error("Error al obtener mediciones:", xhr.responseText);
            }
        });
    }
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

    function renderTable(data) {
        const tableBody = $("#table-body");
        tableBody.empty();

        data.forEach(medicion => {
            const row = `
                <tr>
                    <td>${medicion.nro_medidor || "N/A"}</td>
                    <td>${medicion.identificacion || "N/A"}</td>
                    <td>${medicion.fecha_lectura || "N/A"}</td>
                    <td>${medicion.lectura}</td>
                    <td>${medicion.fecha_lectura 
                        ? new Date(medicion.fecha_lectura).toLocaleString('es-ES', { month: 'long' }) 
                        : "N/A"}</td>
                </tr>`;
            tableBody.append(row);
        });
    }

    function applyFilters() {
        const filterValue = $("#filter-medidor").val().toLowerCase();
        const dateFrom = $("#filter-date-from").val();
        const dateTo = $("#filter-date-to").val();

        let filteredData = mediciones;

        if (filterValue) {
            filteredData = filteredData.filter(medicion =>
                medicion.nro_medidor?.toLowerCase().includes(filterValue) ||
                medicion.cedula?.toLowerCase().includes(filterValue)
            );
        }

        if (dateFrom || dateTo) {
            filteredData = filteredData.filter(medicion => {
                const fecha = new Date(medicion.fecha_lectura);
                const desde = dateFrom ? new Date(dateFrom) : null;
                const hasta = dateTo ? new Date(dateTo) : null;

                return (!desde || fecha >= desde) && (!hasta || fecha <= hasta);
            });
        }

        return filteredData;
    }

    function getPaginatedData(data) {
        const start = (currentPage - 1) * itemsPerPage;
        const end = start + itemsPerPage;
        return data.slice(start, end);
    }

    function updateTable() {
        const filteredData = applyFilters();
        const paginatedData = getPaginatedData(filteredData);
        renderTable(paginatedData);

        $("#current-page").text(currentPage);
    }

    $("#filter-medidor, #filter-date-from, #filter-date-to").on("input change", () => {
        currentPage = 1;
        updateTable();
    });

    $("#reset-filters").on("click", () => {
        $("#filter-medidor").val('');
        $("#filter-date-from").val('');
        $("#filter-date-to").val('');
        currentPage = 1;
        updateTable();
    });

    $("#prev-page").on("click", () => {
        if (currentPage > 1) {
            currentPage--;
            updateTable();
        }
    });

    $("#next-page").on("click", () => {
        const filteredData = applyFilters();
        if (currentPage < Math.ceil(filteredData.length / itemsPerPage)) {
            currentPage++;
            updateTable();
        }
    });

    fetchMediciones();
});
</script>
</body>
</html>
