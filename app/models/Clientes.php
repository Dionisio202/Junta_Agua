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

    // Obtener clientes por nombre
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

    // Obtener clientes por cédula
    public function getClientsByCedula($cedula)
{
    try {
        // Crear una consulta para obtener los datos del cliente por nombre y cédula
        $query = "SELECT id, identificacion, razon_social, nombre_comercial, direccion, telefono1, telefono2 
                  FROM clientes 
                  WHERE identificacion LIKE :cedula";

        // Preparar la consulta
        $stmt = $this->conn->prepare($query);

        // Agregar comodines al patrón de búsqueda
        $likePatternCedula = '%' . $cedula . '%';

        // Vincular los parámetros
        $stmt->bindParam(':cedula', $likePatternCedula, PDO::PARAM_STR);

        // Ejecutar la consulta
        $stmt->execute();

        // Devolver los resultados como un array asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        // Manejar errores y devolver un mensaje significativo
        return ["error" => "Error al buscar clientes por nombre y cédula: " . $e->getMessage()];
    }
}



    public function getClientById($id)
{
    try {
        $query = "SELECT id, identificacion, razon_social, direccion, telefono1, telefono2 FROM clientes WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        return ["error" => "Error al obtener cliente por ID: " . $e->getMessage()];
    }
}

public function agregarCliente($identificacion, $razon_social, $direccion, $telefono1, $telefono2, $correo) {
    $query = "INSERT INTO clientes (
                identificacion, razon_social, nombre_comercial, direccion, telefono1, telefono2,
                correo, tarifa, grupo, zona, ruta, vendedor, cobrador, provincia, ciudad, parroquia
              ) 
              VALUES (
                :identificacion, :razon_social, 'N/A', :direccion, :telefono1, :telefono2,
                :correo, 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A'
              )";
    
    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(':identificacion', $identificacion);
    $stmt->bindParam(':razon_social', $razon_social);
    $stmt->bindParam(':direccion', $direccion);
    $stmt->bindParam(':telefono1', $telefono1);
    $stmt->bindParam(':telefono2', $telefono2);
    $stmt->bindParam(':correo', $correo);


    return $stmt->execute();
}

public function obtenerClientePorId($id) {
    $query = "SELECT id, identificacion, razon_social, direccion, telefono1, telefono2, correo 
              FROM clientes 
              WHERE id = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function editarCliente($id, $identificacion, $razon_social, $direccion, $telefono1, $telefono2, $correo)
{
    try {
        $query = "UPDATE clientes 
                  SET identificacion = :identificacion, razon_social = :razon_social, direccion = :direccion, 
                      telefono1 = :telefono1, telefono2 = :telefono2, correo = :correo
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':identificacion', $identificacion);
        $stmt->bindParam(':razon_social', $razon_social);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':telefono1', $telefono1);
        $stmt->bindParam(':telefono2', $telefono2);
        $stmt->bindParam(':correo', $correo);

        return $stmt->execute();
    } catch (Exception $e) {
        return ["error" => "Error al actualizar cliente: " . $e->getMessage()];
    }
}

public function eliminarCliente($id)
{
    try {
        // Crear una consulta para eliminar el cliente
        $query = "DELETE FROM clientes WHERE id = :id";
        
        // Preparar la consulta
        $stmt = $this->conn->prepare($query);
        
        // Vincular el parámetro
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        // Ejecutar la consulta
        return $stmt->execute();
    } catch (Exception $e) {
        return ["error" => "Error al eliminar cliente: " . $e->getMessage()];
    }
}


public function getClientsBySearch($buscar)
{
    $query = "SELECT * FROM clientes 
              WHERE identificacion LIKE :buscar OR 
                    razon_social LIKE :buscar OR 
                    direccion LIKE :buscar";

    $stmt = $this->conn->prepare($query);
    $stmt->bindValue(':buscar', "%$buscar%", PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



}
?>