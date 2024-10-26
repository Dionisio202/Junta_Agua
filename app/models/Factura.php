<?php
// app/models/Factura.php

class Factura {
    public static function getAll() {
        // Conexión a la base de datos y consulta para obtener todas las facturas
        $db = new PDO('mysql:host=localhost;dbname=junta_agua', 'user', 'password');
        $stmt = $db->query('SELECT * FROM facturas');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        // Conexión y consulta para crear una nueva factura
        $db = new PDO('mysql:host=localhost;dbname=junta_agua', 'user', 'password');
        $stmt = $db->prepare('INSERT INTO facturas (nombre, cedula, telefono, detalle) VALUES (?, ?, ?, ?)');
        $stmt->execute([$data['nombre'], $data['cedula'], $data['telefono'], $data['detalle']]);
    }

    public static function delete($id) {
        // Conexión y consulta para eliminar una factura
        $db = new PDO('mysql:host=localhost;dbname=junta_agua', 'user', 'password');
        $stmt = $db->prepare('DELETE FROM facturas WHERE id = ?');
        $stmt->execute([$id]);
    }
}