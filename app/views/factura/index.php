<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Facturas</title>
    <link rel="stylesheet" href="../public/styles/styles.css">
</head>
<body>
    <h1>Facturas</h1>
    <a href="/app/controllers/FacturaController.php?action=create">Agregar nueva factura</a>
    <table>
        <tr>
            <th>Nombre</th>
            <th>Cédula</th>
            <th>Teléfono</th>
            <th>Detalle</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($facturas as $factura): ?>
            <tr>
                <td><?= $factura['nombre'] ?></td>
                <td><?= $factura['cedula'] ?></td>
                <td><?= $factura['telefono'] ?></td>
                <td><?= $factura['detalle'] ?></td>
                <td>
                    <a href="/app/controllers/FacturaController.php?action=delete&id=<?= $factura['id'] ?>">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
