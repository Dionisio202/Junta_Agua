<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Mediciones</title>
    <link rel="stylesheet" href="styles/mediciones.css">
</head>
<body>
    <!-- <div class="user-info">
        <span class="user-role"><?= htmlspecialchars($rol); ?></span>
        <span class="user-name"><?= htmlspecialchars($nombre ?? 'Usuario'); ?></span>
    </div> -->

<div>
    <div class="table-container">


    <div class="container2">
    <h1>Registro de Mediciones</h1>

    <!-- Formulario para registrar nueva medición -->
    <form>
        <!-- Primer grupo de campos (ID Medidor, Fecha, Lectura Anterior) -->
        <div class="form-group flex-group">
            <div class="form-item">
                <label for="idmedidor">ID del Medidor</label>
                <input type="text" name="idmedidor" id="idmedidor" class="form-control" required>
            </div>
            <div class="form-item">
                <label for="fecha_lectura">Fecha de Lectura</label>
                <input type="date" name="fecha_lectura" id="fecha_lectura" class="form-control" required>
            </div>
            <div class="form-item">
                <label for="lectura_anterior">Lectura Anterior</label>
                <input type="number" name="lectura_anterior" id="lectura_anterior" class="form-control" step="0.01" required>
            </div>
        </div>

        <!-- Segundo grupo de campos (Lectura Actual, Consumo y Mes Facturado) -->
        <div class="form-group flex-group">
            <div class="form-item">
                <label for="lectura_actual">Lectura Actual</label>
                <input type="number" name="lectura_actual" id="lectura_actual" class="form-control" step="0.01" required>
            </div>
            <div class="form-item">
                <label for="consumo_m3">Consumo en m3</label>
                <input type="number" name="consumo_m3" id="consumo_m3" class="form-control" step="0.01" required>
            </div>
            <div class="form-item">
                <label for="mes_facturado">Mes Facturado</label>
                <input type="text" name="mes_facturado" id="mes_facturado" class="form-control" required>
            </div>
        </div>
        
        <button type="submit" class="btn btn-primary">Registrar Medición</button>
    </form>

    <!-- Lista de Mediciones (Colocada abajo) -->
    <h2>Lista de Mediciones</h2>
    <table class="table">
        <thead>
            <tr>
                <th>ID Medidor</th>
                <th>Fecha Lectura</th>
                <th>Lectura Anterior</th>
                <th>Lectura Actual</th>
                <th>Consumo (m3)</th>
                <th>Mes Facturado</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>001</td>
                <td>2024-12-01</td>
                <td>150.75</td>
                <td>180.50</td>
                <td>29.75</td>
                <td>Diciembre</td>
            </tr>
            <tr>
                <td>002</td>
                <td>2024-12-05</td>
                <td>200.30</td>
                <td>220.10</td>
                <td>19.80</td>
                <td>Diciembre</td>
            </tr>
            <tr>
                <td>003</td>
                <td>2024-12-10</td>
                <td>100.00</td>
                <td>150.00</td>
                <td>50.00</td>
                <td>Diciembre</td>
            </tr>
        </tbody>
    </table>

</div>
</div>
</div>

</body>
</html>