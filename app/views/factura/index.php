<div class="user-info">
    <span class="user-role"><?= htmlspecialchars($rol); ?></span> 
    <span class="user-name"><?= htmlspecialchars($_SESSION['nombre'] ?? 'Usuario'); ?></span> 
</div>

<div class="table-container">
    <div class="header-buttons">
        <h1>Facturación <?= $rol === 'Tesorero' ? 'TESORERÍA' : ''; ?></h1>
    </div>
    <div class="buttons">
        <button class="export-btn">Exportar datos</button>
        <?php if ($rol === 'Administrador'): ?>
            <button type="button" class="add-btn" onclick="window.location.href='/Junta_Agua/public/?view=factura/index&action=add';">Agregar nueva Factura</button>
        <?php endif; ?>
    </div>

    <table>
        <tr>
            <th>Nombre</th>
            <th>Cédula</th>
            <th>Teléfono 1</th>
            <th>Teléfono 2</th>
            <th>Nro. medidor</th>
            <th>Detalle Factura</th>
            <?php if ($rol === 'Administrador'): ?>
                <th>Acciones</th>
            <?php endif; ?>
        </tr>
        
        <?php if (!empty($currentFacturas)): ?>
            <?php foreach ($currentFacturas as $factura): ?>
    <tr class="clickable-row" data-href="?view=factura/nuevafactura&id=<?= $factura['id'] ?>">
        <td><?= htmlspecialchars($factura['nombre_comercial']) ?></td>
        <td><?= htmlspecialchars($factura['identificacion']) ?></td>
        <td><?= htmlspecialchars($factura['telefono1']) ?></td>
        <td><?= htmlspecialchars($factura['telefono2']) ?></td>
        <td><?= htmlspecialchars($factura['nro_medidor']) ?></td>
        <td><?= htmlspecialchars($factura['detalle']) ?></td>
        <?php if ($rol === 'Administrador'): ?>
            <td>
                <a href="?view=factura/edit&id=<?= $factura['id'] ?>">✏️</a>
                <a href="?view=factura/index&action=delete&id=<?= $factura['id'] ?>" onclick="return confirm('¿Estás seguro de eliminar esta factura?')">🗑️</a>
            </td>
        <?php endif; ?>
    </tr>
<?php endforeach; ?>

        <?php else: ?>
            <tr>
                <td colspan="5">No hay facturas disponibles.</td>
            </tr>
        <?php endif; ?>
    </table>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const rows = document.querySelectorAll(".clickable-row");
        rows.forEach(row => {
            row.addEventListener("click", function() {
                window.location.href = this.dataset.href;
            });
        });
    });
</script>

    <!-- Paginación -->
    <div class="pagination">
        <span id="prev-page" class="page-arrow">
            <a href="?view=factura/index&page=<?= max(1, $currentPage - 1); ?>">&lt;</a>
        </span>
        
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <span class="page-number <?= $i === $currentPage ? 'active' : ''; ?>">
                <a href="?view=factura/index&page=<?= $i; ?>"><?= $i; ?></a>
            </span>
        <?php endfor; ?>
        
        <span id="next-page" class="page-arrow">
            <a href="?view=factura/index&page=<?= min($totalPages, $currentPage + 1); ?>">&gt;</a>
        </span>
    </div>
</div>
