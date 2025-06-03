/**
 * Renderiza los controles de paginación
 * @param {Array} data - Datos filtrados para la paginación
 * @param {number} currentPage - Página actual
 * @param {number} rowsPerPage - Número de filas por página
 * @param {Function} onPageChange - Callback para cambiar de página
 */
export function renderPagination(data, currentPage, rowsPerPage, onPageChange) {
    const totalPages = Math.ceil(data.length / rowsPerPage);
    const paginationContainer = document.getElementById("pagination");
  
    paginationContainer.innerHTML = `
      <span class="page-nav ${currentPage === 1 ? "disabled" : ""}" data-page="${currentPage - 1}">Anterior</span>
      ${Array.from({ length: totalPages }, (_, i) => `
        <span class="page-number ${currentPage === i + 1 ? "active" : ""}" data-page="${i + 1}">${i + 1}</span>
      `).join("")}
      <span class="page-nav ${currentPage === totalPages ? "disabled" : ""}" data-page="${currentPage + 1}">Siguiente</span>
    `;
  
    paginationContainer.querySelectorAll("[data-page]").forEach((element) => {
      const page = Number(element.getAttribute("data-page"));
      if (!isNaN(page)) {
        element.addEventListener("click", () => onPageChange(page));
      }
    });
  }