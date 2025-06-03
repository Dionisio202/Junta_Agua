const baseURL = `${window.location.protocol}//${window.location.host}`;
let apiURL = ``;
export function buscarCIRUC() {
  const input = document.getElementById("ci-ruc").value;
  // Verificar si el input contiene solo números o letras
  const isNumber = /^[0-9]+$/.test(input); // Expresión regular para verificar si es solo números
  const isLetter = /^[a-zA-Z]+$/.test(input); // Expresión regular para verificar si es solo letras

  if (isNumber) {
    // Realizar búsqueda por números
    apiURL = `${baseURL}/Junta_Agua/app/api/buscar_por_numero.php?numero=${input}`;
    fetch(apiURL)
      .then((response) => response.json())
      .then((data) => {
        if (!data.error) {
          mostrarResultadosEnModal(data); // Llama a la función que muestra el modal con los datos
        } else {
          alert("No se encontraron resultados para el número proporcionado.");
        }
      })
      .catch((error) => console.error("Error en la búsqueda por número:", error));
  } else if (isLetter) {
    // Realizar búsqueda por letras
    apiURL = `${baseURL}/Junta_Agua/app/api/buscar_por_letra.php?letra=${input}`;
    fetch(apiURL)
      .then((response) => response.json())
      .then((data) => {
        if (!data.error) {
          mostrarResultadosEnModal(data); // Llama a la función que muestra el modal con los datos
        } else {
          alert("No se encontraron resultados para las letras proporcionadas.");
        }
      })
      .catch((error) => console.error("Error en la búsqueda por letras:", error));
  } else {
    alert("Por favor, ingrese solo números o letras para realizar la búsqueda.");
  }
}

// Función para mostrar los resultados en un modal
function mostrarResultadosEnModal(data) {
  const modalContent = document.getElementById("modal-content");
  modalContent.innerHTML = ""; // Limpiar contenido previo

  data.forEach((item) => {
    const row = document.createElement("div");
    row.className = "modal-row";
    row.textContent = `${item.nombre} - ${item.cedula}`;
    row.addEventListener("click", () => seleccionarCliente(item)); // Asignar evento de selección
    modalContent.appendChild(row);
  });

  // Mostrar el modal
  const modal = document.getElementById("modal");
  modal.style.display = "block";
}

// Función para seleccionar un cliente y cerrar el modal
function seleccionarCliente(cliente) {
  facturaData.cliente = cliente.id; // Guardar el cliente seleccionado
  document.getElementById("nombre-cliente").value = cliente.nombre;
  document.getElementById("ci-ruc").value = cliente.cedula;
  getMedidores(cliente.id); // Cargar los medidores del cliente seleccionado
  // Ocultar el modal
  const modal = document.getElementById("modal");
  modal.style.display = "none";
}

function getMedidores($input) {
  apiURL = `${baseURL}/Junta_Agua/app/api/get_medidores_cliente.php?cliente=${$input}`;
  fetch(apiURL)
    .then((response) => response.json())
    .then((data) => {
      if (data) {
        const medidorSelect = document.getElementById("concepto");
        medidorSelect.innerHTML = ""; // Limpiar las opciones existentes

        // Recorrer el objeto y agregar los medidores al <select>
        Object.entries(data).forEach(([id, medidor]) => {
          const option = document.createElement("option");
          option.value = medidor.id; // Usar el ID como valor
          option.textContent = `${medidor.id} / ${medidor.marca} / ${medidor.modelo}`; // Mostrar número, marca y modelo
          medidorSelect.appendChild(option);
        });
      } else {
        console.error("No se encontraron medidores.");
        alert("No se pudieron cargar los medidores.");
      }
    })
    .catch((error) => {
      console.error("Error al cargar los medidores:", error);
    });
}