<?php
try {
    // Registro inicial para saber si entra al try
    error_log("Inicio del procesamiento en el endpoint.");

    // Código existente para configurar y procesar datos
    require_once '../../config/database.php';
    require_once '../../app/models/Factura.php';

    $database = new Database();
    $db = $database->getConnection();

    if (!$db) {
        throw new Exception("Error al conectar a la base de datos");
    }

    $facturaModel = new Factura($db);

    // Leer datos del cliente
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

    // Código para guardar factura
    $facturaData = [
        'fecha_emision' => $data['fecha_emision'],
        'fecha_vencimiento' => $data['fecha_vencimiento'],
        'id_sucursal' => $data['id_sucursal'],
        'facturador' => $data['facturador'],
        'cliente' => $data['cliente'],
        'medidor_id' => $data['medidor_id'] ?? null,
        'estado_factura' => 'Sin autorizar',
        'valor_sin_impuesto' => $data['valor_sin_impuesto'],
        'iva' => $data['iva'],
        'total' => $data['total'],
    ];

    error_log("FacturaData: " . json_encode($facturaData));

    $resultado = $facturaModel->saveFactura($facturaData);
    if (!$resultado['success']) {
        throw new Exception($resultado['message']);
    }

    // Guardar detalles
    if (!empty($data['detalles'])) {
        $detalleResultado = $facturaModel->saveDetalleFactura($resultado['id_factura'], $data['detalles']);
        if ($detalleResultado['status'] !== 'success') {
            throw new Exception("Error al guardar los detalles: " . $detalleResultado['message']);
        }
    }

    // Respuesta exitosa
    echo json_encode([
        'success' => true,
        'id_factura' => $resultado['id_factura'],
    ]);
} catch (Exception $e) {
    error_log("Error encontrado: " . $e->getMessage());

    echo json_encode([
        'success' => false,
        'message' => $e->getMessage(),
    ]);
}
