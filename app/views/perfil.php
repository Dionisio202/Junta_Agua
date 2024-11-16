<?php
// Los datos del usuario deben ser pasados desde el controlador, como se muestra en el controlador.
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <link rel="stylesheet" href="/Junta_Agua/public/css/styles.css">
</head>
<body>
    <div class="profile-container" aria-label="Perfil del Usuario">
        <div class="user-info">
            <!-- Muestra el rol del usuario -->
            <span class="user-role"><?= htmlspecialchars($usuario['rol']); ?></span>

            <!-- Muestra el nombre completo del usuario -->
            <span class="user-name"><?= htmlspecialchars($usuario['nombre'] . ' ' . $usuario['apellido']); ?></span>
        </div>

        <div class="user-details">
            <h2>Información del Usuario</h2>
            <p><strong>Cédula:</strong> <?= htmlspecialchars($usuario['cedula']); ?></p>
            <p><strong>Correo:</strong> <?= htmlspecialchars($usuario['correo']); ?></p>
            <p><strong>Teléfono:</strong> <?= htmlspecialchars($usuario['telefono']); ?></p>
     
        </div>

        <div class="user-actions">
            <!-- Enlace o botón para editar perfil (si lo deseas) -->
            <a href="?view=perfil&action=edit" class="edit-profile-btn">Editar Perfil</a>
        </div>
    </div>

</body>
</html>
