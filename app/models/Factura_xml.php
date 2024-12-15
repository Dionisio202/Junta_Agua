<?php
$factura = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><factura id="comprobante" version="1.1.0"></factura>');

$infoTributaria = $factura->addChild('infoTributaria');

$infoTributaria->addChild('ambiente', '1');
$infoTributaria->addChild('tipoEmision', '1');
$infoTributaria->addChild('razonSocial', 'MANOBANDA YUGCHA JOSE FRANCISCO');
$infoTributaria->addChild('nombreComercial', 'JUNTA ADMINISTRADORA DE AGUA POTABLE MIÑARICA SAN VICENTE YACULOMA Y BELLAVISTA EL ROSARIO');
$infoTributaria->addChild('ruc', '1891809449001');
$infoTributaria->addChild('claveAcceso', '');
$infoTributaria->addChild('codDoc', '01');
$infoTributaria->addChild('estab', '001');
$infoTributaria->addChild('ptoEmi', '002');
$infoTributaria->addChild('secuencial', '000000998');
$infoTributaria->addChild('dirMatriz', 'Ambato');


$infoFactura = $factura->addChild('infoFactura');

$infoFactura->addChild('fechaEmision', '14/12/2024');
$infoFactura->addChild('dirEstablecimiento', 'Nueva Ambato');
$infoFactura->addChild('obligadoContabilidad', 'NO');
$infoFactura->addChild('tipoIdentificacionComprador', '05');
$infoFactura->addChild('guiaRemision', '000-000-000009999');
$infoFactura->addChild('razonSocialComprador', 'Mateo Diaz');
$infoFactura->addChild('identificacionComprador', '0150972644');
$infoFactura->addChild('direccionComprador', 'Ambato');
$infoFactura->addChild('totalSinImpuestos', '50.00');
$infoFactura->addChild('totalDescuento', '0.00');

$totalConImpuestos = $infoFactura->addChild('totalConImpuestos');

$totalImpuesto = $totalConImpuestos->addChild('totalImpuesto');
$totalImpuesto->addChild('codigo', '2');
$totalImpuesto->addChild('codigoPorcentaje', '4');
$totalImpuesto->addChild('descuentoAdicional', '0.00');
$totalImpuesto->addChild('baseImponible', '50.00');
$totalImpuesto->addChild('valor', '7.50');

$infoFactura->addChild('importeTotal', '57.50');
$infoFactura->addChild('moneda', 'dolar');

$pagos = $infoFactura->addChild('pagos');

$pago = $pagos->addChild('pago');
$pago->addChild('formaPago', '01');
$pago->addChild('total', '57.50');

$detalles = $factura->addChild('detalles');

$detalle = $detalles->addChild('detalle');
$detalle->addChild('codigoPrincipal', 'COD001');
$detalle->addChild('codigoAuxiliar', 'SEX001');
$detalle->addChild('descripcion', 'Mes de agua');
$detalle->addChild('cantidad', '1');
$detalle->addChild('precioUnitario', '50.000000');
$detalle->addChild('descuento', '0.00');
$detalle->addChild('precioTotalSinImpuesto', '50.00');

$impuestos = $detalle->addChild('impuestos');

$impuesto = $impuestos->addChild('impuesto');
$impuesto->addChild('codigo', '2');
$impuesto->addChild('codigoPorcentaje', '4');
$impuesto->addChild('tarifa', '15.0');
$impuesto->addChild('baseImponible', '50.00');
$impuesto->addChild('valor', '7.50');

$fileName = 'factura.xml';
$factura->asXML($fileName);
echo "Archivo XML generado: $fileName\n";
