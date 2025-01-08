<?php
require_once __DIR__ . "/../../config/database.php";
require_once __DIR__ . "/../models/Clientes.php";

$database = new Database();
$db = $database->getConnection();

$cliente = new Cliente($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del cliente desde el formulario
    $id = htmlspecialchars($_POST['id']);  // Asegúrate de que el ID esté presente en el formulario
    $identificacion = htmlspecialchars($_POST['identificacion']);
    $razon_social = htmlspecialchars($_POST['razon_social']);
    $direccion = htmlspecialchars($_POST['direccion']);
    $telefono1 = htmlspecialchars($_POST['telefono1']);
    $telefono2 = isset($_POST['telefono2']) ? htmlspecialchars($_POST['telefono2']) : '';

    // Realizar la edición
    $resultado = $cliente->editarCliente($id, $identificacion, $razon_social, $direccion, $telefono1, $telefono2);

    // Comprobar si la edición fue exitosa
    if ($resultado) {
        // Redirigir a la página de RegistroCliente
        header("Location: /Junta_Agua/public/?view=gestion_usuarios");
        exit();  // Asegúrate de salir después de redirigir
    } else {
        echo "Error al editar el cliente.";
    }
}
?>
