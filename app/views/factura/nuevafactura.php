<link rel="stylesheet" href="styles/styles.css">

<div class="user-info">
    <span class="user-role"><?= htmlspecialchars($rol); ?></span>
    <span class="user-name"><?= htmlspecialchars($_SESSION['Nombre'] ?? $nombre ?? 'Usuario'); ?></span>
    <span class="user-apellido"><?= htmlspecialchars($_SESSION['Apellido'] ?? 'Sin apellido'); ?></span>
    <span class="user-id"><?= htmlspecialchars($_SESSION['idUser'] ?? 'Sin ID'); ?></span>
</div>
<script>
    // Definir el objeto facturaData como una variable global
    var facturaData = {
        fecha_emision: "",
        fecha_autorizacion: "",
        fecha_vencimiento: "",
        id_sucursal: null,
        facturador: "<?= htmlspecialchars($_SESSION['idUser'] ?? '') ?>",
        cliente: null,
        medidor_id: null,
        //medidor_id: 2,  //para testeo
        valor_sin_impuesto: 0,
        iva: 0,
        total: 0
    };
</script>
<div class="table-container">
    <div class="header-buttons">
        <h1>Facturación <?= $rol === 'Tesorero' ? 'TESORERÍA' : ''; ?></h1>
    </div>

    <div class="seccion-factura">
        <h2>Mantenimiento</h2>
        <form>
            <!-- Columna Izquierda -->
            <div class="columna-izquierda">
                <div class="pestana-datos-adicionales">
                    <label for="facturador">Facturador:</label>
                    <input type="text" id="nombre-facturador" readonly>
                    <label for="sucursal">Sucursal:</label>
                    <select id="sucursal">
                        <option selected>MATRIZ / SANTA ROSA</option>
                    </select>
                </div>
            </div>

            <!-- Columna Central -->
            <div class="columna-centro">
                <div class="pestana-mantenimiento">
                    <div class="grupo">
                        <div>
                            <label for="fecha-emision">Emisión:</label>
                            <input type="date" id="fecha-emision">
                        </div>

                        <div>
                            <label for="fecha-vencimiento">Vence:</label>
                            <input type="date" id="fecha-vencimiento">
                        </div>
                    </div>
                    <br>
                    <div class="grupo">
                        <div>
                            <label for="serie">Serie:</label>
                            <input type="text" id="serie" value="001" readonly>
                        </div>
                        <div>
                            <label for="numero">Número:</label>
                            <input type="text" id="numero" value="200" readonly>
                        </div>
                        <div>
                            <label for="secuencia">Secuencia:</label>
                            <input type="text" id="secuencia" readonly>
                        </div>
                        <div>
                            <label for="concepto">Concepto:</label>
                            <select id="concepto">
                                <option value="1">Ninguno</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="grupo">
                        <div>
                            <label for="ci-ruc">C.I./RUC:</label>
                            <div class="input-group">
                                <input type="text" id="ci-ruc" placeholder="Ingrese CI/RUC">
                            </div>
                        </div>
                        <div>
                            <label for="nombre-cliente">Cliente:</label>
                            <input type="text" id="nombre-cliente" readonly>
                        </div>
                        <div>
                            <label for="codigo">Código:</label>
                            <div class="input-group">
                                <button id="btn-codigo" type="button">Seleccionar Código</button>
                            </div>
                        </div>
                    </div>

                    <div class="buttons">
                        <button type="button" class="customized-button">Información</button>
                        <button type="button" class="customized-button">Observación</button>
                        <button type="button" class="customized-button">Existencias</button>
                    </div>
                </div>
            </div>

            <!-- Columna Derecha -->
            <div class="columna-derecha">
                <div class="buttons-vertical">
                    <button class="save-btn">Guardar</button>
                    <button class="cancel-btn">Cancelar</button>
                    <div style="display: flex; align-items: center; justify-content: flex-start; position: relative;">
                        <button type="button" id="actionBtn" class="btn" style="width: 200px;">Generar Ticket</button>
                        <div class="dropdown" style="position: absolute; right: 0;">
                            <button class="btn dropdown-btn">
                                <i class="fa fa-caret-down"></i>
                            </button>
                            <div class="dropdown-content" style="right: 0; left: auto;">
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
        <!-- Tabla de Facturas -->
        <div class="factura-detalle">
            <table id="tabla-datos">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Precio </th>
                        <th>Desc.</th>
                        <th>IVA</th>
                        <th>Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Filas dinámicas aquí -->
                </tbody>
            </table>

        </div>

        <!-- Resumen de Totales -->
        <div class="datos-resumen">
            <div class="resumen-totales">
                <h3>Resumen de valores</h3>
                <p>Sub Total: <span>0,0000</span></p>
                <p>Descuento: <span>0,00</span></p>
                <p id="netoResumen">Neto: <span>0,00</span></p>
                <p id="ivaResumen">IVA: <span>0,00</span></p>
                <p id="totalResumen">Total: <span>0,00</span></p>
            </div>
        </div>
    </div>
