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
        <?php if ($rol === 'Contador'): ?>
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
            <?php if ($rol === 'Contador'): ?>
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
                    <?php if ($rol === 'Contador'): ?>
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
    const rows = document.querySelectorAll(".clickable-row");
    const userRole = "<?= $rol ?>"; // Pasar el rol desde PHP a JavaScript

    rows.forEach(row => {
        if (userRole === "Presidente") {
            // Si el rol es Presidente, desactiva el clic en las filas
            row.style.pointerEvents = "none"; // Desactiva los eventos de clic
            row.style.opacity = "0.6"; // Cambia la opacidad para indicar que está desactivado
            row.style.cursor = "not-allowed"; // Cambia el cursor al pasar sobre la fila
        } else {
            // Si no es Presidente, habilita el clic
            row.addEventListener("click", function () {
                const href = this.getAttribute("data-href");
                if (href) {
                    window.location.href = href;
                }
            });
        }
    });

    // Filtro de búsqueda
    const filterInput = document.getElementById("filter-input");
    const table = document.getElementById("factura-table");
    const rowsArray = table.getElementsByTagName("tr");

    filterInput.addEventListener("input", function () {
        const filterValue = this.value.toLowerCase();
        for (let i = 1; i < rowsArray.length; i++) {
            const nombreCell = rowsArray[i].getElementsByTagName("td")[0];
            const idMedidorCell = rowsArray[i].getElementsByTagName("td")[2];
            if (nombreCell && idMedidorCell) {
                const nombreText = nombreCell.textContent.toLowerCase();
                const idMedidorText = idMedidorCell.textContent.toLowerCase();
                if (nombreText.includes(filterValue) || idMedidorText.includes(filterValue)) {
                    rowsArray[i].style.display = "";
                } else {
                    rowsArray[i].style.display = "none";
                }
            }
        }
    });
});
</script>
