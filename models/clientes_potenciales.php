<?php
/**
 * Modelo de Clientes Potenciales
 * Extrae la información de la base de datos `code_digital_bd`
 */

require_once __DIR__ . '/../config/db.php';

try {
    // Obtener todos los clientes potenciales ordenados por fecha descendente
    $stmt = $pdo->query("SELECT * FROM clientes_potenciales ORDER BY fecha_creacion DESC");
    $clientes_potenciales = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Conteo estadístico de activos (no 'perdido', no 'finalizado')
    $stmtAg = $pdo->query("SELECT COUNT(*) as activos FROM clientes_potenciales WHERE estado IN ('nuevo', 'en proceso')");
    $potenciales_activos = $stmtAg->fetch(PDO::FETCH_ASSOC)['activos'];
    
} catch (PDOException $e) {
    // Fallback: Si no hay base de datos o falla, devolver arrays vacíos para no romper la UI
    $clientes_potenciales = [];
    $potenciales_activos = 0;
    error_log("Error en DB (Clientes Potenciales): " . $e->getMessage());
}
?>
