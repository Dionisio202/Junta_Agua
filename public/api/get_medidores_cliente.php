<?php
// public/api/get_user.php

// Incluir las dependencias necesarias
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/models/Medidores.php';

// Establecer el encabezado de respuesta como JSON
header('Content-Type: application/json');

// Crear una instancia de la conexión y el modelo
$database = new Database();
$db = $database->getConnection();
$medidoreModel = new Medidor($db);
$cliente = $_GET['cliente'];
// Llamar al método getLastFactura para obtener el último ID de factura
$medidores = $medidoreModel->getByClient($cliente);

$medidoresArray = [];
foreach ($medidores as $key => $value) {
    $medidoresArray[] = [
        'id' => $value['id'],
        'modelo' => $value['modelo'],
        'marca' => $value['marca'],
    ];
}

echo json_encode($medidoresArray);