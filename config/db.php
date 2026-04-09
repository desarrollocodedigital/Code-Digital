<?php
/**
 * Conexión a la Base de Datos Code Digital
 * Utiliza PDO para mayor seguridad y flexibilidad.
 */

require_once __DIR__ . '/env_loader.php';

$host = $_ENV['DB_HOST'] ?? 'localhost';
$db   = $_ENV['DB_NAME'] ?? 'code_digital_bd';
$user = $_ENV['DB_USER'] ?? 'root';
$pass = $_ENV['DB_PASS'] ?? '';
$charset = $_ENV['DB_CHARSET'] ?? 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

// Sincronización de Zona Horaria (México/Mazatlán/CDMX)
date_default_timezone_set('America/Mexico_City');

try {
     $pdo = new PDO($dsn, $user, $pass, $options);
     // Sincronizar la zona horaria de la sesión de la base de datos con PHP
     $pdo->exec("SET time_zone = '-06:00'");
} catch (\PDOException $e) {
     // En producción, esto debería registrarse en un log, no mostrarse al usuario
     // throw new \PDOException($e->getMessage(), (int)$e->getCode());
     $db_error = $e->getMessage();
}
