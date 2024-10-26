<?php
// app/models/Factura.php
require_once __DIR__ ."/../../config/databas.php";

class Factura {
    private $conn;

    // Constructor que recibe la conexión a la base de datos
    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para obtener todas las facturas
    public function getAll() {
        // Consulta para obtener todas las facturas
        $stmt = $this->conn->query('SELECT * FROM factura');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getById($id) {
        // Consulta para obtener una factura por su ID
        $stmt = $this->conn->prepare('SELECT * FROM factura WHERE idfactura = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByIDClientid($id) {
        // Consulta para obtener una factura por su ID
        $stmt = $this->conn->prepare('SELECT * FROM factura WHERE idcliente = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
