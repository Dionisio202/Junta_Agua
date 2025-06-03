<?php
try {
    // Registro inicial para saber si entra al try
    error_log("Inicio del procesamiento en el endpoint.");

    // Código existente para configurar y procesar datos
    require_once '../../config/database.php';
    require_once '../../app/models/Factura.php';

    $database = new Database();
    $db = $database->getConnection();

    if (!$db) {
        throw new Exception("Error al conectar a la base de datos");
    }

    $facturaModel = new Factura($db);

    // Leer id de la factura desde la solicitud
    $id = $_GET['id'] ?? null;

    if (!$id) {
        throw new Exception("ID de factura no proporcionado");
    }

    // Obtener los datos de la factura

    $factura = $facturaModel->getFacturaDetalles($id);

    if (!$factura) {
        throw new Exception("Factura no encontrada");
    }

    // Enviar los datos de la factura como respuesta

    echo json_encode([
        'success' => true,
        'factura' => $factura,
    ]);

} catch (Exception $e) {
    error_log("Error encontrado: " . $e->getMessage());

    echo json_encode([
        'success' => false,
        'message' => $e->getMessage(),
    ]);
}
