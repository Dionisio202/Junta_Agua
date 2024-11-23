<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..\public\styles\login.css">
    <title>Inicio de Sesión</title>
</head>
<body>
    <header>
        <div class="header-logo">
            <img src="../img/Logo1@3x.png" class="logo" >
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
                <img src="../img/Logo1@3x.png" class="form-logo" alt="Logo del sistema">
                <h2>Bienvenid@</h2>
                <p>Inicie sesión para acceder a los beneficios del sistema</p>
                <form action="index.php?action=login" method="post">
                    <input type="text" id="username" name="username" placeholder="Cédula de Identidad" required>
                    <input type="password" id="password" name="password" placeholder="Contraseña" required>
                    <a href="#" class="forgot-password">Recuperar Contraseña</a>
                    <button type="submit">Iniciar Sesión</button>
                </form>
                <?php
                if (isset($_GET['error']) && $_GET['error'] == 'invalid') {
                    echo "<p class='error-message'>Cédula o contraseña incorrectos.</p>";
                }
                ?>
            </div>
        </div>
    </section>
</body>
</html>
