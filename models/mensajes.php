<?php
/**
 * Modelo: Mensajes (CRM Contactos)
 */
require_once __DIR__ . '/../config/db.php';

try {
    // Extraer todos los mensajes, los más nuevos primero
    $stmt = $pdo->query("SELECT * FROM mensajes ORDER BY fecha_creacion DESC");
    $mensajes = $stmt->fetchAll();

    // Contar cuantos son nuevos para el badge
    $stmt_count = $pdo->query("SELECT COUNT(*) as unread FROM mensajes WHERE estado = 'nuevo'");
    $unread_count = $stmt_count->fetch()['unread'];

} catch (PDOException $e) {
    die("Error al conectar a la base de datos (Mensajes): " . $e->getMessage());
}
