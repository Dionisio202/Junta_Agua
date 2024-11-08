<?php
require_once '../app/controllers/FacturaController.php';

$view = $_GET['view'] ?? 'factura/index';
$action = $_GET['action'] ?? null; // Obtiene la acción, si existe

// Inicializa el controlador según la vista solicitada
switch ($view) {
    case 'factura/index':
        $controller = new FacturaController();
        if ($action === 'delete') {
            // Si la acción es eliminar, obtén el ID de la factura y llama a deleteFactura
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
            $controller->index(); // Llama al método que cargará la vista correspondiente
        }
        break;
        case 'factura/nuevafactura':
            $controller = new FacturaController();
            $controller->nuevafactura(); // Cargar la vista para crear una nueva factura
            break;
    // Aquí puedes añadir otros casos para otros controladores y métodos
    default:
        echo "<p>Vista no encontrada.</p>";
        break;
}
