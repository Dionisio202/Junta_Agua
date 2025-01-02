document.addEventListener("DOMContentLoaded", () => {
  const loading = document.getElementById("loading");
  loading.style.display = "none";

  // Función para obtener las secuencias seleccionadas
  function getSelectedSecuencias() {
      const selectedRows = document.querySelectorAll(
          "#table-body input[type='checkbox']:checked"
      );
      return Array.from(selectedRows).map((checkbox) =>
          checkbox.closest("tr").getAttribute("data-id")
      );
  }

  document
      .getElementById("autorizar-btn")
      .addEventListener("click", async () => {
          console.log("Botón presionado, mostrando loading...");
          loading.style.display = "flex";

          try {
              // Obtener las secuencias seleccionadas
              const selectedSecuencias = getSelectedSecuencias();
              if (selectedSecuencias.length === 0) {
                  alert("No hay facturas seleccionadas.");
                  return;
              }

              console.log("Secuencias seleccionadas (originales):", selectedSecuencias);

              // Quitar los ceros a la izquierda de las secuencias seleccionadas
              const cleanedSecuencias = selectedSecuencias.map((secuencia) =>
                  parseInt(secuencia, 10) // Convierte a número y elimina ceros iniciales
              );

              console.log("Secuencias seleccionadas (limpiadas):", cleanedSecuencias);

              for (const idFactura of cleanedSecuencias) {
                  // Obtener los datos de la factura desde el endpoint
                  const fetchFacturaResponse = await fetch(
                      `http://localhost/Junta_Agua/app/api/get_factura_data_by_id.php?id=${idFactura}`
                  );

                  if (!fetchFacturaResponse.ok) {
                      throw new Error("Error al obtener los datos de la factura.");
                  }

                  const facturaResponse = await fetchFacturaResponse.json();
                  console.log("Datos obtenidos de la factura:", facturaResponse);

                  if (!facturaResponse.success) {
                      throw new Error(
                          "Error al obtener los datos de la factura: " +
                              facturaResponse.message
                      );
                  }

                  // Decodificar el JSON desde el campo factura.facturaJSON
                  const facturaData = JSON.parse(
                      facturaResponse.factura.facturaJSON
                  );
                  console.log("Datos decodificados de la factura:", facturaData);

                  // Construir dinámicamente el objeto `data`
                  const data = {
                      ambiente: facturaData.ambiente,
                      razonSocialComprador: facturaData.razonSocialComprador,
                      identificacionComprador: facturaData.identificacionComprador,
                      totalSinImpuestos: facturaData.totalSinImpuestos,
                      correo: facturaData.correo || "default@uta.edu.ec",
                      secuencial: facturaData.secuencial,
                      fechaEmision: facturaData.fechaEmision,
                      direccionComprador: facturaData.direccionComprador,
                      baseImponible: facturaData.baseImponible,
                      importeTotal: facturaData.importeTotal,
                      detalles: facturaData.detalles,
                  };

                  console.log("Objeto data generado dinámicamente:", data);

                  // Generar el XML
                  const generateResponse = await fetch(
                      "http://localhost/Junta_Agua/app/controllers/FacturaXMLController.php",
                      {
                          method: "POST",
                          headers: { "Content-Type": "application/json" },
                          body: JSON.stringify(data),
                      }
                  );

                  const generateResult = await generateResponse.json();
                  console.log("Resultado de generación de XML:", generateResult);
                  if (!generateResult.success) {
                      throw new Error(
                          "Error al generar el XML: " + generateResult.message
                      );
                  }

                  // Decodificar el contenido del archivo
                  const fileContent = atob(generateResult.fileContent);

                  // Crear FormData con el archivo real
                  const formData = new FormData();
                  formData.append(
                      "invoice",
                      new Blob([fileContent], { type: "application/xml" }),
                      "factura.xml"
                  );

                  // Enviar la factura a la API remota
                  const sendResponse = await fetch(
                      "https://facturaqua.com/electronic-invoice",
                      {
                          method: "POST",
                          headers: {
                              Authorization: "Basic " + btoa("admin:admin"),
                          },
                          body: formData,
                      }
                  );
                  

                  if (sendResponse.ok) {
                      const sendResult = await sendResponse.json();
                      console.log("Factura procesada exitosamente:", sendResult.message);
                      console.log("ID de la factura:", idFactura);
                      console.log("ID de la factura:", cleanedSecuencias);

                      // Llamar a la API para actualizar el estado de la factura
                      const updateResponse = await fetch(
                          `http://localhost/Junta_Agua/app/api/upadate_Auth_Fac.php?id=${idFactura}`,
                          {
                            method: "GET",
                          }
                      );

                      

                      const updateResult = await updateResponse.json();
                      console.log("Resultado de la actualización de estado:", updateResult);

                     

                      alert(`Factura ${idFactura} procesada y actualizada a 'Autorizado'.`);
                  } else {
                      throw new Error(
                          "Error al enviar la factura. Código: " + sendResponse.status
                      );
                  }
              }
          } catch (error) {
              console.error("Error:", error);
              alert(error.message);
          } finally {
              loading.style.display = "none"; // Ocultar el loading
          }
      });
});