</div>
<!-- Modal para mostrar los resultados -->
<div id="modal" class="modal">
    <div class="modal-content">
        <h2>Seleccionar Cliente</h2>
        <div id="modal-content">
            <!-- Filas dinámicas se generarán aquí -->
        </div>
        <button id="close-modal" class="close-modal">Cerrar</button>
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
        <button id="printContentBtn" type="button">Imprimir</button>
    </div>
</div>

<!-- Modal para seleccionar el código -->
<div id="codigoModal" class="modal">
    <div class="modal-content">
        <h2>Seleccionar Código</h2>
        <div id="codigo-list">
            <!-- Lista de opciones -->
            <ul>

            </ul>
        </div>
        <div id="mes-selector" style="display: none;">
            <label for="mes">Mes:</label>
            <select id="mes">
                <option value="Ninguno">Ninguno</option>
                <option value="Enero">Enero</option>
                <option value="Febrero">Febrero</option>
                <option value="Marzo">Marzo</option>
                <option value="Abril">Abril</option>
                <option value="Mayo">Mayo</option>
                <option value="Junio">Junio</option>
                <option value="Julio">Julio</option>
                <option value="Agosto">Agosto</option>
                <option value="Septiembre">Septiembre</option>
                <option value="Octubre">Octubre</option>
                <option value="Noviembre">Noviembre</option>
                <option value="Diciembre">Diciembre</option>
            </select>
        </div>
        <button id="close-codigo-modal" class="close-modal">Cerrar</button>
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

    .dropdown-content a:hover {
        background-color: #ddd
    }

    .dropdown:hover .dropdown-content {
        display: block;
    }

    .btn:hover,
    .dropdown:hover .btn {
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
<!-- Scripts -->
<script type="module">
    import { cargarDatos } from '/Junta_Agua/app/scripts/form_nueva_factura.js';
    import { buscarCIRUC } from '/Junta_Agua/app/scripts/buscar_cliente.js';

    document.addEventListener("DOMContentLoaded", () => {
        // Cargar datos del usuario
        const userId = "<?= htmlspecialchars($_SESSION['idUser'] ?? ''); ?>";
        if (userId) cargarDatos(userId);

        // Referencias a elementos del formulario
        const form = document.querySelector("form");
        const ciRucInput = document.getElementById("ci-ruc");
        const modal = document.getElementById("modal");
        const modalContent = document.getElementById("modal-content");
        const closeModal = document.getElementById("close-modal");

        // Prevenir el envío automático del formulario
        form.addEventListener("submit", (event) => {
            event.preventDefault(); // Detener el envío del formulario
        });

        // Agregar evento "Enter" al input del cliente
        ciRucInput.addEventListener("keydown", (event) => {
            if (event.key === "Enter") { // Detectar Enter
                event.preventDefault(); // Prevenir envío del formulario
                buscarCIRUC(); // Llamar la función de búsqueda
                modalContent.innerHTML = "<p>Buscando cliente...</p>"; // Agregar contenido dinámico
                modal.style.display = "block"; // Mostrar modal
            }
        });

        // Cerrar el modal al hacer clic en el botón "Cerrar"
        closeModal.addEventListener("click", () => {
            modal.style.display = "none";
        });

        // Cerrar el modal si se hace clic fuera de su contenido
        window.addEventListener("click", (event) => {
            if (event.target === modal) {
                modal.style.display = "none";
            }
        });
    });


    //-----------------------------------ticket

    document.getElementById('actionBtn').addEventListener('click', async  function (event) {
        // Evitar la recarga o cierre inesperado
        await obtenerLecturas();
        event.preventDefault();

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
            medicion1: medicionData.lectura1,
            medicion2: medicionData.lectura2,
            medicion3: medicionData.lectura3,
            total: document.getElementById('totalResumen') ? document.getElementById('totalResumen').textContent : '0.00'
        };

        // Guardar los datos en una cookie antes de abrir el modal
        document.cookie = "data=" + JSON.stringify(data) + "; path=/; max-age=3600"; // 1 hora de duración

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

        // Leer los datos de la cookie cuando se abre el modal
        function getCookie(name) {
            let match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
            return match ? JSON.parse(match[2]) : null;
        }

        const savedData = getCookie('data');
        if (savedData) {
            // Si hay datos guardados en la cookie, actualiza los campos del modal
            document.getElementById('fecha-emision').value = savedData.emision;
            document.getElementById('fecha-vencimiento').value = savedData.vence;
            document.getElementById('serie').value = savedData.serie;
            document.getElementById('numero').value = savedData.numero;
            document.getElementById('secuencia').value = savedData.secuencia;
            document.getElementById('concepto').value = savedData.concepto;
            document.getElementById('ci-ruc').value = savedData.ciRuc;
            document.getElementById('nombre-cliente').value = savedData.cliente;
            // Verifica si hay un total guardado en la cookie
            if (savedData.total) {
                // Si se encuentra el total en los datos guardados, actualízalo
                document.getElementById('total').textContent = savedData.total;
            }
        } else {
            console.log("No se encontraron datos en las cookies.");
        }
    });


    document.getElementById('printContentBtn').addEventListener('click', function () {
        const button = this; // Referencia al botón
        const content = document.getElementById('ticketContent').innerHTML;

        // Deshabilitar el botón mientras se realiza la impresión
        button.disabled = true;

        // Crear un iframe para la impresión
        const iframe = document.createElement('iframe');
        iframe.style.position = 'absolute';
        iframe.style.top = '-10000px'; // Ocultarlo fuera de la vista
        document.body.appendChild(iframe);

        const doc = iframe.contentDocument || iframe.contentWindow.document;
        doc.open();
        doc.write('<html><head><title>Impresión</title></head><body>');
        doc.write(content);
        doc.write('</body></html>');
        doc.close();

        iframe.contentWindow.focus();
        //iframe.contentWindow.print();

        // Limpiar el iframe y reactivar el botón después de la impresión
        setTimeout(() => {
            document.body.removeChild(iframe);
            button.disabled = false; // Reactivar el botón
        }, 1000); // Esperar un poco antes de limpiar
    });



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
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const modal = document.getElementById("codigoModal");
        const btnCodigo = document.getElementById("btn-codigo");
        const closeCodigoModal = document.getElementById("close-codigo-modal");
        const codigoList = document.getElementById("codigo-list");
        const mesSelector = document.getElementById("mes-selector");
        const mesInput = document.getElementById("mes");
        const tablaDatos = document.getElementById("tabla-datos").querySelector("tbody");

        let selectedCodigo = null;

        // Abrir el modal
        btnCodigo.addEventListener("click", () => {
            modal.style.display = "block";
        });

        // Cerrar el modal
        closeCodigoModal.addEventListener("click", () => {
            modal.style.display = "none";
            mesSelector.style.display = "none";
            selectedCodigo = null;
        });

        // Seleccionar un código
        codigoList.addEventListener("click", (event) => {
            if (event.target.tagName === "LI") {
                selectedCodigo = event.target;
                const requiereMes = selectedCodigo.getAttribute("data-requiere-mes") === "true";

                if (requiereMes) {
                    mesSelector.style.display = "block"; // Mostrar el selector de mes
                } else {
                    agregarFila(selectedCodigo.textContent, null);
                    modal.style.display = "none";
                }
            }
        });

        // Agregar fila al seleccionar un mes
        mesInput.addEventListener("change", () => {
            if (selectedCodigo) {
                agregarFila(selectedCodigo.textContent, mesInput.value);
                modal.style.display = "none";
                mesSelector.style.display = "none";
                mesInput.value = ""; // Reiniciar selección de mes
            }
        });

        // Función para agregar una fila a la tabla
        function agregarFila(descripcion, mes = "") {
            const codigo = selectedCodigo.getAttribute("data-codigo") || "N/A";
            const idRazon = selectedCodigo.getAttribute("data-id");
            const precio = parseFloat(selectedCodigo.getAttribute("data-precio"));
            const ivaPorcentaje = parseFloat(selectedCodigo.getAttribute("data-iva")) || 0; // IVA inicial
            const cantidad = 1; // Valor inicial para la cantidad
            const descuento = 0; // Asume descuento inicial en 0
            const iva = precio * ivaPorcentaje; // Calcular el IVA basado en el porcentaje
            const total = cantidad * (precio + iva - descuento);

            const fila = document.createElement("tr");

            // Establecer el atributo `data-iva` en la fila
            fila.setAttribute("data-iva", ivaPorcentaje);
            const descripcionConMes = mes ? `${descripcion} ${mes}` : descripcion;

            fila.innerHTML = `
        <td data-id="${idRazon}">${codigo}</td>
        <td>${descripcionConMes}</td>
        <td><input type="number" value="${cantidad}" min="1" class="cantidad-input" required></td>
        <td><input type="number" value="${precio.toFixed(2)}" min="0" class="precio-input" required></td>
        <td><input type="number" value="${descuento.toFixed(2)}" min="0" class="descuento-input" required></td>
        <td class="iva-table">${iva.toFixed(2)}</td>
        <td class="total">${total.toFixed(2)}</td>
        <td><button type="button" class="delete-btn">Eliminar</button></td>
    `;

            // Agregar eventos de validación y cálculo
            fila.querySelector(".cantidad-input").addEventListener("input", actualizarTotal);
            fila.querySelector(".precio-input").addEventListener("input", actualizarTotal);
            fila.querySelector(".descuento-input").addEventListener("input", actualizarTotal);

            // Evento para eliminar fila
            fila.querySelector(".delete-btn").addEventListener("click", () => {
                fila.remove();
                actualizarResumen();
            });

            // Agregar la fila al DOM
            tablaDatos.appendChild(fila);

            actualizarResumen(); // Actualiza el resumen de totales
        }



        // Función para actualizar el total y recalcular el IVA y descuento
        function actualizarTotal(event) {
            const fila = event.target.closest("tr"); // Obtiene la fila donde ocurrió el evento
            const cantidad = parseFloat(fila.querySelector(".cantidad-input").value) || 0;
            const precio = parseFloat(fila.querySelector(".precio-input").value) || 0;
            const descuento = parseFloat(fila.querySelector(".descuento-input").value) || 0;

            // Leer el porcentaje de IVA desde el atributo `data-iva`
            const ivaPorcentaje = parseFloat(fila.getAttribute("data-iva")) || 0;
            const iva = cantidad * precio * (ivaPorcentaje); // Recalcular el IVA

            // Subtotal (sin IVA ni descuento)
            const subtotal = cantidad * precio - descuento;

            // Total de la fila (subtotal + IVA)
            const total = subtotal + iva;

            // Actualizar las celdas correspondientes de esta fila
            fila.querySelector(".iva-table").textContent = iva.toFixed(2); // Actualizar el valor de IVA
            fila.querySelector(".total").textContent = total > 0 ? total.toFixed(2) : "0.00"; // Actualizar el valor Total

            actualizarResumen(); // Actualiza el resumen general
        }

        // Función para actualizar el resumen de totales
        function actualizarResumen() {
            const filas = tablaDatos.querySelectorAll("tr");
            let subTotal = 0; // Suma de subtotales (cantidad * precio unitario)
            let descuentoTotal = 0; // Suma de descuentos
            let netoTotal = 0; // Neto sin IVA
            let ivaTotal = 0; // Suma de IVA
            let totalConIVA = 0; // Suma de totales con IVA y descuento aplicados

            filas.forEach((fila) => {
                const cantidad = parseFloat(fila.querySelector(".cantidad-input").value) || 0;
                const precio = parseFloat(fila.querySelector(".precio-input").value) || 0;
                const descuento = parseFloat(fila.querySelector(".descuento-input").value) || 0;
                const ivaUnitario = parseFloat(fila.querySelector(".iva-table").textContent) || 0; // El IVA directo de la celda

                const subtotalFila = cantidad * precio; // Subtotal sin IVA ni descuento
                const netoFila = subtotalFila - descuento; // Neto sin IVA
                const ivaFila = ivaUnitario; // El IVA ya está precalculado
                const totalFila = netoFila + ivaFila; // Total con IVA

                // Sumar los valores para el resumen
                subTotal += subtotalFila;
                descuentoTotal += descuento;
                netoTotal += netoFila; // Neto sin IVA
                ivaTotal += ivaFila; // IVA total
                totalConIVA += totalFila; // Total con IVA y descuento aplicados
            });

            // Actualizar los valores en el resumen
            document.querySelector(".resumen-totales p:nth-child(2) span").textContent = subTotal.toFixed(2); // Subtotal
            document.querySelector(".resumen-totales p:nth-child(3) span").textContent = descuentoTotal.toFixed(2); // Descuento total
            document.getElementById("netoResumen").querySelector("span").textContent = netoTotal.toFixed(2); // Neto total
            document.getElementById("ivaResumen").querySelector("span").textContent = ivaTotal.toFixed(2); // IVA total
            document.getElementById("totalResumen").querySelector("span").textContent = totalConIVA.toFixed(2); // Total con IVA
        }





        // Cerrar el modal al hacer clic fuera
        window.addEventListener("click", (event) => {
            if (event.target === modal) {
                modal.style.display = "none";
                mesSelector.style.display = "none";
                selectedCodigo = null;
            }
        });
    });

