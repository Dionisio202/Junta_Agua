<?php
// app/controllers/FacturaController.php

require_once __DIR__ . '/../models/Factura.php';
require_once __DIR__ . '/../../config/database.php';

class AutorizacionController {
    private $factura;

    public function __construct() {
        // Crear la conexión a la base de datos y pasarla al modelo Factura
        $database = new Database();
        $db = $database->getConnection();
        $this->factura = new Factura($db);
    }
    public function deleteFactura($id) {
        if ($this->factura->delete($id)) {
            echo "Factura eliminada correctamente.";
        } else {
            echo "Error al eliminar la factura.";
        }
    }
    public function vista() {
        $rol = $_SESSION['Rol'] ?? 'Administrador';
        require_once __DIR__ . '/../views/autorizaciones/index.php';
    }
}