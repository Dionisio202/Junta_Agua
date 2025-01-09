<?php
// Incluir los archivos necesarios
require_once __DIR__ . "/../../config/database.php";
require_once __DIR__ . "/../../app/models/Clientes.php";

// Configuración para responder con JSON
header('Content-Type: application/json');

// Conexión a la base de datos
$database = new Database();
$db = $database->getConnection();

if (!$db) {
    echo json_encode(['error' => 'Error de conexión a la base de datos.']);
    exit;
}

// Obtener el parámetro de búsqueda desde la URL
$buscar = isset($_GET['query']) ? htmlspecialchars($_GET['query']) : '';

// Crear instancia del modelo Cliente
$cliente = new Cliente($db);

// Obtener clientes filtrados por búsqueda
$clientes = $cliente->getClientsBySearch($buscar);

// Retornar los resultados como JSON
echo json_encode(['clientes' => $clientes]);
