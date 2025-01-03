import { getData } from './data.js';
import { applyFilters, getFilters } from './filters_autorization.js';
import { renderPagination } from './pagination_utils.js';

let data = []; // Datos originales
let filteredData = []; // Datos filtrados
let currentPage = 1;
const rowsPerPage = 5;
const baseURL = `${window.location.protocol}//${window.location.host}`;
let apiURL = ``;
// Renderiza la tabla
export function renderTable(page = 1) {
  const startIndex = (page - 1) * rowsPerPage;
  const endIndex = startIndex + rowsPerPage;
  const pageData = filteredData.slice(startIndex, endIndex);

  const tableBody = document.getElementById("table-body");
  tableBody.innerHTML = pageData
    .map((factura, index) => {
      const isDisabled = ["Eliminado", "Autorizado"].includes(factura.estado.trim());

      return `
        <tr data-id="${factura.secuencia}">
          <td><input type="checkbox" class="row-checkbox" data-index="${index}" ${isDisabled ? "disabled" : ""}></td>
          <td>${factura.autorizado ? "Sí" : "No"}</td>
          <td>${factura.emision}</td>
          <td>${factura.serie}</td>
          <td>${factura.secuencia}</td>
          <td>${factura.cliente}</td>
          <td>${factura.importe}</td>
          <td>${factura.estado}</td>
          <td class="acciones">
            ${
              isDisabled
                ? `<span class="disabled-text">Acciones deshabilitadas</span>`
                : `
                <a href="?view=factura/nuevafactura&id=${factura.secuencia}" class="edit-icon" title="Editar">
                  <i class="fas fa-edit"></i>
                </a>
                <a href="javascript:void(0)" class="delete-icont" title="Borrar" data-id="${factura.secuencia}">
                  <i class="fas fa-trash"></i>
                </a>`
            }
          </td>
        </tr>
      `;
    })
    .join("");

  renderPagination(filteredData, currentPage, rowsPerPage, changePage);

  // Inicializa los eventos de los checkboxes
  initializeCheckboxEvents();

  // Añade evento solo para el botón de eliminar si no está deshabilitado
  document.querySelectorAll(".delete-icont").forEach((icon) => {
    icon.removeAttribute("onclick"); // Elimina cualquier atributo inline
    icon.addEventListener("click", async (e) => {
      const facturaId = e.currentTarget.getAttribute("data-id");
      apiURL = `${baseURL}/Junta_Agua/app/api/update_deleted_Stated.php?id=${facturaId}`;
      if (confirm(`¿Seguro que deseas borrar la factura con ID ${facturaId}?`)) {
        try {
          const response = await fetch(
            apiURL,
            {
              method: "GET",
            }
          );
  
          if (!response.ok) {
            throw new Error(`Error al borrar la factura: ${response.statusText}`);
          }
  
          const result = await response.json();
          if (result.success) {
            alert(`Factura ${facturaId} actualizada a 'Eliminado'.`);
            // Redirigir a la página de autorizaciones
            window.location.href = "/Junta_Agua/public/?view=autorizaciones";
          } else {
            alert(`Error al borrar la factura: ${result.message}`);
          }
        } catch (error) {
          console.error("Error al borrar la factura:", error);
          alert(`Ocurrió un error al borrar la factura: ${error.message}`);
        }
      } else {
        alert("No se ha eliminado la factura");
      }
    });
  });
  
}

// Inicializa los eventos de los checkboxes para que solo uno pueda ser seleccionado
function initializeCheckboxEvents() {
  const checkboxes = document.querySelectorAll(".row-checkbox");
  checkboxes.forEach((checkbox) => {
    checkbox.addEventListener("change", (e) => {
      if (e.target.checked) {
        // Deselecciona todos los demás checkboxes
        checkboxes.forEach((cb) => {
          if (cb !== e.target) cb.checked = false;
        });
      }
    });
  });
}

// Cambia de página
export function changePage(page) {
  const totalPages = Math.ceil(filteredData.length / rowsPerPage);
  if (page < 1 || page > totalPages) return;
  currentPage = page;
  renderTable(currentPage);
}

// Aplica los filtros y actualiza la tabla
function updateFilteredData() {
  const filters = getFilters(); // Obtiene los valores de los filtros
  filteredData = applyFilters(data, filters); // Aplica los filtros a los datos originales
  currentPage = 1; // Reinicia a la primera página
  renderTable(currentPage);
}

// Inicializa los eventos de los filtros
function initializeFilters() {
  document.querySelector(".styled-button.consultar").addEventListener("click", updateFilteredData);

  document.querySelector(".styled-button.todos").addEventListener("click", () => {
    document.querySelectorAll(".checkboxCustom input").forEach((checkbox) => (checkbox.checked = false));
    document.querySelectorAll("input[type='date']").forEach((input) => (input.value = ""));
    filteredData = [...data]; // Restablece los datos originales
    currentPage = 1; // Reinicia la paginación
    renderTable(currentPage);
  });
}

// Inicializa la tabla y los filtros
async function initializeTable() {
  data = await getData();
  filteredData = [...data]; // Inicia con todos los datos
  renderTable(currentPage);
  initializeFilters();
}

// Ejecutar al cargar
initializeTable();
