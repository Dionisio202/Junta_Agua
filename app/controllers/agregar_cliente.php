<?php
require_once __DIR__ . "/../../config/database.php";
require_once __DIR__ . "/../models/Clientes.php";

$database = new Database();
$db = $database->getConnection();

$cliente = new Cliente($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {    
    $identificacion = htmlspecialchars($_POST['identificacion']);
    $razon_social = htmlspecialchars($_POST['razon_social']);
    $direccion = htmlspecialchars($_POST['direccion']);
    $telefono1 = htmlspecialchars($_POST['telefono1']);
    $telefono2 = isset($_POST['telefono2']) ? htmlspecialchars($_POST['telefono2']) : '';
    $correo = htmlspecialchars($_POST['correo']);

    $resultado = $cliente->agregarCliente($identificacion, $razon_social, $direccion, $telefono1, $telefono2, $correo);

    if ($resultado) {
        // Redirigir a la página de gestión de usuarios después de agregar
        header("Location: /Junta_Agua/public/?view=gestion_usuarios");
        exit; // Importante para evitar que el código posterior se ejecute
    } else {
        // Redirigir en caso de error, también podrías mostrar un mensaje
        header("Location: /Junta_Agua/public/?view=gestion_usuarios&error=1");
        exit;
        

        }

        }
?>
