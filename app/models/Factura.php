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
            c.razon_social, 
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
            LPAD(f.id, 9, '0') AS secuencia, 
            f.fecha_emision,
            f.fecha_vencimiento,
            f.id_sucursal,
            f.estado_factura,
            f.tipo_pago,
            f.valor_sin_impuesto,
            f.iva,
            f.total,
            f.medidor_id,
            c.identificacion AS ci_ruc,
            c.razon_social AS cliente,
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

    public function getDetalleFacturaById($facturaId)
{
    $query = "
    SELECT 
        r.codigo AS codigo,
        df.descripcion AS descripcion,
        df.subtotal AS total ,
        df.descuento AS Descuento,
        df.cantidad AS cantidad,
        df.precioIVA AS precio
    FROM 
        detalle_factura df
    JOIN 
        razones r ON df.id_razon = r.id
    WHERE 
        df.id_factura = :facturaId
    ";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':facturaId', $facturaId, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna todos los detalles relacionados
}

    public function saveFactura($factura) {
        try {
            // Consulta SQL corregida
            $query = "INSERT INTO facturas (
                fecha_emision, 
                fecha_autorizacion, 
                fecha_vencimiento,
                id_sucursal, 
                facturador, 
                cliente, 
                medidor_id, 
                estado_factura, 
                tipo_pago, 
                valor_sin_impuesto, 
                iva, 
                total
            ) VALUES (
                :fecha_emision, 
                :fecha_autorizacion,
                :fecha_vencimiento, 
                :id_sucursal, 
                :facturador, 
                :cliente, 
                :medidor_id, 
                :estado_factura, 
                :tipo_pago, 
                :valor_sin_impuesto, 
                :iva, 
                :total
            )";
    
            // Preparar la consulta
            $stmt = $this->conn->prepare($query);
    
            // Asociar parámetros
            $stmt->bindValue(':fecha_emision', $factura['fecha_emision'], PDO::PARAM_STR);
            $stmt->bindValue(':fecha_autorizacion', $factura['fecha_autorizacion'] ?? null, PDO::PARAM_STR); // Campo opcional
            $stmt->bindValue(':fecha_vencimiento', $factura['fecha_vencimiento'], PDO::PARAM_STR);
            $stmt->bindValue(':id_sucursal', $factura['id_sucursal'], PDO::PARAM_INT);
            $stmt->bindValue(':facturador', $factura['facturador'], PDO::PARAM_INT);
            $stmt->bindValue(':cliente', $factura['cliente'], PDO::PARAM_INT);
            $stmt->bindValue(':medidor_id', $factura['medidor_id'], PDO::PARAM_INT);
            $stmt->bindValue(':estado_factura','Sin autorizar', PDO::PARAM_STR);
            $stmt->bindValue(':tipo_pago', $factura['tipo_pago'] ?? 'efectivo', PDO::PARAM_STR);
            $stmt->bindValue(':valor_sin_impuesto', $factura['valor_sin_impuesto'], PDO::PARAM_STR);
            $stmt->bindValue(':iva', $factura['iva'], PDO::PARAM_STR);
            $stmt->bindValue(':total', $factura['total'], PDO::PARAM_STR);
    
            // Ejecutar la consulta
            if ($stmt->execute()) {
                return [
                    "success" => true,
                    "message" => "Factura guardada exitosamente",
                    "id_factura" => $this->conn->lastInsertId()
                ];
            } else {
                return [
                    "success" => false,
                    "message" => "Error al guardar la factura"
                ];
            }
        } catch (PDOException $e) {
            return [
                "success" => false,
                "message" => "Error en la base de datos: " . $e->getMessage()
            ];
        }
    }
    
    
    public function saveDetalleFactura($idFactura, $detalles) {
        try {
            // Convertir el array de detalles a JSON
            $detallesJSON = json_encode($detalles);
    
            // Preparar la llamada al procedimiento almacenado
            $query = "CALL InsertDetalleFactura(:idFactura, :detallesJSON)";
            $stmt = $this->conn->prepare($query);
    
            // Vincular los parámetros
            $stmt->bindParam(':idFactura', $idFactura, PDO::PARAM_INT);
            $stmt->bindParam(':detallesJSON', $detallesJSON, PDO::PARAM_STR);
    
            // Ejecutar la consulta
            if ($stmt->execute()) {
                return [
                    'status' => 'success',
                    'message' => 'Detalles insertados correctamente.'
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'Error al insertar detalles.'
                ];
            }
        } catch (PDOException $e) {
            return [
                'status' => 'error',
                'message' => 'Excepción capturada: ' . $e->getMessage()
            ];
        }
    }   
}
