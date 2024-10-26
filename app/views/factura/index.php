<div class="table-container">
    <h1>Facturación <?= $rol === 'Tesorero' ? 'TESORERÍA' : ''; ?></h1>
    <button class="export-btn">Exportar datos</button>
    <?php if ($rol === 'Administrador'): ?>
        <button class="add-btn">Agregar nueva Factura</button>
    <?php endif; ?>

    <table>
        <tr>
            <th>Nombre</th>
            <th>Cédula</th>
            <th>Teléfono</th>
            <th>Detalle Factura</th>
            <?php if ($rol === 'Administrador'): ?>
                <th>Acciones</th>
            <?php endif; ?>
        </tr>
        
        <?php if (!empty($currentFacturas)): ?>
            <?php foreach ($currentFacturas as $factura): ?>
                <tr>
                    <td><?= htmlspecialchars($factura['nombre']) ?></td>
                    <td><?= htmlspecialchars($factura['cedula']) ?></td>
                    <td><?= htmlspecialchars($factura['telefono']) ?></td>
                    <td><?= htmlspecialchars($factura['detalle']) ?></td>
                    <?php if ($rol === 'Administrador'): ?>
                        <td>
                            <a href="/app/controllers/FacturaController.php?action=edit&id=<?= $factura['id'] ?>">✏️</a>
                            <a href="/app/controllers/FacturaController.php?action=delete&id=<?= $factura['id'] ?>">🗑️</a>
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