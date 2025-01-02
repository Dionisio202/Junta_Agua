<?php
include_once __DIR__ . '/../../config/database.php';
include_once __DIR__ . '/../../app/models/Factura.php';

header('Content-Type: application/json; charset=utf-8');

// Validar que el parámetro `id` esté presente
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'El ID de la factura es obligatorio.'
    ]);
    exit;
}

$database = new Database();
$db = $database->getConnection();
$factura = new Factura($db);

try {
    $facturaId = intval($_GET['id']); // Convertir a entero para evitar inyecciones
    $facturaDetails = $factura->updateAUthState($facturaId);

    if (!$facturaDetails) {
        echo json_encode([
            'success' => false,
            'message' => 'Factura no encontrada.'
        ]);
    } else {
        echo json_encode([
            'success' => true,
            'data' => $facturaDetails
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error al obtener los datos: ' . $e->getMessage()
    ]);
}
?>
