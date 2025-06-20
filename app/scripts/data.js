const baseURL = `${window.location.protocol}//${window.location.host}`;
let apiURL = ``;
export async function getData() {
  try {
    apiURL = `${baseURL}/Junta_Agua/app/api/get_facturas.php`;
    const response = await fetch(apiURL);
    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    const apiData = await response.json();

    if (Array.isArray(apiData)) {
      return apiData.map((factura) => ({
        id : factura.id,
        autorizado: factura.fecha_autorizacion ? true : false, // Basado en fecha_autorizacion
        emision: factura.fecha_emision || "Fecha no disponible",
        serie: "001",
        secuencia: factura.secuencia	 ? factura.secuencia.toString().padStart(9, "0") : "No disponible",
        cliente: `${factura.razon_social || "Cliente no disponible"} (${factura.identificacion || "ID no disponible"})`,
        importe: factura.total || "0.00",
        mensajeError: factura.mensajeError || "Sin errores",
        tipo: factura.tipo || "otro", // Asegúrate de que el tipo esté definido en la API
        estado:factura.estado_factura || "Sin estado"
      }));
    } else {
      throw new Error("Los datos obtenidos no son válidos.");
    }
  } catch (error) {
    console.error("Error al consumir la API:", error);
    alert("Error al obtener los datos.");
    return [];
  }
}


