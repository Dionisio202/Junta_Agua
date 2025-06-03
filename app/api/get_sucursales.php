<?php
// public/api/get_user.php

// Incluir las dependencias necesarias
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/models/Sucursales.php';

// Establecer el encabezado de respuesta como JSON
header('Content-Type: application/json; charset=utf-8');

// Crear una instancia de la conexión y el modelo
$database = new Database();
$db = $database->getConnection();
$sucursalModel = new Sucursal($db);

// Llamar al método getLastFactura para obtener el último ID de factura
$sucursales = $sucursalModel->getAll();

// Crear un array para almacenar las sucursales
$sucursalesArray = [];
foreach ($sucursales as $sucursal) {
    $sucursalesArray[$sucursal['id']] = [
        'nombre' => $sucursal['nombre'],
        'ubicacion' => $sucursal['ubicacion'],
        'pto_emision' => $sucursal['pto_emision']
    ];
}

echo json_encode($sucursalesArray);