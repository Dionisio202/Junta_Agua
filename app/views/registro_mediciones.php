<div class="user-info">
    <span class="user-role">Administrador</span> 
    <span class="user-name">Juan Pérez</span> 
</div>

<div class="container">
    <h1>Registro de Mediciones</h1>

    <!-- Formulario para registrar nueva medición -->
    <form>
        <div class="form-group">
            <label for="idmedidor">ID del Medidor</label>
            <input type="text" name="idmedidor" id="idmedidor" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="fecha_lectura">Fecha de Lectura</label>
            <input type="date" name="fecha_lectura" id="fecha_lectura" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="lectura_anterior">Lectura Anterior</label>
            <input type="number" name="lectura_anterior" id="lectura_anterior" class="form-control" step="0.01" required>
        </div>
        <div class="form-group">
            <label for="lectura_actual">Lectura Actual</label>
            <input type="number" name="lectura_actual" id="lectura_actual" class="form-control" step="0.01" required>
        </div>
        <div class="form-group">
            <label for="consumo_m3">Consumo en m3</label>
            <input type="number" name="consumo_m3" id="consumo_m3" class="form-control" step="0.01" required>
        </div>
        <div class="form-group">
            <label for="mes_facturado">Mes Facturado</label>
            <input type="text" name="mes_facturado" id="mes_facturado" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Registrar Medición</button>
    </form>

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
