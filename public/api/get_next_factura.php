<?php
// public/api/get_user.php

// Incluir las dependencias necesarias
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/models/Factura.php';

// Establecer el encabezado de respuesta como JSON
header('Content-Type: application/json');

// Crear una instancia de la conexión y el modelo
$database = new Database();
$db = $database->getConnection();
$facturaModel = new Factura($db);

// Llamar al método getLastFactura para obtener el último ID de factura
$lastFactura = $facturaModel->getLastFactura();

// Sumar 1 al último ID de factura
$nextFacturaId = $lastFactura + 1;

// Formatear el nuevo ID con ceros a la izquierda hasta 10 dígitos
$formattedFacturaId = str_pad($nextFacturaId, 10, "0", STR_PAD_LEFT);

// Devolver el nuevo ID formateado como JSON
echo json_encode([
    "nextFactura" => $formattedFacturaId // El próximo ID con formato
]);
