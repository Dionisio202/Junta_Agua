<?php
class Database {
    private $host = "facturaqua.com";
    private $db_name = "faqua2085_junta_agua";
    private $username = "faqua2085_junta_agua";
    private $password = "kfP9x8hCtCY9TxsPxkpe";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            // Establece la conexión usando PDO
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }
        return $this->conn;
    }
    
}
?>