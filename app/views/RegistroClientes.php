<?php
// Incluyendo los archivos necesarios para la base de datos y el modelo
require_once __DIR__ . "/../../config/database.php";
require_once __DIR__ . "/../../app/models/Clientes.php";
require_once __DIR__ . "/../../app/controllers/agregar_cliente.php";
require_once __DIR__ . "/../../app/controllers/editar_cliente.php";
require_once __DIR__ . "/../../app/controllers/eliminar_cliente.php";

// Crear instancia de la base de datos
$database = new Database();
$db = $database->getConnection();

if (!$db) {
    die("Error de conexión a la base de datos.");
}

// Crear instancia de Cliente
$cliente = new Cliente($db);

// Obtener parámetros de búsqueda
$buscar = isset($_GET['buscar']) ? htmlspecialchars($_GET['buscar']) : '';

// Obtener clientes filtrados por búsqueda
$clientes = $cliente->getClientsBySearch($buscar);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Clientes</title>
    <link rel="stylesheet" href="/Junta_Agua/public/styles/clientes.css"> 
</head>
<body>
<div class="container mt-5">
    <h1>Gestión de Clientes</h1>

    <!-- Contenedor del buscador y agregar cliente -->
    <div class="row mb-4 align-items-start">
        <!-- Buscador -->
        <div class="col-md-4">
            <form method="GET" class="input-group">
                <input type="text" name="buscar" class="form-control" placeholder="Buscar por ID o Razón" value="<?php echo $buscar; ?>">
                <button type="submit" class="btn">Buscar</button>
            </form>
        </div>

        <!-- Formulario de agregar cliente -->
        <div class="col-md-8">
            <div class="card">
                <h4>Agregar Cliente</h4>
                <form action="/Junta_Agua/app/controllers/agregar_cliente.php" method="POST">
                    <div class="row g-2">
                        <div class="col-md-4">
                            <label for="identificacion">Identificación:</label>
                            <input type="text" name="identificacion" class="form-control" placeholder="Identificación" required>
                        </div>
                        <div class="col-md-4">
                            <label for="razon_social">Razón Social:</label>
                            <input type="text" name="razon_social" class="form-control" placeholder="Razón Social" required>
                        </div>
                        <div class="col-md-4">
                            <label for="direccion">Dirección:</label>
                            <input type="text" name="direccion" class="form-control" placeholder="Dirección" required>
                        </div>
                        <div class="col-md-4">
                            <label for="telefono1">Teléfono 1:</label>
                            <input type="text" name="telefono1" class="form-control" placeholder="Teléfono 1" required>
                        </div>
                        <div class="col-md-4">
                            <label for="telefono2">Teléfono 2:</label>
                            <input type="text" name="telefono2" class="form-control" placeholder="Teléfono 2">
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-success w-100">Agregar Cliente</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Tabla de clientes -->
    <h3>Lista de Clientes</h3>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Identificación</th>
                <th>Razón Social</th>
                <th>Dirección</th>
                <th>Teléfono 1</th>
                <th>Teléfono 2</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($clientes)): ?>
                <?php foreach ($clientes as $cliente): ?>
                    <tr>
                        <td><?php echo $cliente['id']; ?></td>
                        <td><?php echo $cliente['identificacion']; ?></td>
                        <td><?php echo $cliente['razon_social']; ?></td>
                        <td><?php echo $cliente['direccion']; ?></td>
                        <td><?php echo $cliente['telefono1']; ?></td>
                        <td><?php echo $cliente['telefono2']; ?></td>
                        <td>
    <a href="/Junta_Agua/app/views/editar.php?id=<?php echo $cliente['id']; ?>" 
       class="btn btn-warning btn-sm">Editar</a>
    <form action="/Junta_Agua/app/controllers/eliminar_cliente.php" 
          method="POST" 
          >
        <input type="hidden" name="id" value="<?php echo $cliente['id']; ?>">
        <button type="submit" 
                class="btn btn-danger btn-sm" 
                onclick="return confirm('¿Estás seguro de eliminar este cliente?')">Eliminar</button>
    </form>
</td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center">No se encontraron clientes</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
