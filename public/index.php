<?php
require_once __DIR__. '/../app/controllers/FacturaController.php';

$controller = new FacturaController();

$action = $_GET['action'] ?? 'index';

switch ($action) {
    default:
        $controller->index();
        break;
}