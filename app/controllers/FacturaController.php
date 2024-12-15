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
        // Obtener el rol y nombre del usuario desde la sesión
        $rol = $_SESSION['Rol'] ?? 'Desconocido';
        $nombre = $_SESSION['Nombre'] ?? 'Invitado';
    
        // Obtenemos todas las facturas a través del modelo
        $facturas = $this->factura->getAll(); // Recupera todos los registros sin paginación
    
        // Enviar las facturas completas a la vista
        $currentFacturas = $facturas; // Todas las facturas disponibles
    
        // Cargar la vista correspondiente
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