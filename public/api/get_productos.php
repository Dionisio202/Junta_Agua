<?php
// public/api/get_productos.php

// Incluir las dependencias necesarias
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/models/Razones.php';

// Establecer el encabezado de respuesta como JSON
header('Content-Type: application/json');

// Crear una instancia de la conexión y el modelo
$database = new Database();
$db = $database->getConnection();
$razonesModel = new Razon($db);


// Llamar al método getAll para obtener todas las razones/productos
$razones = $razonesModel->getAll();

// Crear un array para almacenar las razones/productos
$razonesArray = [];
foreach ($razones as $key => $value) {
    $razonesArray[] = [
        'id' => $value['id'],
        'codigo' => $value['codigo'],
        'razon' => $value['razon'],
        'precio' => $value['precio1'],
        'iva' => $value['iva']
    ];
}
// Enviar los datos como respuesta en formato JSON
echo json_encode($razonesArray);