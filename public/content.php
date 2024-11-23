<?php
require_once '../app/controllers/FacturaController.php';
require_once '../app/controllers/AutorizacionesController.php';

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
<<<<<<< HEAD

    case 'factura/nuevafactura':
        $controller = new FacturaController();
        $controller->nuevafactura();
        break;

    case 'autorizaciones':
        $controller = new AutorizacionController();
        $controller->vista();
        break;

    case 'perfil':
        session_start();
=======
        case 'factura/nuevafactura':
            $controller = new FacturaController();
            $controller->nuevafactura(); // Cargar la vista para crear una nueva factura
            break;
        case 'autorizaciones':
                $controller = new AutorizacionController();
                $controller->vista(); // Cargar la vista para crear una nueva factura
                break;
       case 'perfil':
>>>>>>> 15e56dd60cbe22e89ed182252eed3593c093f1e5
        $usuario = [
            'rol' => $_SESSION['Rol'] ?? 'Invitado',
            'nombre' => $_SESSION['Nombre'] ?? 'N/A',
            'apellido' => $_SESSION['Apellido'] ?? 'N/A',
            'cedula' => $_SESSION['Cedula'] ?? 'N/A',
<<<<<<< HEAD
            'correo' => $_SESSION['Correo'] ?? 'N/A',
            'telefono' => 'N/A',
=======
            'correo' => $_SESSION['Correo'] ?? 'test@example.com',
>>>>>>> 15e56dd60cbe22e89ed182252eed3593c093f1e5
        ];
        include '../app/views/perfil.php';
        break;

<<<<<<< HEAD
=======
                    
                
    // Aquí puedes añadir otros casos para otros controladores y métodos
>>>>>>> 15e56dd60cbe22e89ed182252eed3593c093f1e5
    default:
        echo "<p>Vista no encontrada.</p>";
        break;
}


