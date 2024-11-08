<div class="user-info">
    <span class="user-role"><?= htmlspecialchars($rol); ?></span>
    <span class="user-name"><?= htmlspecialchars($_SESSION['nombre'] ?? 'Usuario'); ?></span>
</div>

<div class="table-container">
    <div class="header-buttons">
        <h1>Facturación TESORERÍA</h1>
    </div>

    <!-- Barra de botones -->
    <div class="button-bar">
        <button class="add-btn">Agregar nueva Factura</button>
        <button class="save-btn">Guardar</button>
        <button class="edit-btn">Modificar</button>
        <button class="delete-btn">Eliminar</button>
    </div>

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