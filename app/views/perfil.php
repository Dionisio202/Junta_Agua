<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <link rel="stylesheet" href="/Junta_Agua/public/styles/perfil.css">
</head>
<body>
    <div class="container">
        <div class="profile-card">
            <div class="profile-header">
                <div class="profile-image">
                    <img src="/Junta_Agua/public/img/user1.png" alt="Foto de Perfil" class="user-photo">
                </div>
                <h1>Hola, <span><?= htmlspecialchars($usuario['nombre']); ?> <?= htmlspecialchars($usuario['apellido']); ?></span></h1>
                <p class="user-role">Rol: <span><?= htmlspecialchars($usuario['rol']); ?></span></p>
            </div>

            <div class="user-details">
                <div class="user-info">
                    <div class="info-item">
                        <strong>Cédula:</strong> <span><?= htmlspecialchars($usuario['cedula']); ?></span>
                    </div>
                    <div class="info-item">
                        <strong>Correo:</strong> <span><?= htmlspecialchars($usuario['correo']); ?></span>
                    </div>
                </div>
                <div class="user-actions">
                    <a href="/Junta_Agua/public/index.php?action=editProfile" class="edit-profile-btn">Editar Perfil</a>
                    <a href="/Junta_Agua/public/index.php?action=logout" class="logout-btn">Cerrar Sesión</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
