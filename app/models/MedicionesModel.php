<?php
class MedicionesModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function registrarMedicion($idMedidor, $idCliente, $fechaLectura, $lectura) {
        try {
            $query = "INSERT INTO detalle_medidores (id_medidor, id_usuario, fecha_lectura, lectura) 
                      VALUES (:id_medidor, :id_cliente, :fecha_lectura, :lectura)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_medidor', $idMedidor, PDO::PARAM_INT);
            $stmt->bindParam(':id_cliente', $idCliente, PDO::PARAM_INT);
            $stmt->bindParam(':fecha_lectura', $fechaLectura, PDO::PARAM_STR);
            $stmt->bindParam(':lectura', $lectura, PDO::PARAM_STR);
    
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error al registrar medición: " . $e->getMessage());
            return false;
        }
    }
    

    public function obtenerMediciones() {
        $query = "SELECT dm.id_detalle, m.nro_medidor, c.identificacion, dm.fecha_lectura, dm.lectura
                  FROM detalle_medidores dm
                  JOIN medidores m ON dm.id_medidor = m.id
                  JOIN clientes c ON m.id_cliente = c.id";
        $stmt = $this->conn->query($query);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
