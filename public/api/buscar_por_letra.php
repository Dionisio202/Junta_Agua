<?php
// public/api/get_user.php

// Incluir las dependencias necesarias
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/models/Clientes.php';

// Establecer el encabezado de respuesta como JSON
header('Content-Type: application/json');
$nombre = $_GET['letra'];
// Crear una instancia de la conexión y el modelo
$database = new Database();
$db = $database->getConnection();
$clienteModel = new Cliente($db);

$clientes = $clienteModel -> getClientsByName($nombre);

$clientesArray = [];
foreach ($clientes as $cliente) {
    $clientesArray[] = [
        'id' => $cliente['id'],
        'cedula' => $cliente['identificacion'],
        'nombre' => $cliente['nombre_comercial'],
    ];
}

echo json_encode($clientesArray);