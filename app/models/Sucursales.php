<?php
// app/models/Factura.php
require_once __DIR__ . "/../../config/database.php";

class Sucursal
{
    private $conn;

    // Constructor que recibe la conexión a la base de datos
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll()
    {
        // Consulta para obtener todas las sucursales
        $query = "SELECT * FROM sucursales";

        // Preparar la consulta
        $stmt = $this->conn->prepare($query);

        // Ejecutar la consulta
        $stmt->execute();

        // Devolver el resultado de la consulta
        return $stmt;
    }
}