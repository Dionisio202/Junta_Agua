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
        <th>Nombre Comercial</th>
        <th>Cédula</th>
        <th>Nro. Medidor</th>
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





<style>
        .filter-input {
            width: 100%;
            max-width: 300px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .add-btn {
            padding: 10px 15px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .add-btn:hover {
            background-color: #0056b3;
        }

        .disabled-action {
            pointer-events: none; /* Deshabilita los clics */
            opacity: 0.5; /* Hace que se vean desactivados */
            cursor: not-allowed; /* Cambia el cursor a una señal de prohibido */
        }

        .buttons {
            margin-bottom: 15px; /* Separación entre botones y tabla */
        }
    </style>
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
