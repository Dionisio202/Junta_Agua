import { getData } from './data.js';
import { applyFilters, getFilters } from './filters_autorization.js';
import { renderPagination } from './pagination_utils.js';

let data = []; // Datos originales
let filteredData = []; // Datos filtrados
let currentPage = 1;
const rowsPerPage = 5;

// Renderiza la tabla
export function renderTable(page = 1) {
  const startIndex = (page - 1) * rowsPerPage;
  const endIndex = startIndex + rowsPerPage;
  const pageData = filteredData.slice(startIndex, endIndex);

  const tableBody = document.getElementById("table-body");
  tableBody.innerHTML = pageData.map((factura) => `
    <tr data-id="${factura.secuencia}">
      <td><input type="checkbox"></td>
      <td>${factura.autorizado ? "Sí" : "No"}</td>
      <td>${factura.emision}</td>
      <td>${factura.serie}</td>
      <td>${factura.secuencia}</td>
      <td>${factura.cliente}</td>
      <td>${factura.importe}</td>
      <td>${factura.mensajeError}</td>
      <td class="acciones">
        <a href="?view=factura/nuevafactura&id=${factura.secuencia}" class="edit-icon" title="Editar">
          <i class="fas fa-edit"></i>
        </a>
        <a href="javascript:void(0)" class="delete-icont" title="Borrar" data-id="${factura.secuencia}">
          <i class="fas fa-trash"></i>
        </a>
      </td>
    </tr>
  `).join("");

  renderPagination(filteredData, currentPage, rowsPerPage, changePage);

  // Añade evento solo para el botón de eliminar
  document.querySelectorAll(".delete-icont").forEach((icon) => {
    icon.removeAttribute("onclick"); // Elimina cualquier atributo inline
    icon.addEventListener("click", async (e) => {
      const facturaId = e.currentTarget.getAttribute("data-id");
      if (confirm(`¿Seguro que deseas borrar la factura con ID ${facturaId}?`)) {
        try {
          const response = await fetch(`http://localhost/Junta_Agua/app/api/update_deleted_Stated?id=${facturaId}`, {
            method: "GET",
          });
  
          if (!response.ok) {
            throw new Error(`Error al borrar la factura: ${response.statusText}`);
          }
  
          const result = await response.json();
          if (result.success) {
            alert(`Factura ${facturaId} actualizada a 'Eliminado'.`);
         
          } else {
            alert(`Error al borrar la factura: ${result.message}`);
          }
        } catch (error) {
          console.error("Error al borrar la factura:", error);
          alert(`Ocurrió un error al borrar la factura: ${error.message}`);
        }
      }else	{
        alert("No se ha eliminado la factura");
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