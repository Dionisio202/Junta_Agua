import { getData } from './data.js';
import { applyFilters, getFilters, initializeDocumentStateFilter, initializeFilterButtons, initializeDocumentTypeFilter } from './filters_autorization.js';
import { renderTable } from './pagination.js';

let data = []; // Datos originales
let filteredData = []; // Datos filtrados
let currentPage = 1;

async function initializeApp() {
  try {
    data = await getData(); // Obtiene los datos desde la API
    filteredData = [...data]; // Inicializa los datos filtrados
    renderTable(currentPage); // Renderiza la tabla inicial

    // Inicializa los filtros
    initializeFilterButtons(() => {
      const filters = getFilters();
      filteredData = applyFilters(data, filters);
      currentPage = 1;
      renderTable(currentPage);
    });

    initializeDocumentTypeFilter(); // Inicializa el filtro de tipos de documentos
    initializeDocumentStateFilter(); // Inicializa el filtro de estado de documentos
  } catch (error) {
    console.error("Error al inicializar la aplicación:", error);
  }
}

// Ejecutar al cargar el DOM
document.addEventListener("DOMContentLoaded", initializeApp);