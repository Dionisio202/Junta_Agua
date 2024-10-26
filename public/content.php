<?php
require_once '../app/controllers/FacturaController.php';

$view = $_GET['view'] ?? 'factura/index';

// Inicializa el controlador según la vista solicitada
switch ($view) {
    case 'factura/index':
        $controller = new FacturaController();
        $controller->index(); // Llama al método que cargará la vista correspondiente
        break;
    // Aquí puedes añadir otros casos para otros controladores y métodos
    default:
        echo "<p>Vista no encontrada.</p>";
        break;
}