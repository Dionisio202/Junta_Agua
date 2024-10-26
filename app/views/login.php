<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/styles/login.css">
</head>

<body>
    <header>

    </header>
    <section>

    </section>
    <section class="login-section">
        <div class="login-container"> <!-- Nuevo contenedor -->
            <div class="login-card">
            <h1>poner logo</h1>
            <img class="logo" />
            <h2>Bienvenid@</h2>
            <h5>Inicie sesión para acceder a los beneficios del sistema</h5>
                <form action="login.php" method="POST">
                    <input type="text" id="username" name="username" placeholder="Cédula de Identidad" required>
                    <input type="password" id="password" name="password" placeholder="Contraseña" required>

                    <button type="submit">Iniciar Sesión</button>
                </form>
            </div>
        </div>
    </section>


</body>

</html>