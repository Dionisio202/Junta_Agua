<?php
// app/controllers/FacturaController.php

require_once '../models/Factura.php';

class FacturaController {
    public function index() {
        // Obtiene todas las facturas usando el modelo
        $facturas = Factura::getAll();
        require_once '../views/factura/index.php';
    }

    public function create() {
        // Muestra el formulario para crear una nueva factura
        require_once '../views/factura/create.php';
    }

    public function store($data) {
        // Guarda una nueva factura en la base de datos
        Factura::create($data);
        header('Location: /index.php');
    }

    public function delete($id) {
        // Elimina una factura
        Factura::delete($id);
        header('Location: /index.php');
    }
}