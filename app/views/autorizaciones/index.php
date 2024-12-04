<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autorización de Facturas</title>
    <style>
        .pagination {
            display: flex;
            justify-content: center;
            margin: 15px 0;
        }

        .page-number {
            padding: 5px 10px;
            margin: 0 5px;
            cursor: pointer;
        }

        .page-number.active {
            background-color: #007BFF;
            color: white;
            border-radius: 5px;
        }

        .page-nav {
            padding: 5px 10px;
            cursor: pointer;
        }

        .page-nav.disabled {
            pointer-events: none;
            opacity: 0.5;
        }

        .table-container {
            margin: 20px;
        }

        .styled-button {
            margin: 5px;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            background-color: #007BFF;
            color: white;
            border-radius: 5px;
        }

        .styled-button:hover {
            background-color: #0056b3;
        }

        h1, h2 {
            font-family: Arial, sans-serif;
        }
    </style>
</head>

<body>
    <div class="table-container">
        <h1>Autorización de Facturas</h1>

        <!-- Sección de Filtros -->
        <div class="seccion-factura">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <!-- Tipos de Documentos -->
                <div class="columna1">
                    <h2>Tipos de Documentos</h2>
                    <label class="checkboxCustom">
                        <input type="checkbox" name="facturas">
                        Facturas
                    </label>
                    <label class="checkboxCustom">
                        <input type="checkbox" name="otros">
                        Otros
                    </label>
                    <label class="checkboxCustom">
                        <input type="checkbox" name="todos">
                        Todos
                    </label>
                </div>

                <!-- Estado de Factura -->
                <div class="columna2">
                    <h2>Estado de Factura</h2>
                    <label class="checkboxCustom">
                        <input type="checkbox" name="noAutorizado">
                        No Autorizado
                    </label>
                    <label class="checkboxCustom">
                        <input type="checkbox" name="autorizado">
                        Autorizado
                    </label>
                </div>

                <!-- Filtro por Fecha -->
                <div class="columna3">
                    <h2>Filtro por Fecha</h2>
                    <label>Desde:
                        <input type="date" name="fechaDesde">
                    </label>
                    <label>Hasta:
                        <input type="date" name="fechaHasta">
                    </label>
                </div>
            </div>
        </div>

        <!-- Controles -->
        <div>
            <button class="styled-button consultar">Consultar</button>
            <button class="styled-button todos">Todos</button>
        </div>

        <!-- Tabla -->
        <div class="table-container">
            <table border="1" width="100%" style="border-collapse: collapse;">
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
        </div>

        <!-- Controles de Paginación -->
        <div id="pagination" class="pagination"></div>
    </div>

    <script src="http://localhost/Junta_Agua/public/scripts/autorizations_main.js" type="module"></script>
</body>

</html>