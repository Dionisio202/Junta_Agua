<?php
require_once __DIR__ . '/../models/Medicion.php';
require_once __DIR__ . '/../../config/database.php';

class MedicionController {
    private $medicion;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->medicion = new Medicion($db);
    }

    // Mostrar todas las mediciones
    public function index() {
        $mediciones = $this->medicion->getAll();
        include '../app/views/registro_mediciones.php';
    }

    // Mostrar las mediciones de un medidor específico
    public function show($idmedidor) {
        $mediciones = $this->medicion->getByMedidor($idmedidor);
        include '../app/views/registro_mediciones.php';
    }

    // Registrar una nueva medición
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'idmedidor' => $_POST['idmedidor'],
                'fecha_lectura' => $_POST['fecha_lectura'],
                'lectura_anterior' => $_POST['lectura_anterior'],
                'lectura_actual' => $_POST['lectura_actual'],
                'consumo_m3' => $_POST['consumo_m3'],
                'mes_facturado' => $_POST['mes_facturado']
            ];
    
            if ($this->medicion->create($data)) {
                header("Location: index.php?view=mediciones/registro");
                exit();
            } else {
                echo "<p>Error al registrar la medición.</p>";
            }
        }
    }
    
    
    // Mostrar el formulario para una nueva medición
public function create() {
    include __DIR__ . '/../views/nueva_medicion.php'; // Crear este archivo si no existe
}



}
?>
