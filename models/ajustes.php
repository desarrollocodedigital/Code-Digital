<?php
/**
 * Modelo: Ajustes
 * Gestiona la configuración global del sitio almacenada en la DB.
 */
include_once __DIR__ . '/../config/db.php';

function getAjustes() {
    global $pdo;
    $ajustes = [];
    try {
        $stmt = $pdo->query("SELECT clave, valor FROM ajustes");
        while ($row = $stmt->fetch()) {
            $ajustes[$row['clave']] = $row['valor'];
        }
    } catch (PDOException $e) {
        // Fallback
    }
    return $ajustes;
}

function updateAjuste($clave, $valor) {
    global $pdo;
    try {
        $stmt = $pdo->prepare("UPDATE ajustes SET valor = ? WHERE clave = ?");
        return $stmt->execute([$valor, $clave]);
    } catch (PDOException $e) {
        return false;
    }
}
?>
