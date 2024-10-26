<?php
session_start(); // Inicia la sesión para poder acceder a $_SESSION

require_once __DIR__ . '/../models/Factura.php';

class FacturaController {
    public function index() {
        // Definir el rol desde la sesión o establecer 'Administrador' como valor predeterminado
        $rol = $_SESSION['rol'] ?? 'Administrador';

        // Imprimir el rol para verificar que se establece correctamente en el controlador
        echo "<pre>Rol en el controlador: ";
        print_r($rol);
        echo "</pre>";

        // Obtener todas las facturas
        $facturas = Factura::getAll();

        // Pasar las variables a la vista
        require_once __DIR__ . '/../views/factura/index.php';
    }
}