export function applyFilters(data, filters) {
  console.log("Datos originales:", data);
  return data.filter((factura) => {
    // Filtrar por estado de autorización
    const cumpleAutorizacion =
      (!filters.autorizados && !filters.noAutorizados) || // Si ambos están desmarcados, no se filtra por estado
      (filters.autorizados && factura.autorizado) ||
      (filters.noAutorizados && !factura.autorizado);

    // Filtrar por fecha de emisión
    const cumpleFecha =
      (!filters.fechaDesde ||
        new Date(factura.emision) >= new Date(filters.fechaDesde)) &&
      (!filters.fechaHasta ||
        new Date(factura.emision) <= new Date(filters.fechaHasta));

    // Filtrar por tipo de documento
    const cumpleTipo =
      (filters.tipos.facturas && factura.tipo === "factura") ||
      (filters.tipos.otros && factura.tipo === "otro") ||
      filters.tipos.todos;

    return cumpleAutorizacion && cumpleFecha && cumpleTipo;
  });
}

export function getFilters() {
  // Obtiene los valores de los checkboxes y campos de fecha
  const autorizados = document.querySelector(
    "input[name='autorizado']"
  ).checked;
  const noAutorizados = document.querySelector(
    "input[name='noAutorizado']"
  ).checked;
  const fechaDesde = document.querySelector("input[name='fechaDesde']").value;
  const fechaHasta = document.querySelector("input[name='fechaHasta']").value;

  const tipos = {
    facturas: document.querySelector("input[name='facturas']").checked,
    otros: document.querySelector("input[name='otros']").checked,
    todos: document.querySelector("input[name='todos']").checked,
  };

  // Retorna un objeto con los filtros
  return {
    autorizados,
    noAutorizados,
    fechaDesde,
    fechaHasta,
    tipos,
  };
}

// Inicializa los eventos de los botones de filtros
export function initializeFilterButtons(onApplyFilters) {
  const consultarButton = document.querySelector(".styled-button.consultar");
  const todosButton = document.querySelector(".styled-button.todos");
  const todosCheckbox = document.querySelector("input[name='todos']");
  if (!consultarButton || !todosButton) {
    console.error("Botones 'Consultar' o 'Todos' no encontrados en el DOM");
    return;
  }

  consultarButton.addEventListener("click", onApplyFilters);

  todosButton.addEventListener("click", () => {
    document
      .querySelectorAll(".checkboxCustom input")
      .forEach((checkbox) => (checkbox.checked = false));
    document
      .querySelectorAll("input[type='date']")
      .forEach((input) => (input.value = ""));
    todosCheckbox.checked = true;
    onApplyFilters();
  });
}

// Inicializa el filtro de tipos de documentos
export function initializeDocumentTypeFilter() {
  const facturasCheckbox = document.querySelector("input[name='facturas']");
  const otrosCheckbox = document.querySelector("input[name='otros']");
  const todosCheckbox = document.querySelector("input[name='todos']");
  if (todosCheckbox) {
    todosCheckbox.checked = true; // Marca el checkbox "Todos" al cargar la página
  }
  if (!facturasCheckbox || !otrosCheckbox || !todosCheckbox) {
    console.error("No se encontraron los checkboxes de tipos de documentos.");
    return;
  }

  // Función para manejar el estado de "Todos"
  function updateTodosState() {
    if (facturasCheckbox.checked && otrosCheckbox.checked) {
      todosCheckbox.checked = true;
      facturasCheckbox.checked = false;
      otrosCheckbox.checked = false;
    }
  }

  // Desmarcar "Todos" si se selecciona "Facturas" o "Otros"
  facturasCheckbox.addEventListener("change", () => {
    if (facturasCheckbox.checked || otrosCheckbox.checked) {
      todosCheckbox.checked = false;
    }
    updateTodosState();
  });

  otrosCheckbox.addEventListener("change", () => {
    if (facturasCheckbox.checked || otrosCheckbox.checked) {
      todosCheckbox.checked = false;
    }
    updateTodosState();
  });

  // Marcar "Todos" si se selecciona y desmarcar los otros
  todosCheckbox.addEventListener("change", () => {
    if (todosCheckbox.checked) {
      facturasCheckbox.checked = false;
      otrosCheckbox.checked = false;
    }
  });
}

// Inicializa el filtro de estado de documentos (Autorizado/No autorizado)
export function initializeDocumentStateFilter() {
  const autorizadoCheckbox = document.querySelector("input[name='autorizado']");
  const noAutorizadoCheckbox = document.querySelector(
    "input[name='noAutorizado']"
  );

  if (!autorizadoCheckbox || !noAutorizadoCheckbox) {
    console.error("No se encontraron los checkboxes de estado de documentos.");
    return;
  }

  // Función para actualizar la tabla según los filtros
  function updateStateFilter() {
    if (!autorizadoCheckbox.checked && !noAutorizadoCheckbox.checked) {
      console.log("No hay filtros aplicados para el estado de documentos.");
    }
  }

  // Asignar eventos a los checkboxes
  autorizadoCheckbox.addEventListener("change", updateStateFilter);
  noAutorizadoCheckbox.addEventListener("change", updateStateFilter);
}
