<?php
// public/api/get_user.php

// Incluir las dependencias necesarias
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/models/User.php';

// Establecer el encabezado de respuesta como JSON
header('Content-Type: application/json');

// Verificar si el parámetro 'id' está presente en la solicitud GET
if (isset($_GET['id'])) {
    $userId = intval($_GET['id']); // Asegúrate de convertirlo en entero para seguridad

    // Crear conexión a la base de datos
    $database = new Database();
    $db = $database->getConnection();

    // Crear una instancia del modelo User
    $userModel = new User($db);

    // Llamar al método getUserData con el ID proporcionado
    $userData = $userModel->getUserData($userId);

    // Devolver la respuesta como JSON
    if ($userData) {
        echo json_encode($userData);
    } else {
        echo json_encode(["error" => "Usuario no encontrado."]);
    }
} else {
    echo json_encode(["error" => "Parámetro 'id' no proporcionado."]);
}