</script>

<style>
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
        width: 400px;
    }

    .modal-content ul {
        list-style-type: none;
        padding: 0;
    }

    .modal-content li {
        padding: 10px;
        cursor: pointer;
        border: 1px solid #ccc;
        margin: 5px 0;
    }

    .modal-content li:hover {
        background-color: #ddd;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    table th,
    table td {
        border: 1px solid #ccc;
        padding: 10px;
        text-align: center;
    }

    table input {
        width: 80px;
    }
</style>
<script>
    const baseURL = `${window.location.protocol}//${window.location.host}`;
    let apiURL = ``;
    document.querySelector(".save-btn").addEventListener("click", () => {

        const detalles = []; // Array para almacenar los detalles de las filas

        // Referencia a las filas del cuerpo de la tabla
        const filas = document.querySelectorAll("#tabla-datos tbody tr");

        // Validar que existan filas
        if (filas.length === 0) {
            alert("Debe agregar al menos un detalle a la factura.");
            return;
        }

        // Iterar sobre cada fila para extraer los datos
        let valid = true; // Indicador de validación
        filas.forEach((fila) => {
            const idRazon = fila.querySelector("td:nth-child(1)").getAttribute("data-id"); // Código (id_razon)
            const descripcion = fila.querySelector("td:nth-child(2)").textContent.trim(); // Descripción
            const descuento = parseFloat(fila.querySelector(".descuento-input").value) || 0; // Descuento
            const subtotal = parseFloat(fila.querySelector(".total").textContent.trim()) || 0; // Total (subtotal)
            const cantidad = parseFloat(fila.querySelector(".cantidad-input").value) || 0;
            const precio = parseFloat(fila.querySelector(".precio-input").value) || 0;

            // Validar que los campos de la fila estén completos
            if (!idRazon || !descripcion || subtotal <= 0 || cantidad <= 0 || precio <= 0) {
                valid = false;
            }

            // Agregar el objeto de detalle al array
            detalles.push({
                id_razon: idRazon,
                descripcion: descripcion,
                descuento: descuento,
                subtotal: subtotal,
                cantidad: cantidad,
                precioIVA: precio
            });
        });

        if (!valid) {
            alert("Asegúrese de que todos los campos en las filas estén completos y que los valores sean mayores a 0.");
            return;
        }

        const fecha = new Date(document.getElementById("fecha-emision").value);

        // Validar y formatear la fecha de emisión
        facturaData.fecha_emision = fecha.toISOString().split('T')[0];

        // Obtener el valor del campo fecha de vencimiento
        const fechaVencimientoInput = document.getElementById("fecha-vencimiento").value;

        // Validar si la fecha de vencimiento es válida
        if (fechaVencimientoInput) {
            facturaData.fecha_vencimiento = new Date(fechaVencimientoInput).toISOString().split('T')[0];
        } else {
            facturaData.fecha_vencimiento = null; // Asignar null si no hay un valor válido
            console.warn("La fecha de vencimiento no es válida o está vacía.");
        }

        // Validar otros campos clave
        const cliente = document.getElementById("ci-ruc").value.trim();
        if (!cliente) {
            alert("Debe ingresar el cliente (C.I./RUC).");
            return;
        }

        facturaData.id = document.getElementById("secuencia").value;
        facturaData.id_sucursal = document.getElementById("sucursal").value;
        facturaData.valor_sin_impuesto = parseFloat(document.querySelector(".resumen-totales p:nth-child(2) span").textContent);
        facturaData.medidor_id = document.getElementById("concepto").value;
        facturaData.iva = document.querySelector(".resumen-totales p:nth-child(3) span").textContent;
        facturaData.total = parseFloat(document.getElementById("totalResumen").querySelector("span").textContent);

        const facturaDataScript = {
            fecha_emision: facturaData.fecha_emision,
            fecha_vencimiento: facturaData.fecha_vencimiento,
            id_sucursal: facturaData.id_sucursal,
            facturador: facturaData.facturador,
            cliente: facturaData.cliente, // Supongamos que el cliente es el CI/RUC
            medidor_id: facturaData.medidor_id,
            estado_factura: "Sin autorizar",
            valor_sin_impuesto: facturaData.valor_sin_impuesto,
            iva: facturaData.iva,
            total: facturaData.total,
            detalles: detalles
        };
        console.log("Datos de la factura:", facturaDataScript);

        function checkParamInURL(paramName) {
    const urlParams = new URLSearchParams(window.location.search); // Obtiene los parámetros de la URL
    return urlParams.has(paramName); // Devuelve true si el parámetro existe
}
function getParamFromURL(param) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(param); // Devuelve el valor del parámetro o null si no existe
}

if (checkParamInURL('id')) {
    const idFactura = getParamFromURL('id');
    facturaData.id = document.getElementById("secuencia").value;
        facturaData.id_sucursal = document.getElementById("sucursal").value;
        facturaData.valor_sin_impuesto = parseFloat(document.querySelector(".resumen-totales p:nth-child(2) span").textContent);
        facturaData.medidor_id = document.getElementById("concepto").value;
        facturaData.iva = document.querySelector(".resumen-totales p:nth-child(3) span").textContent;
        facturaData.total = parseFloat(document.getElementById("totalResumen").querySelector("span").textContent);
        facturaData.cliente= document.getElementById("ci-ruc").value;

            const facturaDataScript = {
            fecha_emision: facturaData.fecha_emision,
            fecha_vencimiento: facturaData.fecha_vencimiento,
            id_sucursal: facturaData.id_sucursal,
            facturador: facturaData.facturador,
            cliente: facturaData.cliente, // Supongamos que el cliente es el CI/RUC
            medidor_id: facturaData.medidor_id,
            valor_sin_impuesto: facturaData.valor_sin_impuesto,
            iva: facturaData.iva,
            total: facturaData.total,
            id_factura:idFactura,
            detalles: detalles
        };

        console.log("Datos de la factura:", facturaDataScript);
        apiURL= `${baseURL}/Junta_Agua/app/api/edita_factura.php`;
        fetch(apiURL, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify(facturaDataScript),
        })
            .then((response) => {
                if (!response.ok) {
                    throw new Error("Error en la respuesta del servidor");
                }
                return response.json();
            })
            .then((data) => {
                if (data.success) {
                    //navegar a la página de inicio
                    alert("Factura guardada exitosamente ");
                    window.location.href = '/Junta_Agua/public/?view=autorizaciones';
                } else {
                    alert("Error al guardar la factura: " + data.message);
                }
            })
            .catch((error) => console.error("Error al guardar la factura:", error));

        return;
            
        } else {
         // Validar los datos antes de enviarlos
        if (!facturaDataScript.fecha_emision || !facturaDataScript.id_sucursal || !facturaDataScript.cliente) {
            alert("Por favor, complete todos los campos obligatorios.");
            console.log("Datos de la factura:", facturaDataScript);

            return;
        } 
        }

        console.log("Datos de la factura:", facturaDataScript);
        apiURL = `${baseURL}/Junta_Agua/app/api/save_factura.php`;
        fetch(apiURL, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify(facturaDataScript),
        })
            .then((response) => {
                if (!response.ok) {
                    throw new Error("Error en la respuesta del servidor");
                }
                return response.json();
            })
            .then((data) => {
                if (data.success) {
                    //navegar a la página de inicio
                    alert("Factura guardada exitosamente ");
                    window.location.href = '/Junta_Agua/public/?view=factura/nuevafactura';
                } else {
                    alert("Error al guardar la factura: " + data.message);
                }
            })
            .catch((error) => console.error("Error al guardar la factura:", error));
    });

