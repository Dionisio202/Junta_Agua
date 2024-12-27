<link rel="stylesheet" href="styles/styles.css">

<div class="user-info">
    <span class="user-role"><?= htmlspecialchars($rol); ?></span>
    <span class="user-name"><?= htmlspecialchars($_SESSION['Nombre'] ?? $nombre ?? 'Usuario'); ?></span>
    <span class="user-apellido"><?= htmlspecialchars($_SESSION['Apellido'] ?? 'Sin apellido'); ?></span>
    <span class="user-id"><?= htmlspecialchars($_SESSION['idUser'] ?? 'Sin ID'); ?></span>
</div>

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
                        <th>Medida</th>
                        <th>Cantidad</th>
                        <th>Precio IVA</th>
                        <th>Desc.</th>
                        <th>IVA</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

        <!-- Resumen de Totales -->
        <div class="datos-resumen">
            <div class="resumen-totales">
                <h3>Resumen de valores</h3>
                <p>Sub Total: <span>6,0000</span></p>
                <p>Descuento %: <span>0,00</span></p>
                <p id="total">Total: <span>6,00</span></p>
                <p>Neto: <span>6,00</span></p>
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
    import { cargarDatos } from '/Junta_Agua/public/scripts/form_nueva_factura.js';
    import { buscarCIRUC } from '/Junta_Agua/public/scripts/buscar_cliente.js';

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

    document.getElementById('actionBtn').addEventListener('click', function (event) {
        // Evitar la recarga o cierre inesperado
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
            // Verifica que el campo de 'total' exista
            total: document.getElementById('total') ? document.getElementById('total').textContent : '0.00'
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
    let contadorProductos = 1; // Contador para numerar los productos

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
                mesSelector.style.display = "block";
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
    function agregarFila(descripcion, mes) {
        const tipo = selectedCodigo.getAttribute("data-tipo");
        const precio = parseFloat(selectedCodigo.getAttribute("data-precio"));
        const cantidad = 1; // Valor inicial para la cantidad
        const descuento = 0; // Asume descuento inicial en 0
        const iva = precio * 0.12; // Calcula el IVA inicial
        const total = cantidad * (precio + iva - descuento);

        // Generar código con el formato personalizado
        const codigo = "abc"
        contadorProductos++; // Incrementar el contador para el siguiente producto

        const fila = document.createElement("tr");
        fila.innerHTML = `
            <td>${codigo}</td>
            <td>${descripcion}</td>
            <td>${mes || "N/A"}</td>
            <td><input type="number" value="${cantidad}" min="1" class="cantidad-input"></td>
            <td><input type="number" value="${precio.toFixed(2)}" min="0" class="precio-input"></td>
            <td><input type="number" value="${descuento.toFixed(2)}" min="0" class="descuento-input"></td>
            <td class="iva">${iva.toFixed(2)}</td>
            <td class="total">${total.toFixed(2)}</td>
        `;

        // Eventos para recalcular y validar
        const cantidadInput = fila.querySelector(".cantidad-input");
        const precioInput = fila.querySelector(".precio-input");
        const descuentoInput = fila.querySelector(".descuento-input");

        cantidadInput.addEventListener("input", actualizarTotal);
        precioInput.addEventListener("input", actualizarTotal);
        descuentoInput.addEventListener("input", actualizarTotal);

        // Validaciones al perder foco (blur)
        cantidadInput.addEventListener("blur", validarCantidad);
        descuentoInput.addEventListener("blur", validarDescuento);

        tablaDatos.appendChild(fila);
        actualizarResumen(); // Actualiza el resumen de totales
    }

    // Validación para cantidad
    function validarCantidad(event) {
        const input = event.target;
        if (parseFloat(input.value) <= 0 || isNaN(parseFloat(input.value))) {
            input.value = 1; // Restablece a 1 si el valor es inválido
        }
        actualizarTotal(event); // Recalcula los totales
    }

    // Validación para descuento
    function validarDescuento(event) {
        const input = event.target;
        const fila = input.closest("tr");
        const cantidad = parseFloat(fila.querySelector(".cantidad-input").value) || 0;
        const precio = parseFloat(fila.querySelector(".precio-input").value) || 0;
        const subtotal = cantidad * precio;

        if (parseFloat(input.value) < 0 || parseFloat(input.value) > subtotal || isNaN(parseFloat(input.value))) {
            input.value = 0; // Restablece a 0 si el valor es inválido
        }
        actualizarTotal(event); // Recalcula los totales
    }

    // Función para actualizar el total y recalcular el IVA y descuento
    function actualizarTotal(event) {
        const fila = event.target.closest("tr");
        const cantidad = parseFloat(fila.querySelector(".cantidad-input").value) || 0;
        const precio = parseFloat(fila.querySelector(".precio-input").value) || 0;
        const descuento = parseFloat(fila.querySelector(".descuento-input").value) || 0;

        // Recalcular IVA y total
        const iva = precio * 0.12; // IVA por unidad
        const total = cantidad * (precio + iva - descuento);

        // Actualiza los valores en la fila
        fila.querySelector(".iva").textContent = (cantidad * iva).toFixed(2); // IVA total
        fila.querySelector(".total").textContent = total > 0 ? total.toFixed(2) : "0.00"; // No permite totales negativos

        actualizarResumen(); // Actualiza el resumen de totales
    }

    // Función para actualizar el resumen de totales
    function actualizarResumen() {
        const filas = tablaDatos.querySelectorAll("tr");
        let subTotal = 0;
        let total = 0;

        filas.forEach((fila) => {
            const cantidad = parseFloat(fila.querySelector(".cantidad-input").value) || 0;
            const precio = parseFloat(fila.querySelector(".precio-input").value) || 0;
            const descuento = parseFloat(fila.querySelector(".descuento-input").value) || 0;
            const iva = precio * 0.12;
            subTotal += cantidad * precio;
            total += cantidad * (precio + iva - descuento);
        });

        document.querySelector(".resumen-totales p:nth-child(2) span").textContent = subTotal.toFixed(2);
        document.getElementById("total").querySelector("span").textContent = total.toFixed(2);
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