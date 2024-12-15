<link rel="stylesheet" href="styles/styles.css">

<div class="user-info">
    <span class="user-role"><?= htmlspecialchars($rol); ?></span>
    <span class="user-name"><?= htmlspecialchars($nombre ?? 'Usuario'); ?></span>
</div>

<div class="table-container">
    <div class="header-buttons">
        <h1>Facturación <?= $rol === 'Tesorero' ? 'TESORERÍA' : ''; ?></h1>
    </div>
    <div class="buttons" style="display: flex; align-items: center; gap: 15px;">
        <input
            type="text"
            id="filter-input"
            placeholder="Filtrar por cédula o número de medidor"
            class="filter-input"
        >
        <input
            type="date"
            id="filter-date"
            placeholder="Filtrar por fecha de emisión"
            class="filter-input"
        >
        <?php if ($rol === 'Contador'): ?>
            <button type="button" class="add-btn" onclick="window.location.href='/Junta_Agua/public/?view=factura/nuevafactura'">Agregar nueva Factura</button>
        <?php endif; ?>
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
                <tr class="clickable-row" data-href="?view=factura/nuevafactura&id=${factura.id}">
                    <td>${factura.nombre_comercial}</td>
                    <td>${factura.identificacion}</td>
                    <td>${factura.nro_medidor}</td>
                    <td>${factura.fecha_emision}</td>
                    <td>${factura.total}</td>
                    <td>${factura.estado_factura}</td>
                    ${userRole === "Contador" ? `
                    <td>
                        <a class="disabled-action" href="?view=factura/edit&id=${factura.id}">✏️</a>
                        <a class="disabled-action" href="?view=factura/index&action=delete&id=${factura.id}" onclick="return confirm('¿Estás seguro de eliminar esta factura?')">🗑️</a>
                    </td>` : ""}
                </tr>`;
            tableBody.innerHTML += row;
        });

        setupClickableRows();
    }

    // Función para obtener datos paginados
    function getPaginatedData(data) {
        const start = (currentPage - 1) * itemsPerPage;
        const end = start + itemsPerPage;
        return data.slice(start, end);
    }

    // Configurar clics en filas
    function setupClickableRows() {
        const rows = document.querySelectorAll(".clickable-row");
        rows.forEach(row => {
            if (userRole === "Presidente") {
                row.style.pointerEvents = "none";
                row.style.opacity = "0.6";
                row.style.cursor = "not-allowed";
            } else {
                row.addEventListener("click", function () {
                    const href = this.getAttribute("data-href");
                    if (href) {
                        window.location.href = href;
                    }
                });
            }
        });
    }

    // Función para aplicar filtros
    function applyFilters() {
        const filterValue = document.getElementById("filter-input").value.toLowerCase();
        const filterDate = document.getElementById("filter-date").value;

        let filteredData = facturas;

        if (filterValue) {
            filteredData = filteredData.filter(factura =>
                factura.identificacion.toLowerCase().includes(filterValue) ||
                factura.nro_medidor.toLowerCase().includes(filterValue)
            );
        }

        if (filterDate) {
            filteredData = filteredData.filter(factura => factura.fecha_emision === filterDate);
        }

        return filteredData;
    }

    // Event listeners para filtros y paginación
    document.getElementById("filter-input").addEventListener("input", () => {
        currentPage = 1;
        updateTable();
    });

    document.getElementById("filter-date").addEventListener("change", () => {
        currentPage = 1;
        updateTable();
    });

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

    // Actualizar tabla
    function updateTable() {
        const filteredData = applyFilters();
        const paginatedData = getPaginatedData(filteredData);
        renderTable(paginatedData);

        document.getElementById("current-page").textContent = currentPage;
    }

    // Renderizar la primera página al cargar
    updateTable();
});
</script>
