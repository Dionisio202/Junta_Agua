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
        $query = "
        SELECT 
            f.*, 
            c.nombre_comercial, 
            c.identificacion, 
            c.telefono1, 
            c.telefono2, 
            m.nro_medidor 
        FROM facturas f
        JOIN clientes c ON f.cliente = c.id
        JOIN medidores m ON c.id = m.id_cliente AND f.medidor_id = m.id
    ";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getById($id)
    {
        // Consulta para obtener una factura por su ID
        $stmt = $this->conn->prepare('SELECT * FROM facturas WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByIDClientid($id)
    {
        // Consulta para obtener una factura por su ID
        $stmt = $this->conn->prepare('SELECT * FROM facturas WHERE cliente = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function delete($id)
    {
        // Consulta para eliminar una factura por su ID
        $stmt = $this->conn->prepare('DELETE FROM facturas WHERE id = :id');
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
    public function getFacturaDetailsById($id)
    {
        $query = "
        SELECT 
            f.id AS secuencia,
            f.fecha_emision,
            f.fecha_vencimiento,
            f.id_sucursal,
            f.estado_factura,
            f.tipo_pago,
            f.valor_sin_impuesto,
            f.iva,
            f.total,
            c.identificacion AS ci_ruc,
            c.nombre_comercial AS cliente,
            c.telefono1,
            c.telefono2,
            c.correo,
            c.direccion
        FROM 
            facturas f
        JOIN 
            clientes c ON f.cliente = c.id
        WHERE 
            f.id = :id
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna una sola fila
    }
}
