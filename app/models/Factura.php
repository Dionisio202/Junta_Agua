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
        // Consulta para obtener las facturas junto con la información del cliente
        $query = "SELECT f.idfactura, c.nombre, c.cedula, c.telefono, f.fecha_emision AS detalle, f.total, f.estado_pago 
                  FROM factura f
                  JOIN Cliente c ON f.idcliente = c.idcliente";
                  
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
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
    public function delete($id) {
        // Consulta para eliminar una factura por su ID
        $stmt = $this->conn->prepare('DELETE FROM factura WHERE idfactura = :id');
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
