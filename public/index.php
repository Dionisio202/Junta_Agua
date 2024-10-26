<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interfaz de Junta de Agua</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
    <div class="container">
        <!-- Menú Lateral -->
        <aside class="sidebar">
            <h2>Nombre SW</h2>
            <nav>
                <a href="?view=factura/index">Facturas</a>
                <a href="?view=factura/landing">Landing</a>
                <a href="?view=pagos">Pagos</a>
                <a href="?view=reporte">Reportería</a>
                <a href="?view=gestion_usuarios">Gestión de Usuarios</a>
            </nav>
        </aside>

        <!-- Contenido Principal -->
        <main class="main-content">
            <?php
            // Cargar vistas dinámicamente según el parámetro 'view'
            $view = $_GET['view'] ?? 'factura/index'; // Vista por defecto
            $viewFile = "../app/views/{$view}.php";

            if (file_exists($viewFile)) {
                include($viewFile);
            } else {
                echo "<p>Vista no encontrada.</p>";
            }
            ?>
        </main>
    </div>
</body>
</html>
