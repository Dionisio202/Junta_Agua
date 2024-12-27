<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facturación</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
    <div class="user-info">
        <span class="user-role"><?= htmlspecialchars($rol); ?></span>
        <span class="user-name"><?= htmlspecialchars($nombre ?? 'Usuario'); ?></span>
    </div>

    <div class="table-container">
        <h1>Facturación <?= $rol === 'Tesorero' ? 'TESORERÍA' : ''; ?></h1>
        <div class="buttons" style="display: flex; flex-direction: column; gap: 15px;">
            <div style="display: flex; align-items: center; gap: 15px;">
                <input
                    type="text"
                    id="filter-input"
                    placeholder="Filtrar por cédula o número de medidor"
                    class="filter-input"
                >
                <button type="button" id="reset-filters" class="reset-btn">Quitar Filtros</button>
                <?php if ($rol === 'Contador'): ?>
                    <button type="button" class="add-btn" onclick="window.location.href='/Junta_Agua/public/?view=factura/nuevafactura'">Agregar nueva Factura</button>
                <?php endif; ?>
        </div>
        <div class="date-filter-container">
            <label for="filter-date-from">Desde:</label>
            <input
                type="date"
                id="filter-date-from"
                class="filter-input"
            >
            <label for="filter-date-to">Hasta:</label>
            <input
                type="date"
                id="filter-date-to"
                class="filter-input"
            >
        </div>
    </div>

        <table id="factura-table">
            <thead>
                <tr>
                    <th>Nombre Comercial</th>
                    <th>Cédula</th>
                    <th>Concepto</th>
                    <th>Fecha Emisión</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <?php if ($rol === 'Contador'): ?>
                        <th>Acciones</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody id="table-body">
                <!-- Filas dinámicamente generadas -->
            </tbody>
        </table>

        <div class="pagination">
            <button id="prev-page">Anterior</button>
            <span id="current-page">1</span>
            <button id="next-page">Siguiente</button>
        </div>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const userRole = "<?= $rol ?>"; // Pasar el rol desde PHP a JavaScript
        const facturas = <?= json_encode($currentFacturas); ?>; // Datos desde PHP

        let currentPage = 1;
        const itemsPerPage = 10;

        // Función para renderizar la tabla
        function renderTable(data) {
            const tableBody = document.getElementById("table-body");
            tableBody.innerHTML = "";

            data.forEach(factura => {
                const row = `
                    <tr class="clickable-row" data-href="?view=factura/viewfactura&id=${factura.id}">
                        <td>${factura.nombre_comercial}</td>
                        <td>${factura.identificacion}</td>
                        <td>${factura.nro_medidor}</td>
                        <td>${factura.fecha_emision}</td>
                        <td>${factura.total}</td>
                        <td>${factura.estado_factura}</td>
                        ${userRole === "Contador" ? `
                        <td>
                           
                        </td>` : ""}
                    </tr>`;
                tableBody.innerHTML += row;
            });

            setupClickableRows();
        }

        // Configurar clics en filas
        function setupClickableRows() {
            const rows = document.querySelectorAll(".clickable-row");
            rows.forEach(row => {
                row.addEventListener("click", function () {
                    const href = this.getAttribute("data-href");
                    if (href) {
                        window.location.href = href;
                    }
                });
            });
        }

        // Aplicar filtros
        function applyFilters() {
            const filterValue = document.getElementById("filter-input").value.toLowerCase();
            const dateFrom = document.getElementById("filter-date-from").value;
            const dateTo = document.getElementById("filter-date-to").value;

            let filteredData = facturas;

            // Filtrar por número de documento
            if (filterValue) {
                filteredData = filteredData.filter(factura =>
                    factura.identificacion.toLowerCase().includes(filterValue) ||
                    factura.nro_medidor.toLowerCase().includes(filterValue)
                );
            }

            // Filtrar por rango de fechas
            if (dateFrom || dateTo) {
                filteredData = filteredData.filter(factura => {
                    const fecha = new Date(factura.fecha_emision);
                    const desde = dateFrom ? new Date(dateFrom) : null;
                    const hasta = dateTo ? new Date(dateTo) : null;

                    return (!desde || fecha >= desde) && (!hasta || fecha <= hasta);
                });
            }

            return filteredData;
        }

        // Obtener datos paginados
        function getPaginatedData(data) {
            const start = (currentPage - 1) * itemsPerPage;
            const end = start + itemsPerPage;
            return data.slice(start, end);
        }

        // Actualizar la tabla
        function updateTable() {
            const filteredData = applyFilters();
            const paginatedData = getPaginatedData(filteredData);
            renderTable(paginatedData);

            document.getElementById("current-page").textContent = currentPage;
        }

        // Eventos de filtros
        document.getElementById("filter-input").addEventListener("input", () => {
            currentPage = 1;
            updateTable();
        });

        document.getElementById("filter-date-from").addEventListener("change", () => {
            currentPage = 1;
            updateTable();
        });

        document.getElementById("filter-date-to").addEventListener("change", () => {
            currentPage = 1;
            updateTable();
        });

        // Botón para quitar filtros
        document.getElementById("reset-filters").addEventListener("click", () => {
            document.getElementById("filter-input").value = '';
            document.getElementById("filter-date-from").value = '';
            document.getElementById("filter-date-to").value = '';
            currentPage = 1;
            updateTable();
        });

        // Eventos de paginación
        document.getElementById("prev-page").addEventListener("click", () => {
            if (currentPage > 1) {
                currentPage--;
                updateTable();
            }
        });

        document.getElementById("next-page").addEventListener("click", () => {
            const filteredData = applyFilters();
            if (currentPage < Math.ceil(filteredData.length / itemsPerPage)) {
                currentPage++;
                updateTable();
            }
        });

        // Renderizar la primera página al cargar
        updateTable();
    });
    </script>
</body>
</html>
