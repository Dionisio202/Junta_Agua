<?php
// app/controllers/FacturaController.php

require_once __DIR__ . '/../models/Factura.php';

class FacturaController {
    public function index() {
        // Obtiene todas las facturas usando el modelo
        $facturas = Factura::getAll();
        require_once __DIR__ . '/../views/factura/index.php';
    }
}