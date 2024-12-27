<?php
// app/models/Razones.php
require_once __DIR__ . "/../../config/database.php";

class Razon
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
        $query = "SELECT * FROM razones";

        // Preparar la consulta
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }
}