//-------------------------------------------------------------------------------------------------------


let medicionData = {
    lectura1: "--",
    lectura2: "--",
    lectura3: "--",
};

async function obtenerLecturas() {
    const fechaEmision = document.getElementById('fecha-emision').value;
    facturaData.medidor_id = document.getElementById("concepto").value;
    const medidorId = facturaData.medidor_id;

    if (!fechaEmision || !medidorId) {
        console.error('La fecha de emisión o el medidor_id no están definidos');
        return;
    }

    const fechaActual = new Date(fechaEmision);
    const mesEmision = fechaActual.getMonth() + 1;
    const yearEmision = fechaActual.getFullYear();

    let mesAnterior = mesEmision - 1;
    let yearAnterior = yearEmision;

    if (mesAnterior === 0) {
        mesAnterior = 12;
        yearAnterior -= 1;
    }

    let mesAntesDeAnterior = mesAnterior - 1;
    let yearAntesDeAnterior = yearAnterior;

    if (mesAntesDeAnterior === 0) {
        mesAntesDeAnterior = 12;
        yearAntesDeAnterior -= 1;
    }

    try {
        const response = await fetch(`/Junta_Agua/app/models/obtener_lecturas.php?medidor_id=${medidorId}&mes_emision=${mesEmision}&year_emision=${yearEmision}&mes_anterior=${mesAnterior}&year_anterior=${yearAnterior}&mes_antes_anterior=${mesAntesDeAnterior}&year_antes_anterior=${yearAntesDeAnterior}`);
        const dataLecturas = await response.json();

        medicionData.lectura1 = String(dataLecturas.lectura_1);
        medicionData.lectura2 = String(dataLecturas.lectura_2);
        medicionData.lectura3 = String(dataLecturas.lectura_3);
    } catch (error) {
        console.error('Error al obtener las lecturas:', error);
    }
}

