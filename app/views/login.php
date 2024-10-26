<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
</head>
<body>
    <h2>Iniciar Sesión</h2>
    <form action="index.php?action=login" method="post">
        <label for="username">Usuario:</label>
        <input type="text" id="username" name="username" required><br><br>
        
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required><br><br>
        
        <button type="submit">Entrar</button>
    </form>
    
    <?php
    // Mostrar un mensaje de error si las credenciales son incorrectas
    if (isset($_GET['error']) && $_GET['error'] == 'invalid') {
        echo "<p style='color:red;'>Usuario o contraseña incorrectos.</p>";
    }
    ?>
</body>
</html>
