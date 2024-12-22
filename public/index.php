<?php
session_start();
require_once '../app/controllers/AuthController.php';

$authController = new AuthController();

// Verifica si se está enviando una solicitud de inicio de sesión
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'login') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Llamada al método login en AuthController
    if (!$authController->login($username, $password)) {
        // Redirige al formulario de login si falla la autenticación
        header("Location: index.php?action=login&error=invalid");
        exit();
    }
} elseif (isset($_GET['action']) && $_GET['action'] === 'logout') {
    // Cierra la sesión
    $authController->logout();
} elseif (isset($_SESSION['Cedula'])) {
    // Usuario autenticado, muestra la página principal
    include '../app/views/index.php';
} elseif (isset($_GET['action']) && $_GET['action'] === 'login') {
    // Mostrar el formulario de login si se seleccionó "Login"
    include '../app/views/login.php';
} elseif (isset($_GET['action']) && $_GET['action'] === 'registro_mediciones') {
    // Mostrar el formulario de registro de mediciones
    include '../app/views/registro_mediciones.php';
} else {
    // Mostrar la página de aterrizaje (landing page) por defecto
    include '../app/views/landing.php';
}
?>
