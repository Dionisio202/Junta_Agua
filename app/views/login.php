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
    <div class="header-logo">
            <img src="../img/LOGO.png" alt="j" class="logo">
        </div>
        <nav class="header-nav">
            <ul>
                
                <li><a href="#help" class="login-button">Ayuda</a></li>
            </ul>
        </nav>
    </header>

    <section class="login-section">
        <div class="login-container">
            <div class="login-card">
                <img class="logo" alt="">
                <h2>Bienvenid@</h2>
                <h5>Inicie sesión para acceder a los beneficios del sistema</h5>
                <br>
                <!-- Formulario de inicio de sesión -->
                <form action="index.php?action=login" method="post">
                    <input type="text" id="username" name="username" placeholder="Cédula de Identidad" required>
                    <input type="password" id="password" name="password" placeholder="Contraseña" required>
                    <h5>Recuperar Contraseña</h5>
                    <button type="submit">Iniciar Sesión</button>
                </form>
                
                <!-- Mensaje de error si las credenciales son incorrectas -->
                <?php
                if (isset($_GET['error']) && $_GET['error'] == 'invalid') {
                    echo "<p style='color:red; text-align: center;'>Cédula o contraseña incorrectos.</p>";
                }
                ?>
            </div>
        </div>
    </section>
</body>
</html>
