<style>


    .table-container2 {
        background-color: #ffffff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        margin-top: 20px;
        width: 100%;
    }

    .table-container2 table {
        width: 100%;
        border-collapse: separate; 
        border-spacing: 0 15px; 
        margin-top: 20px;
    }


    .table-container2 button {
        background-color: #3282B8;
        color: #ffffff;
        padding: 20px 8%;
        font-size: 14px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        margin-right: 10px;
        transition: background-color 0.2s;
        
    }



    .table-container2 th,
    .table-container2 td {
        padding: 20px 20px;
        text-align: left;
        border-bottom: 4px solid #ffffff;
        
    }

    .table-container2 th {
        background-color: #3282B8;
        color: #ffffff;
        
    }

    .table-container2 td {
    padding: 30px 20px;
    text-align: left;
    border-bottom: 4px solid #f1f2f0;
    box-shadow: 0px 4px 0px rgba(0, 0, 0, 0.1); 
    }


    .table-container2 th:first-child {
        border-top-left-radius: 15px;
        border-bottom-left-radius: 15px;
        
    }

    .table-container2 td:first-child {
        border-top-left-radius: 15px;
        border-bottom-left-radius: 15px;
        box-shadow: 0px 4px 0px rgba(0, 0, 0, 0.1);
    }

    .table-container2 th:nth-last-child(1),
    .table-container2 td:nth-last-child(1) {
        border-top-right-radius: 15px;
        border-bottom-right-radius: 15px;

        
    }

    .table-container2 tbody tr {
        background-color: #f1f2f0;
    }



    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 20px;
    }

    .pagination span {
        margin: 0 5px;
        cursor: pointer;
        color: #16486a;
        font-weight: 600;
    }

    .pagination span:hover {
        color: #22638e;
    }

    .page-number,
    .page-arrow {
        margin: 0 5px;
        cursor: pointer;
        color: #1b5e8b;
        font-weight: 600;
    }

    .page-number.active {
        color: #ffffff;
        background-color: #4f90bc;
        padding: 5px 10px;
        border-radius: 50%;
    }

    .page-arrow:hover,
    .page-number:hover {
        color: #568cc6;
    }

    .styled-button {
        background-color: #ffffff;
        padding: 10px 20px;
        border-radius: 8px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        border: 1px solid #ccc;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .styled-button:hover {
        background-color: #f0f0f0;
        box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.15);
        color: #000000;
    }

    /**checkbox */
    .checkboxCustom {
        display: block;
        position: relative;
        padding-left: 35px;
        margin-bottom: 12px;
        cursor: pointer;
        font-size: 22px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    /* Hide the browser's default radio button */
    .checkboxCustom input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }

    /* Create a custom radio button */
    .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 25px;
        width: 25px;
        background-color: #eee;
        border-radius: 50%;
    }

    /* On mouse-over, add a grey background color */
    .checkboxCustom:hover input ~ .checkmark {
        background-color: #ccc;
    }

    /* When the radio button is checked, add a blue background */
    .checkboxCustom input:checked ~ .checkmark {
        background-color: #2196F3;
    }

    /* Create the indicator (the dot/circle - hidden when not checked) */
    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    /* Show the indicator (dot/circle) when checked */
    .checkboxCustom input:checked ~ .checkmark:after {
        display: block;
    }

    /* Style the indicator (dot/circle) */
    .checkboxCustom .checkmark:after {
        top: 9px;
        left: 9px;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: white;
    }
</style>

<div class="payment-container">
    <h1>Autorización de facturas</h1>

    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
        <div>
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

        <div>
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

        <div>
            <h2>Filtro por Fecha</h2>
            <div style="display: flex; gap: 10px;">
                <label>Desde: <input type="date" name="fechaDesde" value="2023-07-01"></label>
                <label>Hasta: <input type="date" name="fechaHasta" value="2023-07-01"></label>
            </div><br>
            <label>Por Mes: <input type="date" name="oporMesFecha" value="2023-07-01"></label>
        </div>
    </div>

    <div class="table-container2">
        <button class="styled-button">Consultar</button>
        <button class="styled-button">Todos</button>
        <button class="styled-button">Opciones</button>
        <button class="styled-button">Actualizar</button>
        <table>
            <thead>
                <tr>
                    <th>selección</th>
                    <th>¿Autorizado?</th>
                    <th>Emisión</th>
                    <th>Serie</th>
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
        { autorizado: false, emision: '01/01/1999', serie: '7654321', cliente: 'Christopher Santamaria', importe: '41.80', mensajeError: '' },
        { autorizado: true, emision: '02/02/2000', serie: '1234567', cliente: 'María Pérez', importe: '100.00', mensajeError: '' },
        { autorizado: false, emision: '03/03/2001', serie: '8910111', cliente: 'Juan García', importe: '50.00', mensajeError: 'Error en la serie' }
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
