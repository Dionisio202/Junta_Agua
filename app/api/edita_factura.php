<?php
try {
    ini_set('display_errors', 0); // Desactiva la salida de errores visibles
    ini_set('log_errors', 1); // Activa registro de errores
    error_reporting(E_ALL);

    require_once '../../config/database.php';
    require_once '../../app/models/Factura.php';

    $database = new Database();
    $db = $database->getConnection();

    if (!$db) {
        throw new Exception("Error al conectar a la base de datos");
    }

    $facturaModel = new Factura($db);
    $input = file_get_contents('php://input');
    error_log("Datos recibidos: " . $input);

    $data = json_decode($input, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception("Error al decodificar JSON: " . json_last_error_msg());
    }

    // Validar campos
    if (!isset($data['fecha_emision'], $data['id_sucursal'], $data['facturador'], $data['cliente'], $data['total'])) {
        throw new Exception("Faltan campos obligatorios");
    }

    // Asume que cliente es una identificación y obtiene el ID
    $clienteIdentificacion = $data['cliente'];
    $clienteId = $facturaModel->getClienteIdByIdentificacion($clienteIdentificacion);

    if (!$clienteId) {
        throw new Exception("Cliente no encontrado con la identificación proporcionada.");
    }

    // Datos de la factura
    $facturaData = [
        'fecha_emision' => $data['fecha_emision'],
        'fecha_vencimiento' => $data['fecha_vencimiento'],
        'id_sucursal' => $data['id_sucursal'],
        'facturador' => $data['facturador'],
        'cliente' => $clienteId,
        'medidor_id' => $data['medidor_id'] ?? null,
        'valor_sin_impuesto' => $data['valor_sin_impuesto'],
        'iva' => $data['iva'],
        'total' => $data['total'],
        'id_factura' => $data['id_factura'],
    ];

    error_log("FacturaData: " . json_encode($facturaData));
    $resultado = $facturaModel->updateFactura($facturaData);

    if (!$resultado['success']) {
        throw new Exception($resultado['message']);
    }

    if (!empty($data['detalles'])) {
        $detalleResultado = $facturaModel->updateDetalleFactura($resultado['id_factura'], $data['detalles']);
        if ($detalleResultado['status'] !== 'success') {
            throw new Exception("Error al guardar los detalles: " . $detalleResultado['message']);
        }
    }

    header('Content-Type: application/json');
    echo json_encode([
        'success' => true,
        'id_factura' => $resultado['id_factura'],
    ]);
} catch (Exception $e) {
    error_log("Error encontrado: " . $e->getMessage());
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage(),
    ]);
    exit;
}
 catch (Exception $e) {
    error_log("Error encontrado: " . $e->getMessage());

    echo json_encode([
        'success' => false,
        'message' => $e->getMessage(),
    ]);
}
