<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Configurar el archivo de logs en la misma carpeta que el script
ini_set("log_errors", 1);
ini_set("error_log", __DIR__ . "/error.log");

try {
    // Generar un identificador único para esta ejecución
    $logId = uniqid("log_", true);
    error_log("[$logId] Inicio del procesamiento en el endpoint.");

    // Incluir configuraciones y modelos
    require_once '../../config/database.php';
    require_once '../../app/models/Factura.php';

    $database = new Database();
    $db = $database->getConnection();

    if (!$db) {
        throw new Exception("[$logId] Error al conectar a la base de datos");
    }

    $facturaModel = new Factura($db);

    // Leer datos enviados en la solicitud
    $input = file_get_contents('php://input');
    error_log("[$logId] Datos recibidos (JSON): " . $input);

    $data = json_decode($input, true);

    // Validar si la decodificación del JSON falló
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception("[$logId] Error al decodificar JSON: " . json_last_error_msg());
    }

    error_log("[$logId] Datos decodificados: " . print_r($data, true));

    // Validar campos obligatorios
    $requiredFields = ['fecha_emision', 'id_sucursal', 'facturador', 'cliente', 'total'];
    foreach ($requiredFields as $field) {
        if (!isset($data[$field])) {
            throw new Exception("[$logId] Campo obligatorio faltante: $field");
        }
    }
    error_log("[$logId] Campos obligatorios validados correctamente.");

    // Llamar al modelo para guardar la factura completa
    $resultado = $facturaModel->saveFacturaCompleta($data);
    error_log("[$logId] Resultado del modelo: " . print_r($resultado, true));

    // Validar el resultado del modelo
    if ($resultado['status'] !== 'success') {
        throw new Exception("[$logId] " . $resultado['message']);
    }

    // Respuesta exitosa
    echo json_encode([
        'success' => true,
        'id_factura' => $resultado['id_factura'],
    ]);
    error_log("[$logId] Factura procesada correctamente. ID de factura: " . $resultado['id_factura']);
} catch (Exception $e) {
    // Registrar el error en los logs
    error_log("[$logId] Error encontrado: " . $e->getMessage());

    // Responder con un mensaje de error
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage(),
    ]);
}