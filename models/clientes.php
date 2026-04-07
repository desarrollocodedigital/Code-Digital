<?php
/**
 * Adaptador de Datos: Clientes
 * Obtiene la información desde la base de datos MySQL.
 */
include_once __DIR__ . '/../config/db.php';

$clientes = [];

if (isset($pdo)) {
    try {
        $stmt = $pdo->query("SELECT * FROM clientes ORDER BY id ASC");
        while ($row = $stmt->fetch()) {
            $clientes[] = [
                'id' => $row['id'],
                'nombre' => $row['nombre'],
                'icono' => $row['icono'],
                'color' => $row['color']
            ];
        }
    } catch (PDOException $e) {
        // Log error
    }
}
