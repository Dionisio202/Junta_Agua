<?php
require_once __DIR__ . "/../../config/database.php";
require_once __DIR__ . "/../models/Clientes.php";

$database = new Database();
$db = $database->getConnection();

$cliente = new Cliente($db);

// Recuperar el término de búsqueda
$buscar = isset($_GET['buscar']) ? htmlspecialchars($_GET['buscar']) : '';

if ($buscar) {
    // Realizar la búsqueda en la base de datos por Identificación o Razón Social
    $query = "SELECT * FROM clientes WHERE identificacion LIKE :buscar OR razon_social LIKE :buscar";
    $stmt = $db->prepare($query);
    
    // Preparamos el término de búsqueda con los '%' para realizar una búsqueda parcial
    $buscar_param = "%$buscar%";  // Esto permite que busque cualquier término que contenga lo que se ha escrito
    
    $stmt->bindParam(':buscar', $buscar_param);
    $stmt->execute();

    // Recuperar los resultados de la búsqueda
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Si no se realiza búsqueda, mostrar todos los clientes
    $query = "SELECT * FROM clientes";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!-- Mostrar los resultados de la búsqueda -->
<?php if ($resultados): ?>
    <table>
        <thead>
            <tr>
                <th>Identificación</th>
                <th>Razón Social</th>
                <th>Email</th>
                <th>Teléfono</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($resultados as $cliente): ?>
                <tr>
                    <td><?php echo htmlspecialchars($cliente['identificacion']); ?></td>
                    <td><?php echo htmlspecialchars($cliente['razon_social']); ?></td>
                    <td><?php echo htmlspecialchars($cliente['email']); ?></td>
                    <td><?php echo htmlspecialchars($cliente['telefono']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No se encontraron resultados.</p>
<?php endif; ?>
