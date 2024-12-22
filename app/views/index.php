<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Inicia la sesión solo si no está activa
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar</title>
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap">
</head>
<body>
    <div class="container">
        <!-- Botón de alternancia del menú -->
        <input type="checkbox" id="toggler" class="sidebar-toggler">
        <label for="toggler" class="toggle-btn"><i class="fas fa-bars"></i></label>
        
        <!-- Menú Lateral -->
        <aside id="sidebar" class="sidebar">
            <div class="sidebar-header">
                        <!-- Esto no se esta usando corregir se esta usando el index dentro de factura -->
                <h2 class="sidebar-rol"><?= htmlspecialchars($_SESSION['Rol'] ?? 'Invitado'); ?></h2>
                <h2 class="sidebar-nombre"><?= htmlspecialchars($_SESSION['Cedula'] ?? 'edison'); ?></h2>
            </div>
            <nav class="sidebar-nav">
                <a href="?view=factura/landing" class="sidebar-link"><i class="fas fa-home"></i> <span>Landing</span></a>
                <a href="?view=factura/index" class="sidebar-link"><i class="fas fa-file-invoice"></i> <span>Facturas</span></a>
                <a href="?view=autorizaciones" class="sidebar-link"><i class="fas fa-users"></i> <span>Autorizaciones</span></a>
                <a href="?view=pagos" class="sidebar-link"><i class="fas fa-credit-card"></i> <span>Pagos</span></a>
                <a href="?view=reporte" class="sidebar-link"><i class="fas fa-chart-line"></i> <span>Reportería</span></a>
                <a href="?view=gestion_usuarios" class="sidebar-link"><i class="fas fa-users"></i> <span>Gestión de Usuarios</span></a>
                <a href="?view=perfil" class="sidebar-link"><i class="fas fa-user-circle "></i> <span>Perfil</span></a>
                <a href="?view=mediciones/nuevamedicion" class="sidebar-link"><i class="fas fa-tachometer-alt"></i> <span>Nueva Medición</span>
</a>

            </nav>
            <div class="sidebar-footer">
                <a href="index.php?action=logout" class="sidebar-link"><i class="fas fa-sign-out-alt"></i> <span>Salir</span></a>
            </div>
        </aside>

        <!-- Contenido Principal -->
        <main class="main-content">
            <?php include 'content.php'; ?>
        </main>
    </div>
</body>
</html>
