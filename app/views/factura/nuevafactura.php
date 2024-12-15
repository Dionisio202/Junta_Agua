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
                                <input type="text" id="codigo">
                                <button type="button" class="btn-busqueda-producto">🔍</button>
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
                    <div class="generar-select-container">
                        <select id="generar">
                            <option value="ticket">Generar Ticket</option>
                            <option value="pdf">Generar PDF</option>
                        </select>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="table-container">
        <!-- Tabla de Facturas -->
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

        <!-- Resumen de Totales -->
        <div class="datos-resumen">
            <div class="resumen-totales">
                <h3>Resumen de valores</h3>
                <p>Sub Total: <span>6,0000</span></p>
                <p>Descuento %: <span>0,00</span></p>
                <p>Total: <span>6,00</span></p>
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
</script>