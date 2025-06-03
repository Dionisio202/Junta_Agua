<?php
require_once __DIR__ . "/../../config/database.php";
require_once __DIR__ . "/../models/Clientes.php";

$database = new Database();
$db = $database->getConnection();

$cliente = new Cliente($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener el ID del cliente a eliminar
    $id = htmlspecialchars($_POST['id']);

    // Llamar al método de eliminar cliente
    $resultado = $cliente->eliminarCliente($id);

    // Comprobar si la eliminación fue exitosa
    if ($resultado) {
        // Redirigir a la página de gestión de usuarios después de eliminar
        header("Location: /Junta_Agua/public/?view=gestion_usuarios");
        exit; // Importante para evitar que el código posterior se ejecute
    } else {
        // Redirigir en caso de error, también podrías mostrar un mensaje
        header("Location: /Junta_Agua/public/?view=gestion_usuarios&error=1");
        exit;
    }
}
?>
