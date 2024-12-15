<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facturación</title>
    <link rel="stylesheet" href="styles/styles.css">
    <style>
        /* Estilos para campos deshabilitados */
        input[readonly], select[disabled] {
            background-color: #f5f5f5;
            color: #aaa;
            cursor: not-allowed;
        }

        /* Estilo general para bloquear toda la pantalla */
        .disabled-screen {
            pointer-events: none;
            opacity: 0.9;
        }

        /* Habilitar el selector de "Generar Ticket" */
        #generar-container {
            pointer-events: auto;
            opacity: 1;
        }
    </style>
</head>
<body>
    <div class="user-info">
        <span class="user-role"><?= htmlspecialchars($_SESSION['Rol'] ?? 'Desconocido'); ?></span>
        <span class="user-name"><?= htmlspecialchars($_SESSION['Nombre'] ?? 'Usuario'); ?></span>
        <span class="user-apellido"><?= htmlspecialchars($_SESSION['Apellido'] ?? 'Sin apellido'); ?></span>
        <span class="user-id"><?= htmlspecialchars($_SESSION['idUser'] ?? 'Sin ID'); ?></span>
    </div>

    <div class="table-container disabled-screen">
        <div class="header-buttons">
            <h1>Facturación</h1>
        </div>

        <div class="seccion-factura">
            <h2>Mantenimiento</h2>
            <form>
                <!-- Columna Izquierda -->
                <div class="columna-izquierda">
                    <div class="pestana-datos-adicionales">
                        <label for="facturador">Facturador:</label>
                        <input type="text" id="nombre-facturador" value="" readonly>
                        <label for="sucursal">Sucursal:</label>
                        <select id="sucursal" disabled>
                            <option selected><?= htmlspecialchars($facturaDetalles['id_sucursal'] ?? 'MATRIZ / SANTA ROSA'); ?></option>
                        </select>
                    </div>
                </div>

                <!-- Columna Central -->
                <div class="columna-centro">
                    <div class="pestana-mantenimiento">
                        <div class="grupo">
                            <div>
                                <label for="fecha-emision">Emisión:</label>
                                <input type="date" id="fecha-emision" value="<?= htmlspecialchars($facturaDetalles['fecha_emision'] ?? ''); ?>" readonly>
                            </div>
                            <div>
                                <label for="fecha-vencimiento">Vence:</label>
                                <input type="date" id="fecha-vencimiento" value="<?= htmlspecialchars($facturaDetalles['fecha_vencimiento'] ?? ''); ?>" readonly>
                            </div>
                        </div>
                        <div class="grupo">
                            <div>
                                <label for="serie">Serie:</label>
                                <input type="text" id="serie" value="" readonly>
                            </div>
                            <div>
                                <label for="numero">Número:</label>
                                <input type="text" id="numero" value="" readonly>
                            </div>
                            <div>
                                <label for="secuencia">Secuencia:</label>
                                <input type="text" id="secuencia" value="<?= htmlspecialchars($facturaDetalles['secuencia'] ?? ''); ?>" readonly>
                            </div>
                            <div>
                                <label for="concepto">Concepto:</label>
                                <select id="concepto" disabled>
                                    <option><?= htmlspecialchars($facturaDetalles['id_razon'] ?? 'Ninguno'); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="grupo">
                            <div>
                                <label for="ci-ruc">C.I./RUC:</label>
                                <input type="text" id="ci-ruc" value="<?= htmlspecialchars($facturaDetalles['ci_ruc'] ?? ''); ?>" readonly>
                            </div>
                            <div>
                                <label for="nombre-cliente">Cliente:</label>
                                <input type="text" id="nombre-cliente" value="<?= htmlspecialchars($facturaDetalles['cliente'] ?? ''); ?>" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Columna Derecha -->
                <div class="columna-derecha">
                    <div class="buttons-vertical">
                        <div id="generar-container">
                            <label for="generar">Generar:</label>
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
                        <td>0,00</td>
                        <td>0%</td>
                        <td>3,00</td>
                    </tr>
                    <tr>
                        <td>P000000016</td>
                        <td>Tarifa Básica Julio</td>
                        <td>Unidad</td>
                        <td>1,00</td>
                        <td>3,00</td>
                        <td>0,00</td>
                        <td>0%</td>
                        <td>3,00</td>
                    </tr>
                </table>
            </div>

            <div class="datos-resumen">
                <div class="resumen-totales">
                    <h3>Resumen de valores</h3>
                    <p>Sub Total: <span><?= htmlspecialchars($facturaDetalles['valor_sin_impuesto'] ?? '0.00'); ?></span></p>
                    <p>IVA: <span><?= htmlspecialchars($facturaDetalles['iva'] ?? '0.00'); ?></span></p>
                    <p>Total: <span><?= htmlspecialchars($facturaDetalles['total'] ?? '0.00'); ?></span></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
