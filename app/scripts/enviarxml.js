const baseURL = `${window.location.protocol}//${window.location.host}`;
let apiURL = ``;
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

        console.log(
          "Secuencias seleccionadas (originales):",
          selectedSecuencias
        );

        // Quitar los ceros a la izquierda de las secuencias seleccionadas
        const cleanedSecuencias = selectedSecuencias.map(
          (secuencia) => parseInt(secuencia, 10) // Convierte a número y elimina ceros iniciales
        );

        console.log("Secuencias seleccionadas (limpiadas):", cleanedSecuencias);

        for (const idFactura of cleanedSecuencias) {
          // Obtener los datos de la factura desde el endpoint
          apiURL = `${baseURL}/Junta_Agua/app/api/get_factura_data_by_id.php?id=${idFactura}`;
          const fetchFacturaResponse = await fetch(
            apiURL
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
          const facturaData = JSON.parse(facturaResponse.factura.facturaJSON);
          console.log("Datos decodificados de la factura:", facturaData);
          //13 digitos ruc 04 cedula 05 pasaporte 06 consumidor final 07 identificacion exterior 08 placa 09 id extranjero
          // Función para determinar el tipo de identificación
          const determinarTipoIdentificacion = (identificacion) => {
            if (!identificacion || typeof identificacion !== "string")
              return "00"; // Tipo desconocido
            if (identificacion.length === 10) return "05"; // Cédula
            if (identificacion.length === 13 && identificacion.endsWith("001"))
              return "04"; // RUC
            if (identificacion.length < 10) return "06"; // Consumidor final
            return "00"; // Tipo desconocido
          };

          // Función para obtener valores por defecto según el tipo de identificación
          const obtenerValoresPorTipo = (tipoIdentificacion) => {
            switch (tipoIdentificacion) {
              case "05": // Cédula
              case "04": // RUC
                return {
                  razonSocialComprador: facturaData.razonSocialComprador,
                  identificacionComprador: facturaData.identificacionComprador,
                  direccionComprador:
                    facturaData.direccionComprador ||
                    "Dirección no proporcionada",
                };
              case "06": // Consumidor final
                return {
                  razonSocialComprador: "Consumidor Final",
                  identificacionComprador: "9999999999999",
                  direccionComprador: "Nueva Ambato",
                };
              default:
                return {
                  razonSocialComprador:
                    facturaData.razonSocialComprador || "Desconocido",
                  identificacionComprador:
                    facturaData.identificacionComprador || "0000000000",
                  direccionComprador:
                    facturaData.direccionComprador ||
                    "Dirección no proporcionada",
                };
            }
          };

          // Determinar el tipo de identificación
          const tipoIdentificacion = determinarTipoIdentificacion(
            facturaData.identificacionComprador
          );

          // Obtener los valores basados en el tipo de identificación
          const {
            razonSocialComprador,
            identificacionComprador,
            direccionComprador,
          } = obtenerValoresPorTipo(tipoIdentificacion);

          // Construir el objeto `data`
          var secuencial = facturaData.secuencial.toString().padStart(9, "0");
          var guiaRemision = "001-" + facturaData.pto_emision + "-" + secuencial;
          const data = {
            ambiente: facturaData.ambiente,
            ptoEmi: facturaData.pto_emision,
            tipoIdentificacionComprador: tipoIdentificacion,
            razonSocialComprador,
            guiaRemision,
            identificacionComprador,
            totalSinImpuestos: facturaData.totalSinImpuestos,
            correo: facturaData.correo || "default@uta.edu.ec",
            secuencial: facturaData.secuencial,
            fechaEmision: facturaData.fechaEmision,
            direccionComprador,
            baseImponible: facturaData.baseImponible,
            importeTotal: facturaData.importeTotal,
            detalles: facturaData.detalles,
          };

          console.log("Objeto data construido:", data);

          console.log("Objeto data generado dinámicamente:", data);

          // Generar el XML
          apiURL = `${baseURL}/Junta_Agua/app/controllers/FacturaXMLController.php`;
          const generateResponse = await fetch(
            apiURL,
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
            "https://facturaquas.com/electronic-invoice",
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
            apiURL = `${baseURL}/Junta_Agua/app/api/upadate_Auth_Fac.php?id=${idFactura}`;
            const updateResponse = await fetch(
              apiURL,
              {
                method: "GET",
              }
            );

            const updateResult = await updateResponse.json();
            console.log(
              "Resultado de la actualización de estado:",
              updateResult
            );

            alert(
              `Factura ${idFactura} procesada y actualizada a 'Autorizado'.`
            );
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
        window.location.href = "/Junta_Agua/public/?view=autorizaciones";
      }
    });
});