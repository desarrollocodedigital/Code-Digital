<?php
/**
 * Conexión a la Base de Datos Code Digital
 * Utiliza PDO para mayor seguridad y flexibilidad.
 */

$host = 'localhost';
$db   = 'code_digital_bd';
$user = 'root'; // Usuario por defecto en XAMPP
$pass = '';     // Contraseña por defecto en XAMPP (vacía)
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     // En producción, esto debería registrarse en un log, no mostrarse al usuario
     // throw new \PDOException($e->getMessage(), (int)$e->getCode());
     $db_error = $e->getMessage();
}
