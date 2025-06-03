document.addEventListener("DOMContentLoaded", function() {
    const baseURL = `${window.location.protocol}//${window.location.host}`;
    const apiURL = `${baseURL}/Junta_Agua/app/api/buscar_cliente.php`;

    function buscarClientes(event) {
        event.preventDefault();  // Evitar que el botón recargue la página

        const buscarInput = document.getElementById("buscar").value.trim();
        if (!buscarInput) {
            alert("Por favor, ingrese un criterio de búsqueda.");
            return;
        }

        // Usamos la apiURL definida globalmente y agregamos el parámetro de búsqueda
        const apiConQuery = `${apiURL}?query=${encodeURIComponent(buscarInput)}`;

        fetch(apiConQuery)
            .then((response) => response.json())
            .then((data) => {
                if (!data.error && data.length > 0) {
                    actualizarTabla(data);  // Actualizar la tabla con los nuevos resultados
                } else {
                    alert("No se encontraron resultados.");
                    limpiarTabla();
                }
            })
            .catch((error) => console.error("Error en la búsqueda:", error));
    }

    function actualizarTabla(clientes) {
        const tbody = document.getElementById("tabla-clientes");
        tbody.innerHTML = ""; // Limpiar contenido previo

        clientes.forEach((cliente) => {
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
        } else {
            console.error("No se encontró el elemento con id 'tabla-clientes'.");
        }
    }
});
