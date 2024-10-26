<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/styles/login.css">
    <title>Inicio de Sesión</title>
</head>

<body>
    <header>
        <!-- Opcional: Puedes añadir elementos de encabezado aquí -->
    </header>

    <section class="login-section">
        <div class="login-container">
            <div class="login-card">
                <h1><img class="logo"></h1>
                <h2>Bienvenid@</h2>
                <h5>Inicie sesión para acceder a los beneficios del sistema</h5>
                
                <!-- Formulario de inicio de sesión -->
                <form action="index.php?action=login" method="post">
                    <input type="text" id="username" name="username" placeholder="Cédula de Identidad" required>
                    <input type="password" id="password" name="password" placeholder="Contraseña" required>
                    <button type="submit">Iniciar Sesión</button>
                </form>
                
                <!-- Mensaje de error si las credenciales son incorrectas -->
                <?php
                if (isset($_GET['error']) && $_GET['error'] == 'invalid') {
                    echo "<p style='color:red; text-align: center;'>Usuario o contraseña incorrectos.</p>";
                }
                ?>
            </div>
        </div>
    </section>
</body>
</html>
