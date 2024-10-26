<?php
session_start();
require_once '../app/controllers/AuthController.php';

$authController = new AuthController();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'login') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Llamada al método login en AuthController
    if (!$authController->login($username, $password)) {
        // Este redireccionamiento ya se hace en el AuthController, pero es importante asegurarse
        header("Location: index.php?action=login&error=invalid");
        exit();
    }
} elseif (isset($_GET['action']) && $_GET['action'] === 'logout') {
    $authController->logout();
} elseif (isset($_SESSION['Nombre'])) {
    // Usuario autenticado, muestra la página principal
    echo "Bienvenido, " . htmlspecialchars($_SESSION['Nombre']) . " (" . htmlspecialchars($_SESSION['Rol']) . ")";
    echo '<br><a href="index.php?action=logout">Cerrar sesión</a>';
    
    // Cargar landing page o contenido según el rol
    include '../app/views/landing.php';
} else {
    // Mostrar el formulario de login si no está autenticado
    include '../app/views/login.php';
}
?>