// Llama a la función
obtenerLecturas();


</script>

<script type="module">
    const baseURL = `${window.location.protocol}//${window.location.host}`;
    let apiURL = ``;
    // Función para obtener un parámetro de la URL
    function getQueryParam(param) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(param);
    }

    // Función para cargar los detalles de la factura desde ambas APIs
    async function loadFacturaDetails() {
        const idFactura = getQueryParam('id'); // Obtener el ID de la factura desde la URL

        if (!idFactura) {
            console.warn("No se proporcionó un ID de factura. Deteniendo carga.");
            return; // No ejecutar más si no hay ID
        }

        try {
            // Primera API: Obtener información general de la factura
            apiURL = `${baseURL}/Junta_Agua/app/api/get_facturas_by_id.php?id=${idFactura}`;
            const generalResponse = await fetch(apiURL);

            if (!generalResponse.ok) {
                throw new Error(`Error al obtener información general: ${generalResponse.status}`);
            }

            const generalResult = await generalResponse.json();

            if (!generalResult.success) {
                throw new Error(generalResult.message || 'Error al obtener información general de la factura.');
            }

            const facturaDetails = generalResult.data;
            console.log('Detalles generales de la factura:', facturaDetails);

            // Actualizar los valores en el formulario con los datos generales
            document.getElementById('fecha-emision').value = facturaDetails.fecha_emision || '';
            document.getElementById('fecha-vencimiento').value = facturaDetails.fecha_vencimiento || '';
            document.getElementById('serie').value = '001'; // Valor predeterminado
            document.getElementById('secuencia').value = facturaDetails.secuencia || '';
            document.getElementById('ci-ruc').value = facturaDetails.ci_ruc || '';
            document.getElementById('nombre-cliente').value = facturaDetails.cliente || '';
            document.getElementById("totalResumen").querySelector("span").textContent = facturaData.total || "0.00";
            // Actualizar el select de medidores/conceptos
            const medidorSelect = document.getElementById("concepto");
            const medidorId = facturaDetails.medidor_id;

            medidorSelect.innerHTML = ""; // Limpiar todas las opciones existentes

            if (medidorId) {
                const newOption = document.createElement("option");
                newOption.value = medidorId;
                newOption.textContent = `${medidorId}`; // Texto visible en el <select>
                medidorSelect.appendChild(newOption);
                medidorSelect.value = medidorId;
            } else {
                console.warn("No se encontró un ID de medidor válido.");
            }

            // Segunda API: Obtener detalles específicos de la factura
            apiURL = `${baseURL}/Junta_Agua/app/api/get_facturaDetallesbyId.php?id=${idFactura}`;
            const detallesResponse = await fetch(apiURL);

            if (!detallesResponse.ok) {
                throw new Error(`Error al obtener detalles: ${detallesResponse.status}`);
            }

            const detallesResult = await detallesResponse.json();

            if (!detallesResult.success) {
                throw new Error(detallesResult.message || 'Error al obtener detalles de la factura.');
            }

            const detalleFactura = detallesResult.data;
            console.log('Detalles de la factura:', detalleFactura);

            // Cargar detalles de la factura en la tabla
            const tableBody = document.querySelector('.factura-detalle table tbody');
            tableBody.innerHTML = ""; // Limpiar la tabla

            if (detalleFactura.length > 0) {
                detalleFactura.forEach((detalle) => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td data-id="${detalle.codigo}">${detalle.codigo}</td>
                        <td>${detalle.descripcion}</td>
                        <td><input type="number" value="${detalle.cantidad}" min="1" class="cantidad-input" required></td>
                        <td><input type="number" value="${parseFloat(detalle.precio || 0).toFixed(2)}" min="0" class="precio-input" required></td>
                        <td><input type="number" value="${parseFloat(detalle.Descuento || 0).toFixed(2)}" min="0" class="descuento-input" required></td>
                        <td class="iva-table">0.00</td>
                        <td class="total">${parseFloat(detalle.total || 0).toFixed(2)}</td>
                        <td><button type="button" class="delete-btn">Eliminar</button></td>
                    `;

                    // Eventos para actualizar valores en tiempo real
                    row.querySelector('.cantidad-input').addEventListener('input', actualizarTotal);
                    row.querySelector('.precio-input').addEventListener('input', actualizarTotal);
                    row.querySelector('.descuento-input').addEventListener('input', actualizarTotal);

                    // Evento para eliminar la fila
                    row.querySelector('.delete-btn').addEventListener('click', () => {
                        row.remove();
                        actualizarResumen();
                    });

                    tableBody.appendChild(row);
                });
                actualizarResumen();

            } else {
                tableBody.innerHTML = '<tr><td colspan="9">No hay detalles disponibles.</td></tr>';
            }

        } catch (error) {
            console.error('Error al cargar los detalles de la factura:', error);
            alert('No se pudo cargar la factura. Verifica la consola para más detalles.');
        }
    }

    // Función para actualizar los totales de una fila
    function actualizarTotal(event) {
        const row = event.target.closest('tr');
        const cantidad = parseFloat(row.querySelector('.cantidad-input').value) || 0;
        const precio = parseFloat(row.querySelector('.precio-input').value) || 0;
        const descuento = parseFloat(row.querySelector('.descuento-input').value) || 0;

        const ivaPorcentaje = parseFloat(row.getAttribute("data-iva")) || 0;
            const iva = cantidad * precio * (ivaPorcentaje); // Recalcular el IVA

            // Subtotal (sin IVA ni descuento)
            const subtotal = cantidad * precio - descuento;

            // Total de la fila (subtotal + IVA)
            const total = subtotal + iva;

        row.querySelector(".iva-table").textContent = iva.toFixed(2); // Actualizar el valor de IVA
        row.querySelector(".total").textContent = total > 0 ? total.toFixed(2) : "0.00"; // Actualizar el valor Total
        actualizarResumen();
    }

    // Función para actualizar el resumen general
    function actualizarResumen() {
        const filas = document.querySelectorAll('.factura-detalle table tbody tr');
        let subTotal = 0; // Suma de subtotales (cantidad * precio unitario)
            let descuentoTotal = 0; // Suma de descuentos
            let netoTotal = 0; // Neto sin IVA
            let ivaTotal = 0; // Suma de IVA
            let totalConIVA = 0; // Suma de totales con IVA y descuento aplicados

            filas.forEach((fila) => {
                const cantidad = parseFloat(fila.querySelector(".cantidad-input").value) || 0;
                const precio = parseFloat(fila.querySelector(".precio-input").value) || 0;
                const descuento = parseFloat(fila.querySelector(".descuento-input").value) || 0;
                const ivaUnitario = parseFloat(fila.querySelector(".iva-table").textContent) || 0; // El IVA directo de la celda

                const subtotalFila = cantidad * precio; // Subtotal sin IVA ni descuento
                const netoFila = subtotalFila - descuento; // Neto sin IVA
                const ivaFila = ivaUnitario; // El IVA ya está precalculado
                const totalFila = netoFila + ivaFila; // Total con IVA

                // Sumar los valores para el resumen
                subTotal += subtotalFila;
                descuentoTotal += descuento;
                netoTotal += netoFila; // Neto sin IVA
                ivaTotal += ivaFila; // IVA total
                totalConIVA += totalFila; // Total con IVA y descuento aplicados
            });

            // Actualizar los valores en el resumen
            document.querySelector(".resumen-totales p:nth-child(2) span").textContent = subTotal.toFixed(2); // Subtotal
            document.querySelector(".resumen-totales p:nth-child(3) span").textContent = descuentoTotal.toFixed(2); // Descuento total
            document.getElementById("netoResumen").querySelector("span").textContent = netoTotal.toFixed(2); // Neto total
            document.getElementById("ivaResumen").querySelector("span").textContent = ivaTotal.toFixed(2); // IVA total
            document.getElementById("totalResumen").querySelector("span").textContent = totalConIVA.toFixed(2); // Total con IVA
    }

    // Cargar los datos al inicio
    document.addEventListener('DOMContentLoaded', loadFacturaDetails);
</script>