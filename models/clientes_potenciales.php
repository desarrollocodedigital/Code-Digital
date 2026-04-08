<?php
/**
 * Modelo de Clientes Potenciales
 * Extrae la información de la base de datos `code_digital_bd`
 */

require_once __DIR__ . '/../config/db.php';

// --- Lógica de Paginación, Filtros y Búsqueda ---
$cp_items_per_page = 10;
$cp_current_page = isset($_GET['cp_p']) ? max(1, intval($_GET['cp_p'])) : 1;
$cp_filter_status = $_GET['cp_status'] ?? 'all';
$cp_search = $_GET['search'] ?? '';

$cp_where_clauses = [];
$cp_params = [];

if ($cp_filter_status !== 'all') {
    $cp_where_clauses[] = "estado = :estado";
    $cp_params['estado'] = $cp_filter_status;
}

if (!empty($cp_search)) {
    $cp_where_clauses[] = "nombre LIKE :search";
    $cp_params['search'] = "%$cp_search%";
}

$cp_where = !empty($cp_where_clauses) ? "WHERE " . implode(" AND ", $cp_where_clauses) : "";

try {
    // 1. Contar total de registros filtrados para la paginación
    $count_sql = "SELECT COUNT(*) as total FROM clientes_potenciales $cp_where";
    $stmt_total = $pdo->prepare($count_sql);
    $stmt_total->execute($cp_params);
    
    $cp_total_items = $stmt_total->fetch(PDO::FETCH_ASSOC)['total'];
    $cp_total_pages = ceil($cp_total_items / $cp_items_per_page);

    // Ajustar página actual si excede el total
    if ($cp_current_page > $cp_total_pages && $cp_total_pages > 0) $cp_current_page = $cp_total_pages;
    $cp_offset = ($cp_current_page - 1) * $cp_items_per_page;

    // 2. Obtener clientes potenciales paginados
    $sql = "SELECT * FROM clientes_potenciales $cp_where ORDER BY fecha_creacion DESC LIMIT $cp_items_per_page OFFSET $cp_offset";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($cp_params);
    
    $clientes_potenciales = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 3. Conteo estadístico global de activos (independiente del filtro actual)
    $stmtAg = $pdo->query("SELECT COUNT(*) as activos FROM clientes_potenciales WHERE estado IN ('nuevo', 'en proceso')");
    $potenciales_activos = $stmtAg->fetch(PDO::FETCH_ASSOC)['activos'];
    
} catch (PDOException $e) {
    // Fallback: Si no hay base de datos o falla, devolver arrays vacíos para no romper la UI
    $clientes_potenciales = [];
    $potenciales_activos = 0;
    error_log("Error en DB (Clientes Potenciales): " . $e->getMessage());
}
?>
