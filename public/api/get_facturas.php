<?php
include_once __DIR__ . '/../../config/database.php';
include_once __DIR__ . '/../../app/models/Factura.php';
header('Content-Type: application/json');
$database = new Database();
$db = $database->getConnection();
$factura = new Factura($db);
$facturas = $factura->getAll();
echo json_encode($facturas);
?>