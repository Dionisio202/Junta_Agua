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

    public function login($cedula, $password) {
        $role = $this->userModel->authenticateUser($cedula, $password);
        
        if ($role) {
            session_start();
            $_SESSION['Cedula'] = $cedula;
            $_SESSION['Rol'] = $role;
            header("Location: /Junta_Agua/public/index.php?action=home");
            exit();
        } else {
            // Redirige al formulario de login con el parámetro de error
            header("Location: /Junta_Agua/public/index.php?action=login&error=invalid");
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
