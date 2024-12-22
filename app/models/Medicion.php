<?php
require_once __DIR__ ."/../../config/database.php";

class Medicion {
    private $conn;
    private $table = 'lectura';

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para obtener todas las mediciones
    public function getAll() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para obtener las mediciones de un medidor específico
    public function getByMedidor($idmedidor) {
        $query = "SELECT * FROM " . $this->table . " WHERE idmedidor = :idmedidor";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idmedidor', $idmedidor);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para crear una nueva medición
    public function create($data) {
        $query = "INSERT INTO " . $this->table . " (idmedidor, fecha_lectura, lectura_anterior, lectura_actual, consumo_m3, mes_facturado) 
                  VALUES (:idmedidor, :fecha_lectura, :lectura_anterior, :lectura_actual, :consumo_m3, :mes_facturado)";
        
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':idmedidor', $data['idmedidor']);
        $stmt->bindParam(':fecha_lectura', $data['fecha_lectura']);
        $stmt->bindParam(':lectura_anterior', $data['lectura_anterior']);
        $stmt->bindParam(':lectura_actual', $data['lectura_actual']);
        $stmt->bindParam(':consumo_m3', $data['consumo_m3']);
        $stmt->bindParam(':mes_facturado', $data['mes_facturado']);

        return $stmt->execute();
    }

    // Método para obtener el historial de mediciones de un medidor
    public function getHistoryByMedidor($idmedidor) {
        $query = "SELECT * FROM " . $this->table . " WHERE idmedidor = :idmedidor ORDER BY fecha_lectura DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idmedidor', $idmedidor);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para calcular el consumo de agua de un medidor específico
    public function getConsumo($idmedidor) {
        $query = "SELECT lectura_anterior, lectura_actual, (lectura_actual - lectura_anterior) AS consumo_m3 
                  FROM " . $this->table . " WHERE idmedidor = :idmedidor ORDER BY fecha_lectura DESC LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idmedidor', $idmedidor);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
