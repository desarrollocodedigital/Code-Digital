<?php
/**
 * API Backend: Handler de Formulario de Contacto Frontend
 * 
 * Este archivo está aislado del panel de control de proyectos para evitar
 * brechas de seguridad. Solo permite inyecciones a la tabla 'mensajes'.
 */

header('Content-Type: application/json');
require_once __DIR__ . '/../config/db.php';

// Verificación de método POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

try {
    $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING) ?? '';
    $celular = filter_input(INPUT_POST, 'celular', FILTER_SANITIZE_STRING) ?? '';
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL) ?? '';
    $descripcion = filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_STRING) ?? '';

    // Validaciones básicas
    if (empty($nombre) || empty($celular) || empty($email) || empty($descripcion)) {
        throw new Exception('Todos los campos son obligatorios para poder conectar.');
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception('El formato de correo electrónico no es válido.');
    }

    // Inserción Blindada con PDO
    $stmt = $pdo->prepare("INSERT INTO mensajes (nombre, celular, email, descripcion, estado) VALUES (?, ?, ?, ?, 'nuevo')");
    $stmt->execute([$nombre, $celular, $email, $descripcion]);

    // Opcional: Podrías integrar envío de Email (mail() o PHPMailer) aquí
    // mail("tu@correo.com", "Nuevo Lead: $nombre", "El usuario dejó este mensaje: $descripcion");

    echo json_encode(['success' => true, 'message' => 'Mensaje capturado exitosamente. Nuestro equipo te contactará en breve.']);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
