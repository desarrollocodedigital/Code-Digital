<?php
/**
 * API de Registro de Eventos (Analítica Interna)
 * Registra clics y conversiones de forma asíncrona.
 */
header('Content-Type: application/json');
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

// Obtener datos (Soporta JSON o POST normal)
$inputRaw = file_get_contents('php://input');
$input = json_decode($inputRaw, true);

$type = $input['type'] ?? ($_POST['type'] ?? '');
$page = $input['page'] ?? ($_POST['page'] ?? '');
$metadata = $input['metadata'] ?? ($_POST['metadata'] ?? null);

if (empty($type) || empty($page)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Faltan parámetros obligatorios (type, page)']);
    exit;
}

try {
    if ($type === 'visita') {
        // Lógica de sesiones para visitas únicas
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $sessionId = session_id();
        $hoy = date('Y-m-d');
        $ipHash = hash('sha256', $_SERVER['REMOTE_ADDR']);

        // Verificar si ya existe una visita para esta sesión HOY
        $stmtCheck = $pdo->prepare("SELECT id FROM visitas WHERE session_id = ? AND fecha = ? LIMIT 1");
        $stmtCheck->execute([$sessionId, $hoy]);
        
        if (!$stmtCheck->fetch()) {
            // Registrar nueva visita única
            $stmtInsert = $pdo->prepare("INSERT INTO visitas (session_id, pagina_visitada, ip_hash, fecha) VALUES (?, ?, ?, ?)");
            $stmtInsert->execute([$sessionId, $page, $ipHash, $hoy]);
        }
        
        echo json_encode(['success' => true, 'message' => 'Visita procesada']);
    } else {
        // Registro de eventos normales (clics)
        $stmt = $pdo->prepare("INSERT INTO eventos_tracking (evento_tipo, pagina_origen, metadata) VALUES (?, ?, ?)");
        $stmt->execute([$type, $page, $metadata]);
        echo json_encode(['success' => true, 'message' => 'Evento registrado exitosamente']);
    }
} catch (PDOException $e) {
    // Error silencioso para no afectar la experiencia del usuario, pero se puede loguear internamente
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error de base de datos']);
}
