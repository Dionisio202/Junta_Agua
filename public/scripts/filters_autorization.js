export function applyFilters(data, filters) {
    return data.filter((factura) => {
      const cumpleAutorizacion =
        (filters.autorizados && factura.autorizado) ||
        (filters.noAutorizados && !factura.autorizado) ||
        (!filters.autorizados && !filters.noAutorizados);
  
      const cumpleFecha =
        (!filters.fechaDesde || new Date(factura.emision) >= new Date(filters.fechaDesde)) &&
        (!filters.fechaHasta || new Date(factura.emision) <= new Date(filters.fechaHasta));
  
      const cumpleTipo =
        (filters.tipos.facturas && factura.tipo === "factura") ||
        (filters.tipos.otros && factura.tipo === "otro") ||
        filters.tipos.todos;
  
      return cumpleAutorizacion && cumpleFecha && cumpleTipo;
    });
  }
  
  export function getFilters() {
    const autorizados = document.querySelector("input[name='autorizado']").checked;
    const noAutorizados = document.querySelector("input[name='noAutorizado']").checked;
    const fechaDesde = document.querySelector("input[name='fechaDesde']").value;
    const fechaHasta = document.querySelector("input[name='fechaHasta']").value;
  
    const tipos = {
      facturas: document.querySelector("input[name='facturas']").checked,
      otros: document.querySelector("input[name='otros']").checked,
      todos: document.querySelector("input[name='todos']").checked,
    };
  
    return {
      autorizados,
      noAutorizados,
      fechaDesde,
      fechaHasta,
      tipos,
    };
  }  