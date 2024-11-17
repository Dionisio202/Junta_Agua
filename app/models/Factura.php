<?php
// app/models/Factura.php
require_once __DIR__ . "/../../config/database.php";

class Factura
{
    private $conn;

    // Constructor que recibe la conexión a la base de datos
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Método para obtener todas las facturas
    public function getAll()
    {
        // Consulta para obtener las facturas junto con la información del cliente
        $query = "SELECT f.id, c.nombre_comercial, c.identificacion, c.telefono1, f.fecha_emision AS detalle, f.total, f.estado_factura 
                  FROM facturas f
                  JOIN clientes c ON f.cliente = c.id";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getById($id)
    {
        // Consulta para obtener una factura por su ID
        $stmt = $this->conn->prepare('SELECT * FROM factura WHERE idfactura = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByIDClientid($id)
    {
        // Consulta para obtener una factura por su ID
        $stmt = $this->conn->prepare('SELECT * FROM factura WHERE idcliente = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function delete($id)
    {
        // Consulta para eliminar una factura por su ID
        $stmt = $this->conn->prepare('DELETE FROM factura WHERE idfactura = :id');
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function getLastFactura()
    {
        // Consulta para obtener la última factura registrada
        $stmt = $this->conn->prepare('SELECT id FROM facturas ORDER BY id DESC LIMIT 1');
        $stmt->execute();
        // Verifica si hay resultados y devuelve el ID como entero
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return (int) $result['id']; // Convertir a entero antes de retornar
        }
        // Si no hay facturas registradas, devuelve 0
        return 0;
    }
}
