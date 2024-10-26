<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Facturas</title>
    <link rel="stylesheet" href="../public/styles/styles.css">
</head>
<body>
    <!-- Depuración: imprimir el rol en la vista -->
    <?php
    echo "<pre>Rol en la vista: ";
    print_r($rol);
    echo "</pre>";
    ?>

    <!-- Encabezado personalizado según el rol -->
    <h1>Facturación <?php echo isset($rol) && $rol === 'Tesorero' ? 'TESORERÍA' : ''; ?></h1>
    
    <div class="user-info">
        <img src="path/to/user-image.jpg" alt="User Image" class="user-img">
        <span class="username">USER</span><br>
        <span class="role"><?php echo $rol; ?></span>
    </div>
    
    <div class="table-container">
        <?php if ($rol === 'Administrador'): ?>
            <button class="add-btn">Agregar nueva Factura</button>
        <?php endif; ?>

        <button class="export-btn">Exportar datos</button>

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
            
            <?php if (!empty($facturas)): ?>
                <?php foreach ($facturas as $factura): ?>
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
            <span>&lt;</span>
            <span>3</span>
            <span>4</span>
            <span>5</span>
            <span>&gt;</span>
        </div>
    </div>
</body>
</html>
