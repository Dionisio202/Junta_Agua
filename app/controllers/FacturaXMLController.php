<?php

class FacturaXMLController
{
    public function generarXML()
    {
        header("Content-Type: application/json");

        try {
            // Obtener datos de la solicitud
            $data = json_decode(file_get_contents('php://input'), true);

            if (!$data) {
                throw new Exception("No se han recibido datos válidos.");
            }

            // Crear el objeto SimpleXMLElement
            $factura = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><factura></factura>');

            // Agregar atributos al nodo raíz
            $factura->addAttribute('id', 'comprobante');
            $factura->addAttribute('version', '1.1.0');

            // Agregar <infoTributaria>
            $infoTributaria = $factura->addChild('infoTributaria');
            $infoTributaria->addChild('ambiente', $data['ambiente'] ?? '2');
            $infoTributaria->addChild('tipoEmision', $data['tipoEmision'] ?? '1');
            $infoTributaria->addChild('razonSocial', $data['razonSocial'] ?? 'MANOBANDA YUGCHA JOSE FRANCISCO');
            $infoTributaria->addChild('nombreComercial', $data['nombreComercial'] ?? 'JUNTA ADMINISTRADORA DE AGUA POTABLE MIÑARICA SAN VICENTE YACULOMA Y BELLAVISTA EL ROSARIO');
            $infoTributaria->addChild('ruc', $data['ruc'] ?? '1891809449001');
            $infoTributaria->addChild('claveAcceso', $data['claveAcceso'] ?? '');
            $infoTributaria->addChild('codDoc', '01');
            $infoTributaria->addChild('estab', '001');
            $infoTributaria->addChild('ptoEmi', $data['ptoEmi'] ?? '200');
            $infoTributaria->addChild('secuencial', str_pad($data['secuencial'] ?? '8', 9, '0', STR_PAD_LEFT));
            $infoTributaria->addChild('dirMatriz', $data['dirMatriz'] ?? 'Ambato');

            // Agregar <infoFactura>
            $infoFactura = $factura->addChild('infoFactura');
            $infoFactura->addChild('fechaEmision', $data['fechaEmision'] ?? '26/12/2024');
            $infoFactura->addChild('dirEstablecimiento', $data['dirEstablecimiento'] ?? 'Nueva Ambato');
            $infoFactura->addChild('obligadoContabilidad', $data['obligadoContabilidad'] ?? 'NO');
            $infoFactura->addChild('tipoIdentificacionComprador', $data['tipoIdentificacionComprador'] ?? '05');
            $infoFactura->addChild('guiaRemision', $data['guiaRemision'] ?? '000-000-000009999');
            $infoFactura->addChild('razonSocialComprador', $data['razonSocialComprador'] ?? 'Efrain Caina');
            $infoFactura->addChild('identificacionComprador', $data['identificacionComprador'] ?? '1801808112');
            $infoFactura->addChild('direccionComprador', $data['direccionComprador'] ?? 'Ambato');
            $infoFactura->addChild('totalSinImpuestos', number_format($data['totalSinImpuestos'] ?? 20.00, 2, '.', ''));
            $infoFactura->addChild('totalDescuento', number_format($data['totalDescuento'] ?? 0.00, 2, '.', ''));

            // Agregar <totalConImpuestos>
            $totalConImpuestos = $infoFactura->addChild('totalConImpuestos');
            $totalImpuesto = $totalConImpuestos->addChild('totalImpuesto');
            $totalImpuesto->addChild('codigo', '2');
            $totalImpuesto->addChild('codigoPorcentaje', '0');
            $totalImpuesto->addChild('descuentoAdicional', '0.00');
            $totalImpuesto->addChild('baseImponible', number_format($data['baseImponible'] ?? 20.00, 2, '.', ''));
            $totalImpuesto->addChild('valor', '0.00');

            $infoFactura->addChild('importeTotal', number_format($data['importeTotal'] ?? 20.00, 2, '.', ''));
            $infoFactura->addChild('moneda', 'dolar');

            // Agregar <pagos>
            $pagos = $infoFactura->addChild('pagos');
            $pago = $pagos->addChild('pago');
            $pago->addChild('formaPago', $data['formaPago'] ?? '01');
            $pago->addChild('total', number_format($data['importeTotal'] ?? 20.00, 2, '.', ''));

            // Agregar <detalles>
            $detalles = $factura->addChild('detalles');
            foreach ($data['detalles'] ?? [] as $detalle) {
                $detalleNode = $detalles->addChild('detalle');
                $detalleNode->addChild('codigoPrincipal', $detalle['codigoPrincipal'] ?? 'OTR001');
                $detalleNode->addChild('codigoAuxiliar', $detalle['codigoAuxiliar'] ?? 'OTR001');
                $detalleNode->addChild('descripcion', $detalle['descripcion'] ?? 'OTROS');
                $detalleNode->addChild('cantidad', number_format($detalle['cantidad'] ?? 1, 2, '.', ''));
                $detalleNode->addChild('precioUnitario', number_format($detalle['precioUnitario'] ?? 20.00, 2, '.', ''));
                $detalleNode->addChild('descuento', number_format($detalle['descuento'] ?? 0.00, 2, '.', ''));
                $detalleNode->addChild('precioTotalSinImpuesto', number_format($detalle['precioTotalSinImpuesto'] ?? 20.00, 2, '.', ''));

                // Agregar <impuestos>
                $impuestos = $detalleNode->addChild('impuestos');
                $impuesto = $impuestos->addChild('impuesto');
                $impuesto->addChild('codigo', '2');
                $impuesto->addChild('codigoPorcentaje', '0');
                $impuesto->addChild('tarifa', '0.00');
                $impuesto->addChild('baseImponible', number_format($detalle['precioTotalSinImpuesto'] ?? 20.00, 2, '.', ''));
                $impuesto->addChild('valor', '0.00');
            }

            // Agregar <infoAdicional>
            $infoAdicional = $factura->addChild('infoAdicional');
            $campoAdicional = $infoAdicional->addChild('campoAdicional', $data['correo'] ?? '');
            $campoAdicional->addAttribute('nombre', 'emailcliente');

            // Convertir a DOMDocument para aplicar formato indentado
            $dom = dom_import_simplexml($factura)->ownerDocument;
            $dom->formatOutput = true;

            // Guardar el archivo XML
            $filePath = __DIR__ . '/factura.xml';
            $dom->save($filePath);

            // Leer el contenido del archivo generado
            $fileContent = file_get_contents($filePath);

            // Responder con éxito, ruta y contenido
            echo json_encode([
                'success' => true,
                'filePath' => $filePath,
                'fileContent' => base64_encode($fileContent), // Codifica en Base64
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}

// Ejecutar el controlador
$controller = new FacturaXMLController();
$controller->generarXML();
