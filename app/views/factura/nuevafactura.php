<link rel="stylesheet" href="app/public/styles/styles.css">

<div class="user-info">
    <span class="user-role"><?= htmlspecialchars($rol); ?></span>
    <span class="user-name"><?= htmlspecialchars($nombre ?? 'Usuario'); ?></span>
</div>

<div class="table-container">
    <div class="header-buttons">
        <h1>Facturación <?= $rol === 'Tesorero' ? 'TESORERÍA' : ''; ?></h1>
    </div>

    <div class="seccion-factura">
        <h2>Mantenimiento</h2>
        <form>
            <div class="columna-izquierda">
                <div class="pestana-datos-adicionales">
                    <label for="facturador">Facturador:</label>
                    <input type="text" id="nombre-facturador" value="usuario logueado" readonly>

                    <label for="sucursal">Sucursal:</label>
                    <select id="sucursal">
                        <option selected>MATRIZ / SANTA ROSA</option>
                    </select>
                </div>
            </div>

            <div class="columna-centro">
                <div class="pestana-mantenimiento">
                    <div class="grupo">
                        <div>
                            <label for="fecha-emision">Emisión:</label>
                            <input type="date" id="fecha-emision" value="2024-10-28">
                        </div>
                        <div>
                            <label for="fecha-vencimiento">Vence:</label>
                            <input type="date" id="fecha-vencimiento" value="2024-10-28">
                        </div>
                    </div>

                    <div class="grupo">
                        <div>
                            <label for="serie">Serie:</label>
                            <input type="text" id="serie" value="001">
                        </div>
                        <div>
                            <label for="numero">Número:</label>
                            <input type="text" id="numero" value="200">
                        </div>
                        <div>
                            <label for="secuencia">Secuencia:</label>
                            <input type="text" id="secuencia" value="000006001" readonly>
                        </div>
                        <div>
                            <label for="concepto">Concepto:</label>
                            <input type="text" id="concepto" value="M186">
                        </div>
                    </div>

                    <div class="grupo">
                        <div>
                            <label for="ci-ruc">C.I./RUC:</label>
                            <div class="input-group">
                                <input type="text" id="ci-ruc" value="1803110517">
                                <button type="button" class="btn-busqueda" onclick="buscarCIRUC()">🔍</button>
                            </div>
                        </div>
                        <div>
                            <label for="nombre-cliente">Cliente:</label>
                            <input type="text" id="nombre-cliente" value="GALARZA GALARZA NANCY ROCIO">
                        </div>
                        <div>
                            <label for="codigo">Código:</label>
                            <div class="input-group">
                                <input type="text" id="codigo">
                                <button type="button" class="btn-busqueda" onclick="buscarCodigo()">🔍</button>
                            </div>
                        </div>
                    </div>

                    <div class="buttons">
                        <button type="button" class="btn-informacion">Información</button>
                        <button type="button" class="btn-observacion">Observación</button>
                        <button type="button" class="btn-existencias">Existencias</button>
                    </div>
                </div>
            </div>

            <div class="columna-derecha">
                <div class="buttons-vertical">
                    <button class="add-btn">Agregar nueva Factura</button>
                    <button class="save-btn">Guardar</button>
                    <button class="edit-btn">Modificar</button>
                    <button class="delete-btn">Eliminar</button>


                    <div style="display: flex; align-items: center; justify-content: flex-start; position: relative;">
                        <button type="button" id="actionBtn" class="btn" style="width: 200px;">Generar Ticket</button>
                        <div class="dropdown" style="position: absolute; right: 0;">
                            <button class="btn dropdown-btn">
                                <i class="fa fa-caret-down"></i>
                            </button>
                            <div  class="dropdown-content" style="right: 0; left: auto;">
                                <a href="#" onclick="setAction(event, 'ticket')">Generar Ticket</a>
                                <a href="#" onclick="setAction(event, 'pdf')">Generar PDF</a>
                            </div>
                        </div>
                    </div>




               </div>
            </div>
        </form>
    </div>

    <div class="table-container">
        <div class="factura-detalle">
            <table>
                <tr>
                    <th>Código</th>
                    <th>Descripción</th>
                    <th>Medida</th>
                    <th>Cantidad</th>
                    <th>Precio IVA</th>
                    <th>Desc.</th>
                    <th>IVA</th>
                    <th>Total</th>
                </tr>
                <tr>
                    <td>P000000018</td>
                    <td>Tarifa Básica Agosto</td>
                    <td>Unidad</td>
                    <td>1,00</td>
                    <td>3,00</td>
                    <td>0,0000</td>
                    <td>0%</td>
                    <td>3,00</td>
                </tr>
                <tr>
                    <td>P000000016</td>
                    <td>Tarifa Básica Julio</td>
                    <td>Unidad</td>
                    <td>1,00</td>
                    <td>3,00</td>
                    <td>0,0000</td>
                    <td>0%</td>
                    <td>3,00</td>
                </tr>
            </table>
        </div>

        <div class="datos-resumen">
            <div class="datos-documento-relacionado">
                <h3>Datos Documento Relacionado</h3>
                <div class="field-group">
                    <label for="emision-relacionado">Emisión:</label>
                    <input type="text" id="emision-relacionado" value="2024-11-15" readonly>
                    <label for="secuencia-relacionado">Secuencia:</label>
                    <input type="text" id="secuencia-relacionado" value="000123456" readonly>
                </div>
            </div>

            <div class="resumen-totales">
                <h3>Resumen de valores</h3>
                <p>Sub Total: <span>6,0000</span></p>
                <p>Descuento %: <span>0,00</span></p>
                <p>Descuento $: <span>0,00</span></p>
                <p>Sub Total Neto: <span>6,0000</span></p>
                <p>Sub Total Con IVA: <span>0,0000</span></p>
                <p>Sub Total IVA 5%: <span>0,0000</span></p>
                <p>Sub Total IVA 0%: <span>6,0000</span></p>
                <p>Sub Total No Obj.: <span>0,0000</span></p>
                <p>Sub Total Exento: <span>0,0000</span></p>
                <p>Total ICE: <span>0,00</span></p>
                <p>Total IVA: <span>0,00</span></p>
                <p>Total IVA 5%: <span>0,00</span></p>
                <p>Propina: <span>0,00</span></p>
                <h3>Total: <span id="total" >6,00</span></h3>
                <h3>Neto: <span>6,00</span></h3>
            </div>
        </div>
    </div>

    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Contenido de la Imprimir</h2>
            <div class="left-content">
                <div id="ticketContent">
                    <!-- El contenido de ticket.php se cargará aquí -->
                </div>
            </div>
            <button id="printContentBtn">Imprimir</button>
        </div>
    </div>

    <style>






        .dropdown {
        position: absolute;
        display: inline-block;
        }

        .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f1f1f1;
        min-width: 160px;
        z-index: 1;
        }

        .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
        }

        .dropdown-content a:hover {background-color: #ddd}

        .dropdown:hover .dropdown-content {
        display: block;
        }

        .btn:hover, .dropdown:hover .btn {
        background-color: #0b7dda;
        }






        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 350px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        #ticketContent {
            margin-top: 20px;
        }

        
    </style>

    <iframe id="printIframe" style="display:none;"></iframe>
    <script>

        document.getElementById('actionBtn').addEventListener('click', function(event) {
            // Evitar la recarga o cierre inesperado
            event.preventDefault();

            // Mostrar el modal
            var modal = document.getElementById("myModal");
            modal.style.display = "block";

            // Cargar el contenido de ticket.php en el modal
            fetch('ticket.php')
                .then(response => response.text())
                .then(data => {
                    document.getElementById('ticketContent').innerHTML = data;
                })
                .catch(error => {
                    console.error("Error al cargar el contenido de ticket.php:", error);
                });

            // Cerrar el modal cuando se hace clic en la 'x'
            var span = document.getElementsByClassName("close")[0];
            span.onclick = function () {
                modal.style.display = "none";
            };

            // Cerrar el modal si se hace clic fuera de él
            window.onclick = function (event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            };

            // Recoger los datos del formulario
            const data = {
                emision: document.getElementById('fecha-emision').value,
                vence: document.getElementById('fecha-vencimiento').value,
                serie: document.getElementById('serie').value,
                numero: document.getElementById('numero').value,
                secuencia: document.getElementById('secuencia').value,
                concepto: document.getElementById('concepto').value,
                ciRuc: document.getElementById('ci-ruc').value,
                cliente: document.getElementById('nombre-cliente').value,
                total: document.getElementById('total').textContent
            };

            // Guardar los datos en una cookie
            document.cookie = "data=" + JSON.stringify(data) + "; path=/; max-age=3600"; // 1 hora de duración
        });




        document.getElementById('printContentBtn').onclick = function() {
            const iframe = document.getElementById('printIframe');
            const iframeDoc = iframe.contentWindow.document;
            iframeDoc.open();
            iframeDoc.write('<html><head><title>Impresión de factura</title></head><body>');
            iframeDoc.write(document.getElementById('ticketContent').innerHTML);
            iframeDoc.write('</body></html>');
            iframeDoc.close();
        };




        function setAction(event, action) {
            event.preventDefault();  // Evitar el comportamiento predeterminado

            // Mostrar el modal
            var modal = document.getElementById("myModal");
            modal.style.display = "block";

            // Cargar el contenido adecuado según la acción seleccionada (Ticket o PDF)
            if (action === 'ticket') {
                fetch('ticket.php')
                    .then(response => response.text())
                    .then(data => {
                        document.getElementById('ticketContent').innerHTML = data;
                    })
                    .catch(error => {
                        console.error("Error al cargar el contenido de ticket.php:", error);
                    });
            } else if (action === 'pdf') {
                // Aquí se puede cargar el contenido para generar el PDF si es necesario
                document.getElementById('ticketContent').innerHTML = "<p>Generando PDF...</p>";
            }

            // Cerrar el modal cuando se hace clic en la 'x'
            var span = document.getElementsByClassName("close")[0];
            span.onclick = function () {
                modal.style.display = "none";
            };

            // Cerrar el modal si se hace clic fuera de él
            window.onclick = function (event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            };

            // Recoger los datos del formulario
            const data = {
                emision: document.getElementById('fecha-emision').value,
                vence: document.getElementById('fecha-vencimiento').value,
                serie: document.getElementById('serie').value,
                numero: document.getElementById('numero').value,
                secuencia: document.getElementById('secuencia').value,
                concepto: document.getElementById('concepto').value,
                ciRuc: document.getElementById('ci-ruc').value,
                cliente: document.getElementById('nombre-cliente').value,
                total: document.getElementById('total').textContent
            };

            // Guardar los datos en una cookie
            document.cookie = "data=" + JSON.stringify(data) + "; path=/; max-age=3600"; // 1 hora de duración
        }



        // Establecer la opción por defecto
        setAction(event, 'ticket');


    </script>
</div>
