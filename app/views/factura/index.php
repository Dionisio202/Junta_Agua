<div class="user-info">
    <span class="user-role"><?= htmlspecialchars($rol); ?></span>
    <span class="user-name"><?= htmlspecialchars($_SESSION['nombre'] ?? 'Usuario'); ?></span>
</div>

<div class="table-container">
    <div class="header-buttons">
        <h1>Facturación <?= $rol === 'Tesorero' ? 'TESORERÍA' : ''; ?></h1>
    </div>

    <!-- Integración de la nueva sección con campos de formulario -->
    <div class="seccion-factura">
    <form>
        <div class="pestana-mantenimiento">
            <h2>Mantenimiento</h2>

            <label for="fecha-emision">Emisión:</label>
            <input type="date" id="fecha-emision" value="2024-10-28">

            <label for="fecha-vencimiento">Vence:</label>
            <input type="date" id="fecha-vencimiento" value="2024-10-28">

            <label for="serie">Serie:</label>
            <input type="text" id="serie" value="001">

            <label for="numero">Número:</label>
            <input type="text" id="numero" value="200">

            <label for="secuencia">Secuencia:</label>
            <input type="text" id="secuencia" value="000006001" readonly>

            <label for="concepto">Concepto:</label>
            <input type="text" id="concepto" value="M186">

            <label for="ci-ruc">C.I./RUC:</label>
            <div class="input-group">
                <input type="text" id="ci-ruc" value="1803110517">
                <button type="button" class="btn-busqueda" onclick="buscarCIRUC()">
                    🔍
                </button>
            </div>

            <label for="nombre-cliente">Cliente:</label>
            <input type="text" id="nombre-cliente" value="GALARZA GALARZA NANCY ROCIO">

            <label for="codigo">Código:</label>
            <div class="input-group">
                <input type="text" id="codigo">
                <button type="button" class="btn-busqueda" onclick="buscarCodigo()">
                    🔍
                </button>
            </div>

            <div class="botones">
                <button type="button" class="btn-informacion">Información</button>
                <button type="button" class="btn-observacion">Observación</button>
                <button type="button" class="btn-existencias">Existencias</button>
            </div>
        </div>

        <div class="pestana-datos-adicionales">
            <label for="facturador">Facturador:</label>
            <input type="text" id="nombre-facturador" value="usuario logueado" readonly>


            <label for="sucursal">Sucursal:</label>
            <select id="sucursal">
                <option selected>MATRIZ / SANTA ROSA</option>
                <!-- Agregar más opciones si es necesario -->
            </select>
        </div>
    </form>
</div>



    <!-- Botones existentes y tabla -->
    <div class="buttons">
        <button class="export-btn">Exportar datos</button>
        <?php if ($rol === 'Administrador'): ?>
            <button class="add-btn">Agregar nueva Factura</button>
        <?php endif; ?>
    </div>

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
                            <a href="/app/controllers/FacturaController.php?action=edit&id=<?= $factura['idfactura'] ?>">✏️</a>
                            <a href="/Junta_Agua/public/content.php?view=factura/index&action=delete&id=<?= $factura['idfactura'] ?>"
                                onclick="return confirm('¿Estás seguro de eliminar esta factura?')">🗑️</a>
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