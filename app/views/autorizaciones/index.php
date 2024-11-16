<div class="table-container">
    <h1>Autorización de facturas</h1>

    <div class="seccion-factura">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div class="columna1">
                <h2>Tipos de Documentos</h2>
                <br>
                <label class="checkboxCustom" name="facturas">Facturas
                    <input type="checkbox" > 
                    <span class="checkmark"></span>
                </label>

                <label class="checkboxCustom" name="otros">Otros
                    <input type="checkbox" >
                    <span class="checkmark"></span>
                </label>
            </div>

            <div class="columna2">
                <h2>Estado de Factura</h2>
                <br>
                <label class="checkboxCustom" name="noAutorizado">
                    No Autorizado
                    <input type="checkbox" name="noAutorizado">
                    <span class="checkmark"></span>
                </label>
                <label class="checkboxCustom" name="oporMes">
                    Por Mes
                    <input type="checkbox" name="oporMes">
                    <span class="checkmark"></span>
                </label>
                <label class="checkboxCustom" name="autorizado">
                    Autorizado
                    <input type="checkbox" name="autorizado">
                    <span class="checkmark"></span>
                </label><br>
            </div>

            <div class="columna3">
                <h2>Filtro por Fecha</h2>
                <div style="display: flex; gap: 10px;">
                    <label>Desde: <input type="date" name="fechaDesde" value="2023-07-01"></label>
                    <label>Hasta: <input type="date" name="fechaHasta" value="2023-07-01"></label>
                </div><br>
                <label>Por Mes: <input type="date" name="oporMesFecha" value="2023-07-01"></label>
            </div>
        </div>
    </div>

    <div class="table-container">
        <button class="styled-button">Consultar</button>
        <button class="styled-button">Todos</button>
        <button class="styled-button">Opciones</button>
        <button class="styled-button">Actualizar</button>
        <button class="styled-button">Autorizar</button>
        <table>
            <thead>
                <tr>
                    <th>selección</th>
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
</div>

<script>
    // Lista estática de datos
    const data = [
        { autorizado: false, emision: '01/01/1999', serie: '7654321', secuencia: '7654321', cliente: 'Christopher Santamaria', importe: '41.80', mensajeError: '' },
        { autorizado: true, emision: '02/02/2000', serie: '1234567', secuencia: '7654321', cliente: 'María Pérez', importe: '100.00', mensajeError: '' },
        { autorizado: false, emision: '03/03/2001', serie: '8910111', secuencia: '7654321', cliente: 'Juan García', importe: '50.00', mensajeError: 'Error en la serie' }
    ];

    // Función para cargar los datos en la tabla
    function loadTableData() {
        const tableBody = document.getElementById('table-body');
        tableBody.innerHTML = ''; // Limpiar contenido previo

        data.forEach(row => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td><input type="checkbox" ${row.autorizado ? 'checked' : ''}></td>
                <td><input type="checkbox" ${row.autorizado ? 'checked' : ''}></td>
                <td>${row.emision}</td>
                <td>${row.serie}</td>
                <td>${row.secuencia}</td>
                <td>${row.cliente}</td>
                <td>${row.importe}</td>
                <td>${row.mensajeError}</td>
            `;
            tableBody.appendChild(tr);
        });
    }

    // Cargar los datos al cargar la página
    window.onload = loadTableData;
</script>
