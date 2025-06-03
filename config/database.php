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
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4";
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Asegurarse de que las interacciones posteriores también usen utf8mb4
            $this->conn->exec("SET NAMES 'utf8mb4'");
        } catch(PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>
