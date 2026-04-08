<?php
/**
 * API: Auth Handler
 * Gestiona el inicio y cierre de sesión de usuarios administrativos.
 */
session_start();
require_once __DIR__ . '/../config/db.php';

header('Content-Type: application/json');

$action = $_GET['action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'login') {
    $usuarioInput = $_POST['usuario'] ?? '';
    $passwordInput = $_POST['password'] ?? '';

    if (empty($usuarioInput) || empty($passwordInput)) {
        echo json_encode(['success' => false, 'message' => 'Por favor complete todos los campos.']);
        exit;
    }

    try {
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = ?");
        $stmt->execute([$usuarioInput]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($passwordInput, $user['password'])) {
            // Login exitoso
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['usuario'] = $user['usuario'];
            $_SESSION['logged_in'] = true;
            
            echo json_encode(['success' => true, 'message' => 'Acceso concedido. Redireccionando...']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Usuario o contraseña incorrectos.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error de conexión: ' . $e->getMessage()]);
    }
    exit;
}

if ($action === 'logout') {
    session_unset();
    session_destroy();
    header('Location: ../views/login.php');
    exit;
}

echo json_encode(['success' => false, 'message' => 'Acción no permitida.']);
