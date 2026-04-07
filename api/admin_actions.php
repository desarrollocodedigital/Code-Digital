<?php
/**
 * Admin Actions Handler
 * Procesa peticiones CRUD para Proyectos y Clientes
 */

header('Content-Type: application/json');
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

$action = $_POST['action'] ?? '';

try {
    switch ($action) {
        case 'save_project':
            saveProject($pdo);
            break;
        case 'delete_project':
            deleteProject($pdo);
            break;
        case 'save_client':
            saveClient($pdo);
            break;
        case 'delete_client':
            deleteClient($pdo);
            break;
        case 'read_message':
            readMessage($pdo);
            break;
        case 'delete_message':
            deleteMessage($pdo);
            break;
        default:
            echo json_encode(['success' => false, 'message' => 'Acción no válida: ' . $action]);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}

/**
 * Guarda o actualiza un proyecto
 */
function saveProject($pdo) {
    $id = $_POST['id'] ?? null; // ID de la DB (INT) o NULL si es nuevo
    $slug = $_POST['slug'] ?? '';
    if (empty($slug)) $slug = strtolower(str_replace(' ', '-', $_POST['nombre']));

    // Manejo de Subida de Imagen
    $imagen_url = $_POST['current_image'] ?? '';
    if (isset($_FILES['imagen_archivo']) && $_FILES['imagen_archivo']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['imagen_archivo'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed = ['png', 'jpg', 'jpeg'];
        
        if (in_array($ext, $allowed)) {
            $newName = 'project_' . ($id ? $id : 'new') . '_' . time() . '.' . $ext;
            $targetPath = __DIR__ . '/../assets/img/proyectos/' . $newName;
            if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                // Eliminar la imagen anterior físicamente del servidor si existe y es reemplazada
                if (!empty($imagen_url) && file_exists(__DIR__ . '/../' . $imagen_url)) {
                    unlink(__DIR__ . '/../' . $imagen_url);
                }
                
                $imagen_url = 'assets/img/proyectos/' . $newName;
            }
        } else {
            throw new Exception("Formato de imagen no permitido (.png, .jpg, .jpeg únicamente)");
        }
    }

    $data = [
        'slug' => $slug,
        'nombre' => $_POST['nombre'] ?? '',
        'inicial_logo' => $_POST['inicial_logo'] ?? '',
        'tagline' => $_POST['tagline'] ?? '',
        'descripcion' => $_POST['descripcion'] ?? '',
        'imagen_url' => $imagen_url,
        'color' => $_POST['color'] ?? 'cian',
        'icono_estado' => $_POST['icono_estado'] ?? '',
        'texto_estado' => $_POST['texto_estado'] ?? 'En Desarrollo',
        'subtexto_estado' => $_POST['subtexto_estado'] ?? 'Software',
        'stat1_valor' => $_POST['stat1_valor'] ?? '',
        'stat1_etiqueta' => $_POST['stat1_etiqueta'] ?? '',
        'stat2_valor' => $_POST['stat2_valor'] ?? '',
        'stat2_etiqueta' => $_POST['stat2_etiqueta'] ?? '',
        'stat3_valor' => $_POST['stat3_valor'] ?? '',
        'stat3_etiqueta' => $_POST['stat3_etiqueta'] ?? '',
        'tecnologias' => $_POST['tecnologias'] ?? ''
    ];

    if ($id) {
        // UPDATE
        $sql = "UPDATE proyectos SET 
                slug = :slug, nombre = :nombre, inicial_logo = :inicial_logo, tagline = :tagline, 
                descripcion = :descripcion, imagen_url = :imagen_url, color = :color, 
                icono_estado = :icono_estado, texto_estado = :texto_estado, subtexto_estado = :subtexto_estado, 
                stat1_valor = :stat1_valor, stat1_etiqueta = :stat1_etiqueta, 
                stat2_valor = :stat2_valor, stat2_etiqueta = :stat2_etiqueta, 
                stat3_valor = :stat3_valor, stat3_etiqueta = :stat3_etiqueta, 
                tecnologias = :tecnologias 
                WHERE id = :id";
        $data['id'] = $id;
    } else {
        // INSERT
        $sql = "INSERT INTO proyectos 
                (slug, nombre, inicial_logo, tagline, descripcion, imagen_url, color, icono_estado, texto_estado, subtexto_estado, stat1_valor, stat1_etiqueta, stat2_valor, stat2_etiqueta, stat3_valor, stat3_etiqueta, tecnologias) 
                VALUES 
                (:slug, :nombre, :inicial_logo, :tagline, :descripcion, :imagen_url, :color, :icono_estado, :texto_estado, :subtexto_estado, :stat1_valor, :stat1_etiqueta, :stat2_valor, :stat2_etiqueta, :stat3_valor, :stat3_etiqueta, :tecnologias)";
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($data);
    echo json_encode(['success' => true, 'message' => 'Proyecto guardado correctamente']);
}

/**
 * Elimina un proyecto
 */
function deleteProject($pdo) {
    $id = $_POST['id'] ?? null;
    if (!$id) throw new Exception("ID no proporcionado");
    
    // Obtener la URL de la imagen actual antes de eliminar el registro
    $stmt = $pdo->prepare("SELECT imagen_url FROM proyectos WHERE id = ?");
    $stmt->execute([$id]);
    $project = $stmt->fetch();

    if ($project && !empty($project['imagen_url'])) {
        $imgPath = __DIR__ . '/../' . $project['imagen_url'];
        if (file_exists($imgPath)) {
            unlink($imgPath);
        }
    }
    
    $stmt = $pdo->prepare("DELETE FROM proyectos WHERE id = ?");
    $stmt->execute([$id]);
    echo json_encode(['success' => true, 'message' => 'Proyecto eliminado']);
}

/**
 * Guarda o actualiza un cliente
 */
function saveClient($pdo) {
    $id = $_POST['id'] ?? null;
    $data = [
        'nombre' => $_POST['nombre'] ?? '',
        'icono' => $_POST['icono'] ?? 'zap',
        'color' => 'brand-cyan' // Valor por defecto ya que no se pide en form
    ];

    if ($id) {
        $sql = "UPDATE clientes SET nombre = :nombre, icono = :icono, color = :color WHERE id = :id";
        $data['id'] = $id;
    } else {
        $sql = "INSERT INTO clientes (nombre, icono, color) VALUES (:nombre, :icono, :color)";
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($data);
    echo json_encode(['success' => true, 'message' => 'Cliente guardado correctamente']);
}

/**
 * Elimina un cliente
 */
function deleteClient($pdo) {
    $id = $_POST['id'] ?? null;
    if (!$id) throw new Exception("ID no proporcionado");
    
    $stmt = $pdo->prepare("DELETE FROM clientes WHERE id = ?");
    $stmt->execute([$id]);
    echo json_encode(['success' => true, 'message' => 'Cliente eliminado']);
}

/**
 * Marca un mensaje como leído en el CRM
 */
function readMessage($pdo) {
    $id = $_POST['id'] ?? null;
    if (!$id) throw new Exception("ID no proporcionado");
    
    $stmt = $pdo->prepare("UPDATE mensajes SET estado = 'leido', fecha_lectura = NOW() WHERE id = ?");
    $stmt->execute([$id]);
    echo json_encode(['success' => true, 'message' => 'Mensaje marcado como leído']);
}

/**
 * Elimina un mensaje del CRM permanentemente
 */
function deleteMessage($pdo) {
    $id = $_POST['id'] ?? null;
    if (!$id) throw new Exception("ID no proporcionado");
    
    $stmt = $pdo->prepare("DELETE FROM mensajes WHERE id = ?");
    $stmt->execute([$id]);
    echo json_encode(['success' => true, 'message' => 'Mensaje eliminado permanentemente']);
}
