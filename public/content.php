<?php
require_once '../app/controllers/FacturaController.php';
require_once '../app/controllers/AutorizacionesController.php';
require_once '../app/controllers/MedicionController.php';  

$view = $_GET['view'] ?? 'factura/index';
$action = $_GET['action'] ?? null;

switch ($view) {
    case 'factura/index':
        $controller = new FacturaController();
        if ($action === 'delete') {
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
        $controller = new FacturaController();
        $controller->nuevafactura(); // Cargar la vista para crear una nueva factura
        break;

    case 'autorizaciones':
        $controller = new AutorizacionController();
        $controller->vista(); // Cargar la vista de autorizaciones
        break;

        case 'mediciones/registro':
            $controller = new MedicionController();
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller->store();
            } else {
                $controller->index(); // Mostrar formulario para nueva medición
            }
            break;
        
            case 'mediciones/nuevamedicion':
                $controller = new MedicionController();
                $controller->create(); // Cargar formulario para nueva medición
                break;

    case 'perfil':
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $usuario = [
            'rol' => $_SESSION['Rol'] ?? 'Invitado',
            'nombre' => $_SESSION['Nombre'] ?? 'N/A',
            'apellido' => $_SESSION['Apellido'] ?? 'N/A',
            'cedula' => $_SESSION['Cedula'] ?? 'N/A',
            'correo' => $_SESSION['Correo'] ?? 'N/A',
        ];
        include '../app/views/perfil.php';
        break;

    default:
        echo "<p>Vista no encontrada.</p>";
        break;
}
?>
