<?php

$medidaTicket = 235;
// Verificar si existe la cookie 'data'
$data = isset($_COOKIE['data']) ? json_decode($_COOKIE['data'], true) : null;

if ($data) {
    // Puedes acceder a los valores de la cookie de la siguiente forma:
    $emision = $data['emision'] ?? '';
    $vence = $data['vence'] ?? '';
    $serie = $data['serie'] ?? '';
    $numero = $data['numero'] ?? '';
    $secuencia = $data['secuencia'] ?? '';
    $concepto = $data['concepto'] ?? '';
    $ci_ruc = $data['ciRuc'] ?? '';
    $cliente = $data['cliente'] ?? '';
    $total = $data['total'] ?? '';
} else {
    echo "No se encontraron datos en la cookie.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <!-- Incluir la fuente Open Sans desde Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">

    <style>
        .ticket-container * {
            font-size: 11px;
            font-family: 'Open Sans', sans-serif; /* Cambiar a Open Sans */
        }

        .ticket-container h1 {
            font-size: 18px;
        }

        .ticket-container .ticket {
            margin: 0;
            padding: 0;
            width: <?php echo $medidaTicket ?>px;
            max-width: <?php echo $medidaTicket ?>px;
            text-align: center;
        }

        .ticket-container td, 
        .ticket-container th, 
        .ticket-container tr, 
        .ticket-container table {
            border-top: 1px solid black;
            border-collapse: collapse;
            margin: 0 auto;
        }

        .ticket-container body {
            text-align: center;
            margin: 0;
            padding: 0;
        }

        .ticket-container table {
            width: 100%;
            border-collapse: collapse;
            margin: 1px 0;
        }

        .ticket-container th, 
        .ticket-container td {
            border: 1px solid #888;
            padding: 5px;
            text-align: center;
        }

        .ticket-container .tabla-container {
            display: flex;
            justify-content: center;
            margin: 10px 0;
        }

        .ticket-container .tabla-container > div {
            margin: 0 5px; /* Espaciado entre tablas */
        }

        .ticket-container .info-item {
            display: flex; 
            justify-content: space-between; 
            margin-top: 1px;
            margin-bottom: 1px;
        }

        /* Estilos específicos para impresión */
        @media print {
            @page {
                margin: 0;
            }
            .ticket-container body {
                visibility: hidden;
            }
            .ticket-container .ticket {
                visibility: visible;
                position: absolute;
                top: 0;
                left: 0;
                margin-left: 24px;
            }
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
    <div class="ticket-container">
        <div class="ticket">
            <h2>JUNTA ADMINISTRADORA DE AGUA POTABLE</h2>
            <p>“San Vicente Yaculoma y Bellavista El Rosario”</p>

            <div class="info-item">
                <strong>Serie:</strong>
                <span id="cuenta"><?php echo $serie; ?></span>
            </div>
            <div class="info-item">
                <strong>Numero:</strong>
                <span id="cuenta"><?php echo $numero; ?></span>
            </div>
            <div class="info-item">
                <strong>Secuencia:</strong>
                <span id="cuenta"><?php echo $secuencia; ?></span>
            </div>
            <div class="info-item">
                <strong>Concepto:</strong>
                <span id="cuenta"><?php echo $concepto; ?></span>
            </div>
            <div class="info-item">
                <strong>C.I./RUC:</strong>
                <span id="cuenta"><?php echo $ci_ruc; ?></span>
            </div>
            <div class="info-item">
                <strong>Cliente:</strong>
                <span id="cuenta"><?php echo $cliente; ?></span>
            </div>
            <div class="info-item">
                <strong>Emisión:</strong>
                <span id="fechaHora"><?php echo $emision; ?></span>
            </div>
            <div class="info-item">
                <strong>Vence:</strong>
                <span id="fechaHora"><?php echo $vence; ?></span>
            </div>

            <div class="tabla-container">
                <div>
                    <table>
                        <tr>
                            <th colspan="4">Historial de Consumo</th>
                        </tr>
                        <tr>
                            <th>Meses</th>
                            <th id="mes1">5</th>
                            <th id="mes2">5</th>
                            <th id="mes3">5</th>
                        </tr>
                        <tr>
                            <td>Valor</td>
                            <td id="valor1">5</td>
                            <td id="valor2">5</td>
                            <td id="valor3">5</td>
                        </tr>
                    </table>
                </div>
                <div>
                    <table>
                        <tr>
                            <th>Total Pendiente:</th>
                        </tr>
                        <tr>
                            <td id="totalPendiente">5</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="info-item">
                <span>Meses Pagados:</span>
                <span id="mesesPagados">5</span>
            </div>
            <div class="info-item">
                <span>Pagado:</span>
                <span id="pagado"><?php echo $total; ?></span>
            </div>
        </div>
    </div>
</body>
</html>
