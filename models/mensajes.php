<?php
/**
 * Modelo: Mensajes (CRM Contactos)
 */
require_once __DIR__ . '/../config/db.php';

// --- Lógica de Paginación y Filtros ---
$items_per_page = 10;
$current_page = isset($_GET['p']) ? max(1, intval($_GET['p'])) : 1;
$filter_status = $_GET['status'] ?? 'all';

$where_clause = "";
$params = [];

if ($filter_status === 'nuevo') {
    $where_clause = "WHERE estado = 'nuevo'";
} elseif ($filter_status === 'leido') {
    $where_clause = "WHERE estado = 'leido'";
}

try {
    // 1. Contar total de registros para la paginación (bajo el filtro actual)
    $count_sql = "SELECT COUNT(*) as total FROM mensajes $where_clause";
    if (!empty($params)) {
        $stmt_total = $pdo->prepare($count_sql);
        $stmt_total->execute($params);
    } else {
        $stmt_total = $pdo->query($count_sql);
    }
    $total_items = $stmt_total->fetch()['total'];
    $total_pages = ceil($total_items / $items_per_page);
    
    // Ajustar página actual si excede el total
    if ($current_page > $total_pages && $total_pages > 0) $current_page = $total_pages;
    $offset = ($current_page - 1) * $items_per_page;

    // 2. Extraer mensajes paginados
    $sql = "SELECT * FROM mensajes $where_clause ORDER BY fecha_creacion DESC LIMIT $items_per_page OFFSET $offset";
    $stmt = $pdo->query($sql);
    $mensajes = $stmt->fetchAll();

    // 3. Contar cuantos son nuevos para el badge (siempre total global)
    $stmt_count = $pdo->query("SELECT COUNT(*) as unread FROM mensajes WHERE estado = 'nuevo'");
    $unread_count = $stmt_count->fetch()['unread'];

} catch (PDOException $e) {
    die("Error al conectar a la base de datos (Mensajes): " . $e->getMessage());
}
