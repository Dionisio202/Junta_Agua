<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autorización de Facturas</title>
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

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
                <button id="autorizar-btn" class="styled-button autorizar">Autorizar</button>
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
                    <th>Acciones</th>
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
 <!-- Loading -->
 <div id="loading" class="loading">
    <div class="spinner"></div>
    <p>Enviando factura, por favor espere...</p>
</div>
    <script src="http://localhost/Junta_Agua/app/scripts/autorizations_main.js" type="module"></script>
    <script src="http://localhost/Junta_Agua/app/scripts/enviarxml.js" type="module"></script>
</body>
<style>
    /* Estilo general del loading */
.loading {
    display: none; /* Oculto por defecto */
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
    flex-direction: column;
    color: white;
    font-family: Arial, sans-serif;
    font-size: 1.2em;
}

/* Spinner de carga */
.spinner {
    border: 8px solid rgba(255, 255, 255, 0.3);
    border-top: 8px solid white;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from {
        transform: rotate(0deg);
    }
    to {
        transform: rotate(360deg);
    }
}

.acciones {
color: black;
}

.acciones i {
  cursor: pointer;
  transition: color 0.3s ease;
  color: black;

}

.acciones i:hover {
  color: #007bff; /* Color al pasar el mouse */
}


</style>
</html>
