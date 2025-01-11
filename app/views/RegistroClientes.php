<?php
// Incluyendo los archivos necesarios para la base de datos y el modelo
require_once __DIR__ . "/../../config/database.php";
require_once __DIR__ . "/../../app/models/Clientes.php";
require_once __DIR__ . "/../../app/controllers/agregar_cliente.php";
require_once __DIR__ . "/../../app/controllers/editar_cliente.php";
require_once __DIR__ . "/../../app/controllers/eliminar_cliente.php";
require_once __DIR__ . "/../../app/controllers/eliminar_cliente.php";


// Crear instancia de la base de datos
$database = new Database();
$db = $database->getConnection();

if (!$db) {
    die("Error de conexión a la base de datos.");
}

// Crear instancia de Cliente
$cliente = new Cliente($db);

// Obtener parámetros de búsqueda
$buscar = isset($_GET['buscar']) ? htmlspecialchars($_GET['buscar']) : '';

// Obtener clientes filtrados por búsqueda
$clientes = $cliente->getClientsBySearch($buscar);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Clientes</title>
    <link rel="stylesheet" href="/Junta_Agua/public/styles/clientes.css">
    <script>
        // Función para buscar clientes y actualizar la tabla sin recargar la página
        function buscarClientes(event) {
            event.preventDefault();  // Evitar la redirección de la página

            const buscarInput = document.getElementById("buscar").value.trim();
            if (!buscarInput) {
                alert("Por favor, ingrese un criterio de búsqueda.");
                return;
            }

            // Realizar la búsqueda con fetch sin recargar la página
            const apiURL = `/Junta_Agua/app/api/buscar_cliente.php?query=${encodeURIComponent(buscarInput)}`;

            fetch(apiURL)
                .then(response => response.json())
                .then(data => {
                    if (data.clientes && data.clientes.length > 0) {
                        actualizarTabla(data.clientes);
                    } else {
                        alert("No se encontraron resultados.");
                        limpiarTabla();
                    }
                })
                .catch(error => console.error("Error en la búsqueda:", error));
        }

        // Función para cargar todos los clientes cuando la página se carga
        function cargarTodosClientes() {
            const apiURL = `/Junta_Agua/app/api/buscar_cliente.php?query=`;

            fetch(apiURL)
                .then(response => response.json())
                .then(data => {
                    if (data.clientes && data.clientes.length > 0) {
                        actualizarTabla(data.clientes);
                    } else {
                        limpiarTabla();
                    }
                })
                .catch(error => console.error("Error al cargar los clientes:", error));
        }

        function actualizarTabla(clientes) {
            const tbody = document.getElementById("tabla-clientes");
            tbody.innerHTML = ""; // Limpiar contenido previo

            clientes.forEach(cliente => {
                const tr = document.createElement("tr");
                tr.innerHTML = `
                    <td>${cliente.id}</td>
                    <td>${cliente.identificacion}</td>
                    <td>${cliente.razon_social}</td>
                    <td>${cliente.direccion}</td>
                    <td>${cliente.telefono1}</td>
                    <td>${cliente.telefono2}</td>
                    <td>${cliente.correo}</td>
                    <td>
                        <a href="/Junta_Agua/app/views/editar.php?id=${cliente.id}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="/Junta_Agua/app/controllers/eliminar_cliente.php" method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="${cliente.id}">
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este cliente?')">Eliminar</button>
                        </form>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        }

        function limpiarTabla() {
            const tbody = document.getElementById("tabla-clientes");
            if (tbody) {
                tbody.innerHTML = "<tr><td colspan='8' class='text-center'>No hay resultados para mostrar.</td></tr>";
            }
        }

        // Evento para el formulario de búsqueda
        document.addEventListener("DOMContentLoaded", function () {
            // Cargar todos los clientes al iniciar la página
            cargarTodosClientes();

            const buscarButton = document.getElementById("buscar-btn");
            buscarButton.addEventListener("click", buscarClientes);
        });
    </script>
</head>

<body>
    <!-- <div class="user-info">
        <span class="user-role"><?= htmlspecialchars($rol); ?></span>
        <span class="user-name"><?= htmlspecialchars($nombre ?? 'Usuario'); ?></span>
    </div> -->

    <div class="table-container">
        <h1>Gestión de Clientes</h1>
        <h2>Agregar Cliente</h2>
        <form class="form" action="/Junta_Agua/app/controllers/agregar_cliente.php" method="POST">
            <div class="flex-group">
            <div class="form-group form-item">
                    <label for="identificacion">Identificación:</label>
                    <input type="text" name="identificacion" class="form-control" placeholder="Identificación" required>
                </div>
                <div class="form-group form-item">
                    <label for="razon_social">Razón Social:</label>
                    <input type="text" name="razon_social" class="form-control" placeholder="Razón Social" required>
                </div>
                <div class="form-group form-item">
                    <label for="direccion">Dirección:</label>
                    <input type="text" name="direccion" class="form-control" placeholder="Dirección" required>
                </div>
                <div class="form-group form-item">
                    <label for="telefono1">Teléfono 1:</label>
                    <input type="text" name="telefono1" class="form-control" placeholder="Teléfono 1" required>
                </div>
                <div class="form-group form-item">
                    <label for="telefono2">Teléfono 2:</label>
                    <input type="text" name="telefono2" class="form-control" placeholder="Teléfono 2">
                </div>
                <div class="form-group form-item">
                    <label for="correo">Correo:</label>
                    <input type="email" name="correo" class="form-control" placeholder="Correo">
                </div>
            </div>    
            <button type="submit" class="btn btn-success w-100">Agregar Cliente</button>
        </form>
    
        <h2>Buscar Cliente</h2>
        <div class="filters">
            <input 
                type="text" 
                id="buscar" 
                class="filter-input" 
                placeholder="Buscar por ID, Identificación o Razón Social" 
            >
            <button id="buscar-btn">Buscar</button>
        </div>

        <!-- Tabla de clientes -->
        <h2>Lista de Clientes</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Identificación</th>
                    <th>Razón Social</th>
                    <th>Dirección</th>
                    <th>Teléfono 1</th>
                    <th>Teléfono 2</th>
                    <th>Correo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="tabla-clientes">
            </tbody>
        </table>
    </div>


</body>
</html>
