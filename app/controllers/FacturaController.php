<?php
// app/controllers/FacturaController.php

session_start();
require_once __DIR__ . '/../models/Factura.php';

class FacturaController {
    public function index() {
        $rol = $_SESSION['rol'] ?? 'Administrador';
        
        // Obtenemos todas las facturas
        $facturas = Factura::getAll();
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
}
