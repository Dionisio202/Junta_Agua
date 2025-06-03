<?php
// obtener_lecturas.php
header('Content-Type: application/json');

// Conexión a la base de datos
require_once __DIR__ . '/../../config/database.php';

$database = new Database();
$db = $database->getConnection();

// Obtener el medidor_id, meses y años de la solicitud GET
$medidorId = isset($_GET['medidor_id']) ? (int)$_GET['medidor_id'] : 0;
$mesEmision = isset($_GET['mes_emision']) ? (int)$_GET['mes_emision'] : 0;
$yearEmision = isset($_GET['year_emision']) ? (int)$_GET['year_emision'] : 0;
$mesAnterior = isset($_GET['mes_anterior']) ? (int)$_GET['mes_anterior'] : 0;
$yearAnterior = isset($_GET['year_anterior']) ? (int)$_GET['year_anterior'] : 0;
$mesAntesDeAnterior = isset($_GET['mes_antes_anterior']) ? (int)$_GET['mes_antes_anterior'] : 0;
$yearAntesDeAnterior = isset($_GET['year_antes_anterior']) ? (int)$_GET['year_antes_anterior'] : 0;

if ($medidorId === 0 || $mesEmision === 0 || $mesAnterior === 0 || $mesAntesDeAnterior === 0 || $yearEmision === 0) {
    echo json_encode(['error' => 'El medidor_id, los meses y los años son necesarios']);
    exit;
}

// Consulta SQL para obtener las lecturas dinámicamente
$query = "
SELECT 
    id_medidor,
    MAX(CASE WHEN MONTH(fecha_lectura) = :mes_emision AND YEAR(fecha_lectura) = :year_emision THEN lectura ELSE '--' END) AS lectura_1,
    MAX(CASE WHEN MONTH(fecha_lectura) = :mes_anterior AND YEAR(fecha_lectura) = :year_anterior THEN lectura ELSE '--' END) AS lectura_2,
    MAX(CASE WHEN MONTH(fecha_lectura) = :mes_antes_anterior AND YEAR(fecha_lectura) = :year_antes_anterior THEN lectura ELSE '--' END) AS lectura_3
FROM 
    detalle_medidores
WHERE 
    id_medidor = :medidor_id
GROUP BY 
    id_medidor
";

// Preparar y ejecutar la consulta
$stmt = $db->prepare($query);
$stmt->bindParam(':medidor_id', $medidorId, PDO::PARAM_INT);
$stmt->bindParam(':mes_emision', $mesEmision, PDO::PARAM_INT);
$stmt->bindParam(':year_emision', $yearEmision, PDO::PARAM_INT);
$stmt->bindParam(':mes_anterior', $mesAnterior, PDO::PARAM_INT);
$stmt->bindParam(':year_anterior', $yearAnterior, PDO::PARAM_INT);
$stmt->bindParam(':mes_antes_anterior', $mesAntesDeAnterior, PDO::PARAM_INT);
$stmt->bindParam(':year_antes_anterior', $yearAntesDeAnterior, PDO::PARAM_INT);

$stmt->execute();

// Obtener los resultados
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result) {
    echo json_encode($result);
} else {
    echo json_encode([
        'lectura_1' => '--',
        'lectura_2' => '--',
        'lectura_3' => '--'
    ]);
}
?>
