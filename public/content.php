<?php
require_once '../app/controllers/FacturaController.php';
require_once '../app/controllers/AutorizacionesController.php';
require_once '../app/controllers/MedicionesController.php';
require_once '../app/models/MedicionesModel.php';
require_once '../config/database.php';

// Función para verificar el acceso según el rol del usuario
function checkAccess($requiredRoles)
{
    $userRole = $_SESSION['Rol'] ?? 'Invitado'; // Obtén el rol del usuario o asigna 'Invitado' por defecto
    return in_array($userRole, $requiredRoles); // Verifica si el rol del usuario está permitido
}

// Obtener parámetros
$view = $_GET['view'] ?? 'factura/index';
$action = $_GET['action'] ?? null;

switch ($view) {
    // ==================== FACTURA ====================
    case 'factura/index':
        if (!checkAccess(['Contador', 'Presidente'])) {
            echo "<p>Acceso denegado. No tienes permiso para acceder a esta vista.</p>";
            exit();
        }
        $controller = new FacturaController();
        if ($action === 'delete') {
            if (!checkAccess(['Contador'])) {
                echo "<p>Acceso denegado. No tienes permiso para eliminar facturas.</p>";
                exit();
            }
            $id = $_GET['id'] ?? null;
            if ($id) {
                $controller->deleteFactura($id);
                header("Location: /Junta_Agua/public/index.php?view=factura/index&page=1");
                exit();
            } else {
                echo "<p>Error: ID de factura no proporcionado.</p>";
            }
        } else {
            $controller->index();
        }
        break;

    case 'factura/nuevafactura':
        if (!checkAccess(['Contador', 'Tesorero'])) {
            echo "<p>Acceso denegado. No tienes permiso para acceder a esta vista.</p>";
            exit();
        }
        $controller = new FacturaController();
        $controller->nuevafactura();
        break;

    case 'factura/viewfactura':
        if (!checkAccess(['Contador', 'Presidente'])) {
            echo "<p>Acceso denegado. No tienes permiso para acceder a esta vista.</p>";
            exit();
        }
        $controller = new FacturaController();
        $controller->viewfactura();
        break;

    // ==================== AUTORIZACIONES ====================
    case 'autorizaciones':
        if (!checkAccess(['Contador'])) {
            echo "<p>Acceso denegado. No tienes permiso para acceder a esta vista.</p>";
            exit();
        }
        $controller = new AutorizacionController();
        $controller->vista();
        break;

    // ==================== PERFIL ====================
    case 'perfil':
        $usuario = [
            'rol' => $_SESSION['Rol'] ?? 'Invitado',
            'nombre' => $_SESSION['Nombre'] ?? 'N/A',
            'apellido' => $_SESSION['Apellido'] ?? 'N/A',
            'cedula' => $_SESSION['Cedula'] ?? 'N/A',
            'correo' => $_SESSION['Correo'] ?? 'N/A',
            'telefono' => 'N/A',
        ];
        include '../app/views/perfil.php';
        break;

    // ==================== MEDICIONES ====================
    case 'mediciones':
        if (!checkAccess(['Contador', 'Presidente'])) {
            echo "<p>Acceso denegado. No tienes permiso para acceder a esta vista.</p>";
            exit();
        }
        $rol = $_SESSION['Rol'] ?? 'Desconocido';
        $nombre = $_SESSION['Nombre'] ?? 'Invitado';
        $database = new Database();
        $db = $database->getConnection();
        $model = new MedicionesModel($db);
        $controller = new MedicionesController($model);

        if ($action) {
            $controller->handleAction($action);
        } else {
            include '../app/views/mediciones.php';
        }
        break;

    // ==================== GESTIÓN DE USUARIOS ====================
    case 'gestion_usuarios':
        if (!checkAccess(['Contador', 'Presidente'])) {
            echo "<p>Acceso denegado. No tienes permiso para acceder a esta vista.</p>";
            exit();
        }
        include '../app/views/RegistroClientes.php';
        break;
    case 'editar': 
        $user = $_GET['id'];
        if (!checkAccess(['Contador', 'Presidente'])) {
            echo "<p>Acceso denegado. No tienes permiso para acceder a esta vista.</p>";
            exit();
        }
        include '../app/views/editar.php';
        break;

    // ==================== ERROR 404 ====================
    default:
        http_response_code(404);
        echo "<p>Vista no encontrada.</p>";
        break;
}
?>