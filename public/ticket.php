<?php
// Solo incluir el archivo de index.php sin ejecutar su código
ob_start(); // Iniciar la captura de salida
include 'prefacturaTicket.php'; // Incluye el archivo
ob_end_clean(); // Limpiar la salida y no mostrarla

// Ahora puedes usar la variable $datos
$medidaTicket = 180;
?>

<!DOCTYPE html>
<html>
<head>
    <style>
        * {
            font-size: 12px;
            font-family: 'DejaVu Sans', serif;
        }

        h1 {
            font-size: 18px;
        }

        .ticket {
            margin: 0;
            padding: 0;
            width: <?php echo $medidaTicket ?>px;
            max-width: <?php echo $medidaTicket ?>px;
            text-align: center;
        }

        td, th, tr, table {
            border-top: 1px solid black;
            border-collapse: collapse;
            margin: 0 auto;
        }

        body {
            text-align: center;
            margin: 0;
            padding: 0;
        }

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

        .tabla-container {
            display: flex;
            justify-content: center;
            margin: 10px 0;
        }

        .tabla-container > div {
            margin: 0 10px; /* Espaciado entre tablas */
        }

        .info-item {
            display: flex; 
            justify-content: space-between; 
            margin: 10px 0; 
        }
    </style>
    <script>
        // Función que se ejecuta al cargar la página
        window.onload = function() {
            window.print(); // Abre la ventana de impresión
        };
    </script>
</head>
<body>
    <div class="ticket">
        <h2>JUNTA ADMINISTRADORA DE AGUA POTABLE</h2>
        <p>“San Vicente Yaculoma y Bellavista El Rosario”</p>

        <div class="info-item">
            <strong>Cuenta:</strong>
            <span id="cuenta"><?php echo $datos['Cuenta']; ?></span>
        </div>
        <div class="info-item">
            <strong>Nombre:</strong>
            <span id="nombre"><?php echo $datos['Nombre']; ?></span>
        </div>
        <div class="info-item">
            <strong>Cédula:</strong>
            <span id="cedula"><?php echo $datos['Cedula']; ?></span>
        </div>
        <div class="info-item">
            <strong>Fecha y Hora:</strong>
            <span id="fechaHora"><?php echo $datos['FechaHora']; ?></span>
        </div>

        <div class="tabla-container">
            <div>
                <table>
                    <tr>
                        <th colspan="4">Historial de Consumo</th>
                    </tr>
                    <tr>
                        <th>Meses</th>
                        <th id="mes1"><?php echo $datos['Mes']; ?></th>
                        <th id="mes2"><?php echo $datos['Mes_1']; ?></th>
                        <th id="mes3"><?php echo $datos['Mes_2']; ?></th>
                    </tr>
                    <tr>
                        <td>Valor</td>
                        <td id="valor1"><?php echo $datos['MesV']; ?></td>
                        <td id="valor2"><?php echo $datos['Mes_1V']; ?></td>
                        <td id="valor3"><?php echo $datos['Mes_2V']; ?></td>
                    </tr>
                </table>
            </div>
            <div>
                <table>
                    <tr>
                        <th>Total Pendiente:</th>
                    </tr>
                    <tr>
                        <td id="totalPendiente"><?php echo $datos['TotalPendiente']; ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="info-item">
            <span>Meses Pagados:</span>
            <span id="mesesPagados"><?php echo $datos['MesesPagados']; ?></span>
        </div>
        <div class="info-item">
            <span>Pagado:</span>
            <span id="pagado"><?php echo $datos['Pagado']; ?></span>
        </div>
    </div>
</body>
</html>
 