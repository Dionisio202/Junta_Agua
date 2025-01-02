   document.addEventListener("DOMContentLoaded", () => {
    const loading = document.getElementById("loading");
    loading.style.display = "none";

    document.getElementById("autorizar-btn").addEventListener("click", async () => {
        console.log("Botón presionado, mostrando loading...");
        loading.style.display = "flex";

        const detalles = [
            {
                codigoAuxiliar: "OTR001",
                descripcion: "OTROS",
                cantidad: 1,
                precioUnitario: 20.00,
                precioTotalSinImpuesto: 20.00,
                baseImponible: 20,
            },
        ];

        const data = {
            ambiente: 1,
            razonSocialComprador: "Efrain Caina",
            identificacionComprador: "1801808112",
            totalSinImpuestos: 20,
            correo: "solisedison@outlook.com",
            secuencial: "17",
            fechaEmision: "26/12/2024",
            direccionComprador: "Ambato",
            baseImponible: 20,
            importeTotal: 20,
            detalles: detalles,
        };

        try {
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
                throw new Error("Error al generar el XML: " + generateResult.message);
            }

            // Decodificar el contenido del archivo
            const fileContent = atob(generateResult.fileContent);

            // Crear FormData con el archivo real
            const formData = new FormData();
            formData.append("invoice", new Blob([fileContent], { type: "application/xml" }), "factura.xml");

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
                alert("Factura procesada exitosamente: " + sendResult.message);
            } else {
                throw new Error("Error al enviar la factura. Código: " + sendResponse.status);
            }
        } catch (error) {
            console.error("Error:", error);
            alert(error.message);
        } finally {
            loading.style.display = "none"; // Ocultar el loading
        }
    });
});




