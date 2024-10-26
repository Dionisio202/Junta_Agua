<?php
// app/models/Factura.php

class Factura {

    public static function getAll() {
        // Conexión a la base de datos y consulta para obtener todas las facturas
        $db = new PDO('mysql:host=localhost;dbname=junta_agua', 'root', '');
        $stmt = $db->query('SELECT * FROM usuario');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}