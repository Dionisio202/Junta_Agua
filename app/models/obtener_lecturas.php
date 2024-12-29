<?php
// obtener_lecturas.php
header('Content-Type: application/json');

// Conexión a la base de datos
require_once __DIR__ . '/../../config/database.php';

$database = new Database();
$db = $database->getConnection();

// Obtener el medidor_id y los tres meses de la solicitud GET
$medidorId = isset($_GET['medidor_id']) ? (int)$_GET['medidor_id'] : 0;
$mesEmision = isset($_GET['mes_emision']) ? (int)$_GET['mes_emision'] : 0;
$mesAnterior = isset($_GET['mes_anterior']) ? (int)$_GET['mes_anterior'] : 0;
$mesAntesDeAnterior = isset($_GET['mes_antes_anterior']) ? (int)$_GET['mes_antes_anterior'] : 0;

if ($medidorId === 0 || $mesEmision === 0 || $mesAnterior === 0 || $mesAntesDeAnterior === 0) {
    // Si no se proporcionan los parámetros necesarios, respondemos con un error
    echo json_encode(['error' => 'El medidor_id y los tres meses son necesarios']);
    exit;
}

// Consulta SQL para obtener las lecturas de los tres meses dinámicos
$query = "
SELECT 
    id_medidor,
    MAX(CASE WHEN MONTH(fecha_lectura) = :mes_emision THEN lectura ELSE '--' END) AS lectura_1,
    MAX(CASE WHEN MONTH(fecha_lectura) = :mes_anterior THEN lectura ELSE '--' END) AS lectura_2,
    MAX(CASE WHEN MONTH(fecha_lectura) = :mes_antes_anterior THEN lectura ELSE '--' END) AS lectura_3
FROM 
    detalle_medidores
WHERE 
    id_medidor = :medidor_id  -- Usamos el medidor_id dinámico
    AND YEAR(fecha_lectura) = 2024  -- Cambiar el año si es necesario
    AND MONTH(fecha_lectura) IN (:mes_emision, :mes_anterior, :mes_antes_anterior)  -- Filtramos por los tres meses
GROUP BY 
    id_medidor
";

// Preparar la consulta
$stmt = $db->prepare($query);
$stmt->bindParam(':medidor_id', $medidorId, PDO::PARAM_INT);  // Enlazamos el medidor_id
$stmt->bindParam(':mes_emision', $mesEmision, PDO::PARAM_INT);  // Enlazamos el mes de emisión
$stmt->bindParam(':mes_anterior', $mesAnterior, PDO::PARAM_INT);  // Enlazamos el mes anterior
$stmt->bindParam(':mes_antes_anterior', $mesAntesDeAnterior, PDO::PARAM_INT);  // Enlazamos el mes antes de anterior

$stmt->execute();

// Obtener los resultados
$result = $stmt->fetch(PDO::FETCH_ASSOC);

// Si la consulta devuelve datos, los retornamos como JSON
if ($result) {
    echo json_encode($result);
} else {
    // Si no hay resultados, enviamos un JSON con valores predeterminados
    echo json_encode([
        'lectura_1' => '--',
        'lectura_2' => '--',
        'lectura_3' => '--'
    ]);
}

?>

