const baseURL = `${window.location.protocol}//${window.location.host}`;
let apiURL = ``;
export function cargarDatos(id) {
  // Cargar los datos del usuario por ID
  apiURL = `${baseURL}/Junta_Agua/app/api/get_user_data.php?id=${id}`;
  fetch(apiURL)
    .then((response) => response.json())
    .then((data) => {
      if (!data.error) {
        // Rellenar los campos del formulario con los datos obtenidos
        document.getElementById("nombre-facturador").value = `${
          data.nombre || ""
        } ${data.apellido || ""}`;
      } else {
        console.error(data.error);
        alert("Usuario no encontrado.");
      }
    })
    .catch((error) =>
      console.error("Error al cargar datos del usuario:", error)
    );

  // Cargar el número de la siguiente factura
  apiURL = `${baseURL}/Junta_Agua/app/api/get_next_factura.php`;
  fetch(apiURL)
    .then((response) => response.json())
    .then((data) => {
      if (!data.error) {
        // Rellenar los campos del formulario con los datos obtenidos
        document.getElementById("secuencia").value = data.nextFactura;
      } else {
        console.error(data.error);
        alert("Factura no encontrada.");
      }
    })
    .catch((error) =>
      console.error("Error al cargar datos de la factura:", error)
    );

  // Cargar las sucursales
  apiURL = `${baseURL}/Junta_Agua/app/api/get_sucursales.php`;
  fetch(apiURL)
    .then((response) => response.json())
    .then((data) => {
      if (data) {
        const sucursalSelect = document.getElementById("sucursal");
        sucursalSelect.innerHTML = ""; // Limpiar las opciones existentes

        // Recorrer el objeto y agregar las sucursales al <select>
        Object.entries(data).forEach(([id, sucursal]) => {
          const option = document.createElement("option");
          option.value = id; // Usar el ID como valor
          option.textContent = `${sucursal.nombre} / ${sucursal.ubicacion}`; // Mostrar nombre y ubicación
          sucursalSelect.appendChild(option);
        });
      } else {
        console.error("No se encontraron sucursales.");
        alert("No se pudieron cargar las sucursales.");
      }
    })
    .catch((error) =>
      console.error("Error al cargar las sucursales:", error)
    );

  // Cargar los datos del modal (productos)
  apiURL = `${baseURL}/Junta_Agua/app/api/get_productos.php`;
  fetch(apiURL)
  .then((response) => response.json())
  .then((data) => {
    if (data) {
      const codigoList = document.getElementById("codigo-list");
      codigoList.innerHTML = ""; // Limpiar las opciones existentes

      // Recorrer el objeto y agregar los productos al modal
      Object.entries(data).forEach(([_, producto]) => {
        const li = document.createElement("li");
        li.setAttribute("data-id", producto.id);
        li.textContent = producto.razon;
        li.setAttribute("data-precio", producto.precio);
        li.setAttribute("data-iva", producto.iva);
        li.setAttribute("data-codigo", producto.codigo);
        const requiereMes = producto.codigo === "EXC001" || producto.codigo === "TB0001";
        li.setAttribute("data-requiere-mes", requiereMes ? "true" : "false");
        codigoList.appendChild(li);
      });
    } else {
      console.error("No se encontraron productos.");
      alert("No se pudieron cargar los productos.");
    }
  })
  .catch((error) => {
    console.error("Error al cargar los productos:", error);
  });
}