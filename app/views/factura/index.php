<div class="user-info">
    <span class="user-role"><?= htmlspecialchars($rol); ?></span> 
    <span class="user-name"><?= htmlspecialchars($_SESSION['Nombre'] ?? 'Usuario'); ?></span>
    <span class="user-apellido"><?= htmlspecialchars($_SESSION['Apellido'] ??'Sin apellido'); ?></span>
    <span class="user-id"><?= htmlspecialchars($_SESSION['idUser'] ?? 'Sin ID'); ?></span> 
</div>

<div class="table-container">
    <div class="header-buttons">
        <h1>Facturación <?= $rol === 'Tesorero' ? 'TESORERÍA' : ''; ?></h1>
    </div>
    <div class="buttons">
        <button class="export-btn">Exportar datos</button>
        <?php if ($rol === 'administrador'): ?>
            <button type="button" class="add-btn" onclick="window.location.href='/Junta_Agua/public/?view=factura/nuevafactura'">Agregar nueva Factura</button>
        <?php endif; ?>
    </div>

    <table>
        <tr>
            <th>Nombre</th>
            <th>Cédula</th>
            <th>Teléfono</th>
            <th>Detalle Factura</th>
            <?php if ($rol === 'administrador'): ?>
                <th>Acciones</th>
            <?php endif; ?>
        </tr>
        
        <?php if (!empty($currentFacturas)): ?>
            <?php foreach ($currentFacturas as $factura): ?>
    <tr class="clickable-row" data-href="?view=factura/nuevafactura&id=<?= $factura['idfactura'] ?>">
        <td><?= htmlspecialchars($factura['nombre']) ?></td>
        <td><?= htmlspecialchars($factura['cedula']) ?></td>
        <td><?= htmlspecialchars($factura['telefono']) ?></td>
        <td><?= htmlspecialchars($factura['detalle']) ?></td>
        <?php if ($rol === 'administrador'): ?>
            <td>
                <a href="?view=factura/edit&id=<?= $factura['idfactura'] ?>">✏️</a>
                <a href="?view=factura/index&action=delete&id=<?= $factura['idfactura'] ?>" onclick="return confirm('¿Estás seguro de eliminar esta factura?')">🗑️</a>
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
