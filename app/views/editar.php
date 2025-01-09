<?php
// editar.php
require_once __DIR__ . "/../../config/database.php";
require_once __DIR__ . "/../../app/models/Clientes.php";

$database = new Database();
$db = $database->getConnection();

$cliente = new Cliente($db);

// Obtener el ID del cliente desde la URL
$id = isset($_GET['id']) ? $_GET['id'] : die('ID de cliente no proporcionado');

// Obtener los datos del cliente
$clienteData = $cliente->obtenerClientePorId($id);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente</title>
    <link rel="stylesheet" href="/Junta_Agua/public/styles/editar.css"> 
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Editar Cliente</h1>

        <!-- Formulario de edición de cliente -->
        <form action="/Junta_Agua/app/controllers/editar_cliente.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $clienteData['id']; ?>">

            <div class="form-row">
                <div class="col-md-6">
                    <label for="identificacion">Identificación:</label>
                    <input type="text" class="form-control" id="identificacion" name="identificacion" value="<?php echo htmlspecialchars($clienteData['identificacion']); ?>" required>
                </div>
                <div class="col-md-6">
                    <label for="razon_social">Razón Social:</label>
                    <input type="text" class="form-control" id="razon_social" name="razon_social" value="<?php echo htmlspecialchars($clienteData['razon_social']); ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-6">
                    <label for="direccion">Dirección:</label>
                    <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo htmlspecialchars($clienteData['direccion']); ?>" required>
                </div>
                <div class="col-md-6">
                    <label for="telefono1">Teléfono 1:</label>
                    <input type="text" class="form-control" id="telefono1" name="telefono1" value="<?php echo htmlspecialchars($clienteData['telefono1']); ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-6">
                    <label for="telefono2">Teléfono 2:</label>
                    <input type="text" class="form-control" id="telefono2" name="telefono2" value="<?php echo htmlspecialchars($clienteData['telefono2']); ?>">
                </div>
                <div class="form-row">
    <div class="col-md-6">
        <label for="correo">Correo:</label>
        <input type="email" class="form-control" id="correo" name="correo" 
               value="<?php echo htmlspecialchars($clienteData['correo']); ?>" required>
    </div>
</div>  
            <button type="submit" class="btn btn-success mt-3">Guardar Cambios</button>
            <a href="/Junta_Agua/public/?view=gestion_usuarios" class="btn btn-danger mt-3">Cancelar</a>
        </form>
        </form>
    </div>
</body>
</html>
