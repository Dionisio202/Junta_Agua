<link rel="stylesheet" href="app/public/styles/styles.css">

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
        <?php if ($rol === 'administrador'): ?>
            <button type="button" class="add-btn" onclick="window.location.href='/Junta_Agua/public/?view=factura/nuevafactura'">Agregar nueva Factura</button>
        <?php endif; ?>
    </div>
    <table id="factura-table">
        <tr>
            <th>Nombre Comercial</th>
            <th>Cédula</th>
            <th>Concepto</th>
            <th>Fecha Emisión</th>
            <th>Total</th>
            <th>Estado</th>
            <?php if ($rol === 'Administrador'): ?>
                <th>Acciones</th>
            <?php endif; ?>
        </tr>

        <?php if (!empty($currentFacturas)): ?>
            <?php foreach ($currentFacturas as $factura): ?>
                <tr class="clickable-row" data-href="?view=factura/nuevafactura&id=<?= $factura['id'] ?>">
                    <td><?= htmlspecialchars($factura['nombre_comercial']) ?></td>
                    <td><?= htmlspecialchars($factura['identificacion']) ?></td>
                    <td><?= htmlspecialchars($factura['nro_medidor']) ?></td>
                    <td><?= htmlspecialchars($factura['fecha_emision']) ?></td>
                    <td><?= htmlspecialchars($factura['total']) ?></td>
                    <td><?= htmlspecialchars($factura['estado_factura']) ?></td>
                    <?php if ($rol === 'Administrador'): ?>
                        <td>
                            <a class="disabled-action" href="?view=factura/edit&id=<?= $factura['id'] ?>">✏️</a>
                            <a class="disabled-action" href="?view=factura/index&action=delete&id=<?= $factura['id'] ?>" onclick="return confirm('¿Estás seguro de eliminar esta factura?')">🗑️</a>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7">No hay facturas disponibles.</td>
            </tr>
        <?php endif; ?>
    </table>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // Selecciona todas las filas que tienen la clase 'clickable-row'
    const rows = document.querySelectorAll(".clickable-row");

    rows.forEach(row => {
        row.addEventListener("click", function () {
            const href = this.getAttribute("data-href"); // Obtén el valor de 'data-href'
            if (href) {
                console.log("Redirigiendo a:", href); // Depuración opcional
                window.location.href = href; // Redirige a la URL especificada
            }
        });
    });

    // Filtro de búsqueda
    const filterInput = document.getElementById("filter-input"); // Campo de texto para filtrar
    const table = document.getElementById("factura-table"); // Tabla de facturas
    const rowsArray = table.getElementsByTagName("tr"); // Filas de la tabla

    filterInput.addEventListener("input", function () {
        const filterValue = this.value.toLowerCase(); // Texto ingresado, convertido a minúsculas

        for (let i = 1; i < rowsArray.length; i++) { // Itera desde la fila 1 (ignora encabezado)
            const nombreCell = rowsArray[i].getElementsByTagName("td")[0]; // Celda de nombre comercial
            const idMedidorCell = rowsArray[i].getElementsByTagName("td")[2]; // Celda de ID de medidor

            if (nombreCell && idMedidorCell) {
                const nombreText = nombreCell.textContent.toLowerCase();
                const idMedidorText = idMedidorCell.textContent.toLowerCase();

                // Comprueba si el texto ingresado coincide con el nombre comercial o número de medidor
                if (nombreText.includes(filterValue) || idMedidorText.includes(filterValue)) {
                    rowsArray[i].style.display = ""; // Muestra la fila si coincide
                } else {
                    rowsArray[i].style.display = "none"; // Oculta la fila si no coincide
                }
            }
        }
    });
});
</script>
