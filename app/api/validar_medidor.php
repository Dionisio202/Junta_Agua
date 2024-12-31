<?php
require_once '../../config/database.php';

// Configuración de respuesta JSON
header('Content-Type: application/json');

// Validar parámetros
if (!isset($_GET['id_medidor'])) {
    echo json_encode(['success' => false, 'message' => 'El ID del medidor es requerido.']);
    exit();
}

$idMedidor = $_GET['id_medidor'];

// Conexión a la base de datos
$database = new Database();
$db = $database->getConnection();

// Consulta para validar el medidor
$query = "SELECT c.id AS id_cliente, c.razon_social AS nombre, c.identificacion AS cedula
          FROM medidores m
          JOIN clientes c ON m.id_cliente = c.id
          WHERE m.nro_medidor = :id_medidor";
$stmt = $db->prepare($query);
$stmt->bindParam(':id_medidor', $idMedidor);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode(['success' => true, 'cliente' => $cliente]);
} else {
    echo json_encode(['success' => false, 'message' => 'El medidor no tiene un dueño registrado.']);
}
?>
