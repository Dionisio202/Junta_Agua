<?php
$fechaHoraActual = date("d/m/Y H:i:s"); 
?>

<head>
    <style>
        /* Aquí van tus estilos */
        .btn {
            border: none; 
            color: white; 
            padding: 14px 28px; 
            cursor: pointer; 
            border-radius: 5px; 
            background: #000000;
            font-size: 16px; 
            transition: background 0.3s;
        }
        .btn:hover {
            background: #444; 
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
            background-color: rgba(0, 0, 0, 0.5); 
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; 
            padding: 20px;
            border: 1px solid #888;
            width: 500px; 
            text-align: center; 
            border-radius: 8px; 
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

        /* Estilos para las tablas */
        table {
            width: 100%;
            border-collapse: collapse; 
            margin: 10px 0; 
        }

        th, td {
            border: 1px solid #888; 
            padding: 8px; 
            text-align: center; 
        }

        /* Contenedor para las tablas */
        .tabla-container {
            display: flex; 
            justify-content: space-between; 
            align-items: flex-start; 
        }

        .tabla-container > div {
            flex: 1; 
            margin: 0 10px; 
        }

        /* Estilos para los campos de información */
        .info-item {
            display: flex; 
            justify-content: space-between; 
            margin: 10px 0; 
        }
    </style>
</head>
<body>
    <div id="miModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="cerrarModal()">&times;</span>
            <h2>JUNTA ADMINISTRADORA DE AGUA POTABLE</h2>
            <p>“San Vicente Yaculoma y Bellavista El Rosario”</p>
            <div class="info">
                <div class="info-item">
                    <span>Cuenta:</span>
                    <span id="cuenta"></span>
                </div>
                <div class="info-item">
                    <span>Nombre:</span>
                    <span id="nombre"></span>
                </div>
                <div class="info-item">
                    <span>Cédula:</span>
                    <span id="cedula"></span>
                </div>
                <div class="info-item">
                    <span>Fecha y Hora:</span>
                    <span id="fechaHora"><?php echo $fechaHoraActual; ?></span> <!-- Mostrar fecha y hora actuales -->
                </div>
            </div>

            <div class="tabla-container">
                <div>
                    <table>
                        <tr>
                            <th colspan="4">Historial de Consumo</th>
                        </tr>
                        <tr>
                            <td>Meses</td>
                            <th id="mes1"></th>
                            <th id="mes2"></th>
                            <th id="mes3"></th>
                        </tr>
                        <tr>
                            <td>Valor</td>
                            <td id="valor1"></td>
                            <td id="valor2"></td>
                            <td id="valor3"></td>
                        </tr>
                    </table>
                </div>
                <div>
                    <table>
                        <tr>
                            <th>Total Pendiente:</th>
                        </tr>
                        <tr>
                            <td id="totalPendiente"></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="info-item">
                <span>Meses Pagados:</span>
                <span id="mesesPagados"></span>
            </div>
            <div class="info-item">
                <span>Pagado:</span>
                <span id="pagado"></span>
            </div>
            <button class="btn" onclick="imprimir()">IMPRIMIR</button>
        </div>
    </div>

</body>
