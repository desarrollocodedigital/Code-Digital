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
    $nombre = $_POST['nombre'] ?? '';
    $celular = $_POST['celular'] ?? '';
    $email = $_POST['email'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $tipo = $_POST['tipo'] ?? 'contacto';
    $proyecto = $_POST['proyecto'] ?? null;

    // Validaciones básicas
    if (empty($nombre) || empty($celular) || empty($email) || empty($descripcion)) {
        throw new Exception('Todos los campos son obligatorios para poder procesar su solicitud.');
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception('El formato de correo electrónico no es válido.');
    }

    // Inserción Blindada con PDO incluyendo los nuevos campos
    $stmt = $pdo->prepare("INSERT INTO mensajes (nombre, celular, email, descripcion, tipo, proyecto, estado) VALUES (?, ?, ?, ?, ?, ?, 'nuevo')");
    $result = $stmt->execute([$nombre, $celular, $email, $descripcion, $tipo, $proyecto]);

    if (!$result) {
        throw new Exception('No se pudo guardar la información en la base de datos.');
    }

    echo json_encode(['success' => true, 'message' => 'Solicitud capturada exitosamente.']);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Error backend: ' . $e->getMessage()]);
}
