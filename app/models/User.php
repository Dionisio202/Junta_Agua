<?php
require_once __DIR__ . '/../../config/database.php';

class User
{
    private $conn;
    private $table_name = "usuarios";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function createUser($nombre, $password, $rol = 'Admin') {
        $query = "INSERT INTO " . $this->table_name . " (nombre, clave, rol) VALUES (:nombre, :clave, :rol)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":clave", password_hash($password, PASSWORD_DEFAULT));
        $stmt->bindParam(":rol", $rol);

        return $stmt->execute();
    }

    public function authenticateUser($cedula, $password) {
        $query = "SELECT nombre, rol, id, apellido, correo FROM " . $this->table_name . " WHERE cedula = :cedula AND clave = :clave LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":cedula", $cedula);
        $stmt->bindParam(":clave", $password); // Contraseña sin cifrar
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row; // Devuelve un array con el nombre y rol si la autenticación es exitosa
        }
        return false;
    }
    public function getUserData($id)
    {
        $query = "SELECT id, nombre, apellido, rol FROM " . $this->table_name . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT); // Forzar el ID como entero
        $stmt->execute();
    
        // Retornar los datos si existen
        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna como array asociativo
        }
        return false; // Retorna false si no encuentra resultados
    }
    
}
?>