<?php
require_once __DIR__ . "/../../config/database.php";

class Cliente
{
    private $conn;

    // Constructor que recibe la conexión a la base de datos
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getClientsByName($nombre)
    {
        try {
            // Crear una consulta para obtener los datos del cliente por nombre
            $query = "SELECT id, identificacion, razon_social, nombre_comercial, direccion, telefono1, telefono2 
                      FROM clientes 
                      WHERE razon_social LIKE :nombre";

            // Preparar la consulta
            $stmt = $this->conn->prepare($query);

            // Agregar comodines al patrón de búsqueda
            $likePattern = '%' . $nombre . '%';
            $stmt->bindParam(':nombre', $likePattern, PDO::PARAM_STR);

            // Ejecutar la consulta
            $stmt->execute();

            // Devolver los resultados como un array asociativo
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            // Manejar errores y devolver un mensaje significativo
            return ["error" => "Error al buscar clientes por nombre: " . $e->getMessage()];
        }
    }

    public function getClientsByCedula($cedula)
    {
        try {
            // Crear una consulta para obtener los datos del cliente por cédula
            $query = "SELECT id, identificacion, razon_social, nombre_comercial, direccion, telefono1, telefono2 
                      FROM clientes 
                      WHERE identificacion LIKE :cedula";

            // Preparar la consulta
            $stmt = $this->conn->prepare($query);

            // Agregar comodines al patrón de búsqueda
            $likePattern = '%' . $cedula . '%';
            $stmt->bindParam(':cedula', $likePattern, PDO::PARAM_STR);

            // Ejecutar la consulta
            $stmt->execute();

            // Devolver los resultados como un array asociativo
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            // Manejar errores y devolver un mensaje significativo
            return ["error" => "Error al buscar clientes por cédula: " . $e->getMessage()];
        }
    }
}