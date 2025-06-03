<?php
function generateAccessKey($accessKeyData) {
    $accessKey = "";
    
    // Fecha de emisión en formato DDMMYYYY
    $accessKey .= formatDateToDDMMYYYY($accessKeyData['date']);
    
    // Tipo de comprobante
    $accessKey .= $accessKeyData['codDoc'];
    
    // Número de RUC
    $accessKey .= $accessKeyData['ruc'];
    
    // Tipo de ambiente
    $accessKey .= $accessKeyData['environment'];
    
    // Establecimiento
    $accessKey .= $accessKeyData['establishment'];
    
    // Punto de emisión
    $accessKey .= $accessKeyData['emissionPoint'];
    
    // Secuencial
    $accessKey .= $accessKeyData['sequential'];
    
    // Código numérico aleatorio
    $accessKey .= generateRandomEightDigitNumber();
    
    // Tipo de emisión
    $accessKey .= "1";
    
    // Dígito verificador
    $accessKey .= generateVerificatorDigit($accessKey);
    
    return $accessKey;
}

function formatDateToDDMMYYYY($date) {
    $timestamp = strtotime($date);
    $day = str_pad(date('d', $timestamp), 2, '0', STR_PAD_LEFT);
    $month = str_pad(date('m', $timestamp), 2, '0', STR_PAD_LEFT);
    $year = date('Y', $timestamp);
    return $day . $month . $year;
}

function generateRandomEightDigitNumber() {
    $min = 10000000;
    $max = 99999999;
    return random_int($min, $max);
}

function generateVerificatorDigit($accessKey) {
    $addition = 0;
    $multiple = 7;
    
    for ($i = 0; $i < strlen($accessKey); $i++) {
        $addition += intval($accessKey[$i]) * $multiple;
        $multiple = ($multiple > 2) ? $multiple - 1 : 7;
    }
    
    $remainder = $addition % 11;
    $result = 11 - $remainder;
    
    if ($result == 10) {
        $result = 1;
    } elseif ($result == 11) {
        $result = 0;
    }
    
    return $result;
}

