<?php
// Definición del array de datos
$datos = [ 
    "Cuenta" => "999",
    "Nombre" => "Luis Miguel Gallego Basteri",
    "Cedula" => "1234567890",
    // Aquí se carga la fecha y hora actual de la computadora
    "FechaHora" => date("d/m/Y, H:i:s"), // Formato: dd/mm/aaaa, hh:mm:ss
    "Mes" => "OCT",
    "Mes_1" => "SEP",
    "Mes_2" => "AGO",
    "MesV" => 23.5,
    "Mes_1V" => 27.3,
    "Mes_2V" => 34.1,
    "TotalPendiente" => 62.4,
    "MesesPagados" => 1,
    "Pagado" => 23.5
];

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modal Emergente</title>
    <script>
        // Pasar el array de PHP a JavaScript
        var datos = <?php echo json_encode($datos); ?>;

        // Función para abrir el modal y cargar datos
        function abrirModal() {
            document.getElementById('cuenta').innerText = datos.Cuenta;
            document.getElementById('nombre').innerText = datos.Nombre;
            document.getElementById('cedula').innerText = datos.Cedula;
            document.getElementById('fechaHora').innerText = datos.FechaHora;
            document.getElementById('mes1').innerText = datos.Mes;
            document.getElementById('mes2').innerText = datos.Mes_1;
            document.getElementById('mes3').innerText = datos.Mes_2;
            document.getElementById('valor1').innerText = datos.MesV;
            document.getElementById('valor2').innerText = datos.Mes_1V;
            document.getElementById('valor3').innerText = datos.Mes_2V;
            document.getElementById('totalPendiente').innerText = datos.TotalPendiente;
            document.getElementById('mesesPagados').innerText = datos.MesesPagados;
            document.getElementById('pagado').innerText = datos.Pagado;

            document.getElementById('miModal').style.display = 'block';
        }

        // Función para cerrar el modal
        function cerrarModal() {
            document.getElementById('miModal').style.display = 'none';
        }

        // Cerrar el modal si se hace clic fuera de él
        window.onclick = function(event) {
            const modal = document.getElementById('miModal');
            if (event.target === modal) {
                cerrarModal();
            }
        }

        // Función para imprimir
        function imprimir() {
            // Abrir una ventana emergente con el contenido del ticket
            window.open('ticket.php', 'Ticket', 'width=400,height=600');
        }
    </script>
</head>
<body>
    <header>
        <h1>Mi Aplicación</h1>
    </header>
    <button onclick="abrirModal()">Abrir Mensaje Emergente</button>

    <!-- Incluir el modal desde un archivo PHP -->
    <?php include 'modal.php'; ?>

</body>
</html>
