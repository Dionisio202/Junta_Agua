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

    // Añade un evento para el botón "Actualizar"
    document.querySelector(".styled-button.actualizar").addEventListener("click", async () => {
      try {
        console.log("Recargando datos...");
        data = await getData(); // Obtiene los datos actualizados desde la API
        filteredData = [...data]; // Resetea los datos filtrados con los nuevos datos
        currentPage = 1; // Reinicia a la primera página
        renderTable(currentPage); // Renderiza la tabla con los nuevos datos
        console.log("Datos actualizados correctamente.");
      } catch (error) {
        console.error("Error al actualizar los datos:", error);
        alert("No se pudieron actualizar los datos. Intenta nuevamente.");
      }
    });
    
    document.querySelector(".styled-button.autorizar").addEventListener("click", async () => {
      //Evento para autorizar los datos
    });

  } catch (error) {
    console.error("Error al inicializar la aplicación:", error);
  }
}

// Ejecutar al cargar el DOM
document.addEventListener("DOMContentLoaded", initializeApp);