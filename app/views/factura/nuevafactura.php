<div class="user-info">
  
<span class="user-role"><?= htmlspecialchars($rol); ?></span>
    <span class="user-name"><?= htmlspecialchars($nombre ?? 'Usuario'); ?></span>
</div>

<div class="table-container">
    <div class="header-buttons">
        <h1>Facturación <?= $rol === 'Tesorero' ? 'TESORERÍA' : ''; ?></h1>
    </div>

    <!-- Barra de botones -->
    <div class="button-bar">
        <button class="add-btn">Agregar nueva Factura</button>
        <button class="save-btn">Guardar</button>
        <button class="edit-btn">Modificar</button>
        <button class="delete-btn">Eliminar</button>
    </div>

    <!-- Integración de la nueva sección con campos de formulario -->
    <div class="seccion-factura">
        <form>
            <div class="pestana-mantenimiento">
                <h2>Mantenimiento</h2>

                <label for="fecha-emision">Emisión:</label>
                <input type="date" id="fecha-emision" value="2024-10-28">

                <label for="fecha-vencimiento">Vence:</label>
                <input type="date" id="fecha-vencimiento" value="2024-10-28">

                <label for="serie">Serie:</label>
                <input type="text" id="serie" value="001">

                <label for="numero">Número:</label>
                <input type="text" id="numero" value="200">

                <label for="secuencia">Secuencia:</label>
                <input type="text" id="secuencia" value="000006001" readonly>

                <label for="concepto">Concepto:</label>
                <input type="text" id="concepto" value="M186">

                <label for="ci-ruc">C.I./RUC:</label>
                <div class="input-group">
                    <input type="text" id="ci-ruc" value="1803110517">
                    <button type="button" class="btn-busqueda" onclick="buscarCIRUC()">
                        🔍
                    </button>
                </div>

                <label for="nombre-cliente">Cliente:</label>
                <input type="text" id="nombre-cliente" value="GALARZA GALARZA NANCY ROCIO">

                <label for="codigo">Código:</label>
                <div class="input-group">
                    <input type="text" id="codigo">
                    <button type="button" class="btn-busqueda" onclick="buscarCodigo()">
                        🔍
                    </button>
                </div>

                <div class="botones">
                    <button type="button" class="btn-informacion">Información</button>
                    <button type="button" class="btn-observacion">Observación</button>
                    <button type="button" class="btn-existencias">Existencias</button>
                </div>
            </div>

            <div class="pestana-datos-adicionales">
                <label for="facturador">Facturador:</label>
                <input type="text" id="nombre-facturador" value="usuario logueado" readonly>

                <label for="sucursal">Sucursal:</label>
                <select id="sucursal">
                    <option selected>MATRIZ / SANTA ROSA</option>
                    <!-- Agregar más opciones si es necesario -->
                </select>
            </div>
        </form>
    </div>

    <!-- Botones existentes y tabla -->
    <div class="buttons">
        <button class="export-btn">Exportar datos</button>
    </div>

    <div class="table-container">
        <!-- Integración de la sección de detalle de facturas -->
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

                <!-- Ejemplo de datos de facturas -->
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
                <!-- Agrega más filas según sea necesario -->
            </table>
        </div>

        <!-- Sección de Datos Documento 
    <div class="datos-documento">
        <h3>Datos Documento</h3>
        <label for="clave-acceso">Clave de Acceso:</label>
        <input type="text" id="clave-acceso" value="281020240118918094490012001200000060011234567816" readonly>

        <label for="autorizacion">Autorización:</label>
        <input type="text" id="autorizacion" value="281020240118918094490012001200000060011234567816" readonly>
    </div>
    -->
        <!-- Sección de Datos Documento Relacionado -->
        <div class="datos-documento-relacionado">
            <h3>Datos Documento Relacionado</h3>
            <label for="emision-relacionado">Emisión:</label>
            <input type="text" id="emision-relacionado">

            <label for="secuencia-relacionado">Secuencia:</label>
            <input type="text" id="secuencia-relacionado">
        </div>

        <!-- Resumen de Totales -->
        <div class="resumen-totales">
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
            <h3>Total: <span>6,00</span></h3>
            <h3>Neto: <span>6,00</span></h3>
        </div>
    </div>
</div>