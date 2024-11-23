<?php
// app/controllers/FacturaController.php

require_once __DIR__ . '/../models/Factura.php';
require_once __DIR__ . '/../../config/database.php';

class FacturaController {
    private $factura;

    public function __construct() {
        // Crear la conexión a la base de datos y pasarla al modelo Factura
        $database = new Database();
        $db = $database->getConnection();
        $this->factura = new Factura($db);
    }

    public function index() {
        $rol = $_SESSION['Rol'] ?? 'Desconocido';
        $nombre = $_SESSION['Nombre'] ??'Invitado';
        // Obtenemos todas las facturas a través del modelo
        $facturas = $this->factura->getAll();
        $totalFacturas = count($facturas);
        $itemsPerPage = 5;
        $totalPages = ceil($totalFacturas / $itemsPerPage);
        
        // Página actual y cálculo de índices
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($currentPage < 1) $currentPage = 1;
        if ($currentPage > $totalPages) $currentPage = $totalPages;

        $startIndex = ($currentPage - 1) * $itemsPerPage;
        $currentFacturas = array_slice($facturas, $startIndex, $itemsPerPage);

        // Pasamos las variables necesarias a la vista
        require_once __DIR__ . '/../views/factura/index.php';
    }
    public function deleteFactura($id) {
        if ($this->factura->delete($id)) {
            echo "Factura eliminada correctamente.";
        } else {
            echo "Error al eliminar la factura.";
        }
    }
    public function nuevafactura() {
        $rol = $_SESSION['Rol'] ?? 'administrador';
        require_once __DIR__ . '/../views/factura/nuevafactura.php';
    }
    public function autorizaciones() {
        $rol = $_SESSION['Rol'] ?? 'administrador';
        $nombre = $_SESSION['Nombre'] ??'Invitado';

        require_once __DIR__ . '/../views/autorizaciones/index.php';
    }
}