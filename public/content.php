<?php
require_once '../app/controllers/FacturaController.php';
require_once '../app/controllers/AutorizacionesController.php';


// Función para verificar el acceso según el rol del usuario
function checkAccess($requiredRoles) {
    $userRole = $_SESSION['Rol'] ?? 'Invitado'; // Obtén el rol del usuario o asigna 'Invitado' por defecto
    return in_array($userRole, $requiredRoles); // Verifica si el rol del usuario está permitido
}

$view = $_GET['view'] ?? 'factura/index';
$action = $_GET['action'] ?? null; // Obtiene la acción, si existe

// Inicializa el controlador según la vista solicitada
switch ($view) {
    case 'factura/index':
        // Permitir acceso a Contador y Presidente
        if (!checkAccess(['Contador', 'Presidente'])) {
            echo "<p>Acceso denegado. No tienes permiso para acceder a esta vista.</p>";
            exit();
        }
        $controller = new FacturaController();
        if ($action === 'delete') {
            // Restringir eliminar facturas solo a Contador
            if (!checkAccess(['Contador'])) {
                echo "<p>Acceso denegado. No tienes permiso para eliminar facturas.</p>";
                exit();
            }
            $id = $_GET['id'] ?? null;
            if ($id) {
                $controller->deleteFactura($id);
                // Redirige de nuevo a la lista después de eliminar
                header("Location: /Junta_Agua/public/index.php?view=factura/index&page=1");
                exit();
            } else {
                echo "<p>Error: ID de factura no proporcionado.</p>";
            }
        } else {
            $controller->index(); // Carga la vista de facturas
        }
        break;

    case 'factura/nuevafactura':
        // Permitir acceso a Contador y Tesorero
        if (!checkAccess(['Contador', 'Tesorero'])) {
            echo "<p>Acceso denegado. No tienes permiso para acceder a esta vista.</p>";
            exit();
        }
        $controller = new FacturaController();
        $controller->nuevafactura(); // Cargar la vista para crear una nueva factura
        break;

    case 'autorizaciones':
        // Solo "Contador" puede acceder
        if (!checkAccess(['Contador'])) {
            echo "<p>Acceso denegado. No tienes permiso para acceder a esta vista.</p>";
            exit();
        }
        $controller = new AutorizacionController();
        $controller->vista(); // Cargar la vista de autorizaciones
        break;

    // Aquí puedes añadir otros casos para otros controladores y métodos
    default:
        echo "<p>Vista no encontrada.</p>";
        break;
}
