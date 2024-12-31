<?php

// Crear el objeto SimpleXMLElement
$factura = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><factura></factura>');

// Agregar atributos al nodo raíz
$factura->addAttribute('id', 'comprobante');
$factura->addAttribute('version', '1.1.0');

// Agregar <infoTributaria>
$infoTributaria = $factura->addChild('infoTributaria');
$infoTributaria->addChild('ambiente', '2');
$infoTributaria->addChild('tipoEmision', '1');
$infoTributaria->addChild('razonSocial', 'MANOBANDA YUGCHA JOSE FRANCISCO');
$infoTributaria->addChild('nombreComercial', 'JUNTA ADMINISTRADORA DE AGUA POTABLE MIÑARICA SAN VICENTE YACULOMA Y BELLAVISTA EL ROSARIO');
$infoTributaria->addChild('ruc', '1891809449001');
$infoTributaria->addChild('claveAcceso', '');
$infoTributaria->addChild('codDoc', '01');
$infoTributaria->addChild('estab', '001');
$infoTributaria->addChild('ptoEmi', '001');
$infoTributaria->addChild('secuencial', '000000005');
$infoTributaria->addChild('dirMatriz', 'Ambato');

// Agregar <infoFactura>
$infoFactura = $factura->addChild('infoFactura');
$infoFactura->addChild('fechaEmision', '26/12/2024');
$infoFactura->addChild('dirEstablecimiento', 'Santa Rosa');
$infoFactura->addChild('obligadoContabilidad', 'NO');
$infoFactura->addChild('tipoIdentificacionComprador', '05');
$infoFactura->addChild('guiaRemision', '001-200-000009999');
$infoFactura->addChild('razonSocialComprador', 'Efrain Caina');
$infoFactura->addChild('identificacionComprador', '1801808112');
$infoFactura->addChild('direccionComprador', 'Ambato');
$infoFactura->addChild('totalSinImpuestos', '20.00');
$infoFactura->addChild('totalDescuento', '0.00');

// Agregar <totalConImpuestos>
$totalConImpuestos = $infoFactura->addChild('totalConImpuestos');
$totalImpuesto = $totalConImpuestos->addChild('totalImpuesto');
$totalImpuesto->addChild('codigo', '2');
$totalImpuesto->addChild('codigoPorcentaje', '0');
$totalImpuesto->addChild('descuentoAdicional', '0.00');
$totalImpuesto->addChild('baseImponible', '20.00');
$totalImpuesto->addChild('valor', '0.00');

$infoFactura->addChild('importeTotal', '20.00');
$infoFactura->addChild('moneda', 'dolar');

// Agregar <pagos>
$pagos = $infoFactura->addChild('pagos');
$pago = $pagos->addChild('pago');
$pago->addChild('formaPago', '01');
$pago->addChild('total', '20.00');

// Agregar <detalles>
$detalles = $factura->addChild('detalles');
$detalle = $detalles->addChild('detalle');
$detalle->addChild('codigoPrincipal', 'OTR001');
$detalle->addChild('codigoAuxiliar', 'OTR001');
$detalle->addChild('descripcion', 'OTROS');
$detalle->addChild('cantidad', '1');
$detalle->addChild('precioUnitario', '20.00');
$detalle->addChild('descuento', '0.00');
$detalle->addChild('precioTotalSinImpuesto', '20.00');

// Agregar <impuestos> dentro de <detalle>
$impuestos = $detalle->addChild('impuestos');
$impuesto = $impuestos->addChild('impuesto');
$impuesto->addChild('codigo', '2');
$impuesto->addChild('codigoPorcentaje', '0');
$impuesto->addChild('tarifa', '0.00');
$impuesto->addChild('baseImponible', '20.00');
$impuesto->addChild('valor', '0');

// Agregar <infoAdicional>
$infoAdicional = $factura->addChild('infoAdicional');
$campoAdicional = $infoAdicional->addChild('campoAdicional', 'kaina02@hotmail.com');
$campoAdicional->addAttribute('nombre', 'emailcliente');

// Convertir a DOMDocument para aplicar formato indentado
$dom = dom_import_simplexml($factura)->ownerDocument;
$dom->formatOutput = true;

// Guardar el XML con formato indentado
$fileName = 'factura.xml';
$dom->save($fileName);

echo "Archivo XML generado: $fileName\n";
