import { getData } from './data.js';
import { applyFilters, getFilters } from './filters_autorization.js';
import { renderPagination } from './pagination.js';

let data = [];
let filteredData = [];
let currentPage = 1;
const rowsPerPage = 5;

function renderTable(page = 1) {
  const startIndex = (page - 1) * rowsPerPage;
  const endIndex = startIndex + rowsPerPage;
  const pageData = filteredData.slice(startIndex, endIndex);

  const tableBody = document.getElementById("table-body");
  tableBody.innerHTML = pageData.map((factura) => `
    <tr>
      <td><input type="checkbox"></td>
      <td>${factura.autorizado ? "Sí" : "No"}</td>
      <td>${factura.emision}</td>
      <td>${factura.serie}</td>
      <td>${factura.secuencia}</td>
      <td>${factura.cliente}</td>
      <td>${factura.importe}</td>
      <td>${factura.mensajeError}</td>
    </tr>
  `).join("");

  renderPagination(filteredData, currentPage, rowsPerPage, (page) => {
    currentPage = page;
    renderTable(currentPage);
  });
}

function initializeFilters() {
  document.querySelector(".styled-button.consultar").addEventListener("click", () => {
    const filters = getFilters();
    filteredData = applyFilters(data, filters);
    currentPage = 1;
    renderTable(currentPage);
  });

  document.querySelector(".styled-button.todos").addEventListener("click", () => {
    document.querySelectorAll(".checkboxCustom input").forEach((checkbox) => (checkbox.checked = false));
    document.querySelectorAll("input[type='date']").forEach((input) => (input.value = ""));
    filteredData = [...data];
    currentPage = 1;
    renderTable(currentPage);
  });
}

async function initializeApp() {
  data = await getData();
  filteredData = [...data];
  renderTable(currentPage);
  initializeFilters();
}

initializeApp();