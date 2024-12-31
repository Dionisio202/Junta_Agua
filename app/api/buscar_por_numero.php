<?php
// public/api/get_user.php

// Incluir las dependencias necesarias
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/models/Clientes.php';

// Establecer el encabezado de respuesta como JSON
header('Content-Type: application/json; charset=utf-8');

// Crear una instancia de la conexión y el modelo
$database = new Database();
$db = $database->getConnection();
$clienteModel = new Cliente($db);
$cedula = $_GET['numero'];

$clientes = $clienteModel -> getClientsByCedula($cedula);

$clientesArray = [];
foreach ($clientes as $cliente) {
    $clientesArray[] = [
        'id' => $cliente['id'],
        'cedula' => $cliente['identificacion'],
        'nombre' => $cliente['razon_social'],
    ];
}

echo json_encode($clientesArray);