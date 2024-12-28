<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autorización de Facturas</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>

<body>
    <div class="user-info">
        <span class="user-role"><?= htmlspecialchars($rol); ?></span>
        <span class="user-name"><?= htmlspecialchars($nombre ?? 'Usuario'); ?></span>
    </div>
    <div class="table-container">
        <h1>Autorización de Facturas</h1>
        <!-- Sección de Filtros -->
        <div class="seccion-factura">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <!-- Tipos de Documentos -->
                <div class="columna1">
                    <h2>Tipos de Documentos</h2>
                    <label class="checkboxCustom">Facturas
                        <input type="checkbox" name="facturas">
                        <span class="checkmark"></span>
                    </label>
                    
                    <label class="checkboxCustom">Otros
                        <input type="checkbox" name="otros">
                        <span class="checkmark"></span>
                    </label>
                    
                    <label class="checkboxCustom">Todos
                        <input type="checkbox" name="todos">
                        <span class="checkmark"></span>
                    </label>
                    <br>
                </div>
                
                <!-- Estado de Factura -->
                <div class="columna2">
                    <h2>Estado de Factura</h2>
                    <label class="checkboxCustom">No Autorizado
                        <input type="checkbox" name="noAutorizado">
                        <span class="checkmark"></span>
                    </label>
                    <label class="checkboxCustom">Autorizado
                        <input type="checkbox" name="autorizado">
                        <span class="checkmark"></span>
                    </label>
                </div>
                
                <!-- Filtro por Fecha -->
                <div class="columna3">
                    <h2>Filtro por Fecha</h2>
                    <div style="display: flex; gap: 10px;">
                        <label>Desde: <input type="date" name="fechaDesde"></label>
                        <label>Hasta: <input type="date" name="fechaHasta"></label>
                    </div>
                    <br>
                </div>
            </div>
            <div class="buttons">
                <button type="button" class="styled-button consultar">Consultar</button>
            <button type="button" class="styled-button todos">Todos</button>
            <button type="button" class="styled-button opciones">Opciones</button>
            <button type="button" class="styled-button actualizar">Actualizar</button>
            <button type="button" class="styled-button autorizar">Autorizar</button>
        </div>
        
    </div>
    
        <table width="100%" style="border-collapse: collapse;">
            <thead>
                <tr>
                    <th>Selección</th>
                    <th>¿Autorizado?</th>
                    <th>Emisión</th>
                    <th>Serie</th>
                    <th>Secuencia</th>
                    <th>Nombre del Cliente</th>
                    <th>Importe</th>
                    <th>Mensaje Error</th>
                </tr>
            </thead>
            <tbody id="table-body"></tbody>
        </table>
        
        <!-- Controles de Paginación -->
        <div id="pagination" class="pagination">    
            <span id="prev-page" class="page-control">Anterior</span>
            <span id="current-page">1</span>
            <span id="next-page" class="page-control">Siguiente</span>
        </div>
    </div>

    <script src="http://localhost/Junta_Agua/public/scripts/autorizations_main.js" type="module"></script>
</body>

</html>