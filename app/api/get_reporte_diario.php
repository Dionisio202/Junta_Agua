<?php
// public/api/get_facturas.php
error_reporting(E_ALL);

// Incluir las dependencias necesarias
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/models/Factura.php';

// Establecer el encabezado de respuesta como JSON
header('Content-Type: application/json; charset=utf-8');

try {
    // Crear una instancia de la conexión y el modelo
    $database = new Database();
    $db = $database->getConnection();
    $facturaModel = new Factura($db);

    // Llamar al método del modelo y devolver el resultado directamente
    echo json_encode($facturaModel->getFacturasToday(), JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    // Manejo de errores globales
    echo json_encode([
        'status' => 'error',
        'message' => 'Error inesperado: ' . $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}