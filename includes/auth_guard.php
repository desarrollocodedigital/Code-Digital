<?php
/**
 * Guardián de Sesiones
 * Protege las páginas administrativas verificando la identidad del usuario.
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Si no está logueado, lo enviamos al login
    // Detectamos la ruta para asegurar que el redireccionamiento funcione
    $current_path = $_SERVER['PHP_SELF'];
    if (strpos($current_path, 'views/') !== false) {
        header('Location: login.php');
    } else {
        header('Location: views/login.php');
    }
    exit;
}
