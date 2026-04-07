<?php
/**
 * Configuración SMTP para PHPMailer
 */
require_once __DIR__ . '/env_loader.php';

return [
    'host' => $_ENV['SMTP_HOST'] ?? 'smtp.gmail.com',
    'auth' => filter_var($_ENV['SMTP_AUTH'] ?? true, FILTER_VALIDATE_BOOLEAN),
    'username' => $_ENV['SMTP_USER'] ?? '',
    'password' => $_ENV['SMTP_PASS'] ?? '',
    'secure' => $_ENV['SMTP_SECURE'] ?? 'tls',
    'port' => (int)($_ENV['SMTP_PORT'] ?? 587),
    'from_email' => $_ENV['SMTP_FROM_EMAIL'] ?? '',
    'from_name' => $_ENV['SMTP_FROM_NAME'] ?? 'Code Digital'
];