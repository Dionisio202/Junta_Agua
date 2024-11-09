<?php
class Database {
    private $host = "localhost";        
    private $db_name = "facturacionvinculacion";      
    private $username = "root";    
    private $password = ""; 
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
