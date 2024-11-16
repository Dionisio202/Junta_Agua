<?php
require_once '../app/models/User.php';
require_once '../config/database.php';

class AuthController {
    private $db;
    private $userModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->userModel = new User($this->db);
    }

    public function perfil() {
        // Verifica si el usuario está logueado
        session_start();
        if (isset($_SESSION['Cedula'])) {
            // Cargar datos del usuario desde la sesión
            $usuario = [
                'cedula' => $_SESSION['Cedula'],
                'rol' => $_SESSION['Rol'],
                'nombre' => $_SESSION['Nombre'],
                'apellido' => $_SESSION['Apellido'],
                'correo' => $_SESSION['Correo'],
                
            ];
    
            // Incluye la vista del perfil, pasando los datos del usuario
            include '../app/views/perfil.php';
        } else {
            // Redirigir al login si no está logueado
            header("Location: /Junta_Agua/public/index.php?action=login");
            exit();
        }
    }
  
    
    
    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        header("Location: /Junta_Agua/public/index.php");
    }
}
?>
