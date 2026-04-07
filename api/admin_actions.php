<?php
// Importar PHPMailer para el envío de plantillas
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../libs/PHPMailer/Exception.php';
require_once __DIR__ . '/../libs/PHPMailer/PHPMailer.php';
require_once __DIR__ . '/../libs/PHPMailer/SMTP.php';

require_once __DIR__ . '/../config/db.php';

header('Content-Type: application/json');

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
        case 'save_potential_client':
            savePotentialClient($pdo);
            break;
        case 'delete_potential_client':
            deletePotentialClient($pdo);
            break;
        case 'mark_creds_sent':
            markCredsSent($pdo);
            break;
        case 'convert_message_to_lead':
            convertMessageToLead($pdo);
            break;
        case 'update_ajuste':
            updateAjusteAction($pdo);
            break;
        case 'save_template':
            saveTemplate($pdo);
            break;
        case 'delete_template':
            deleteTemplate($pdo);
            break;
        case 'send_template_email':
            sendTemplateEmail($pdo);
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

/**
 * Guarda o actualiza un cliente potencial
 */
function savePotentialClient($pdo) {
    $id = $_POST['id'] ?? null;
    $data = [
        'nombre' => $_POST['nombre'] ?? '',
        'email' => $_POST['email'] ?? '',
        'telefono' => $_POST['telefono'] ?? '',
        'empresa_cargo' => !empty($_POST['empresa_cargo']) ? $_POST['empresa_cargo'] : null,
        'descripcion' => $_POST['descripcion'] ?? '',
        'estado' => $_POST['estado'] ?? 'nuevo'
    ];

    if ($id) {
        $sql = "UPDATE clientes_potenciales SET nombre = :nombre, email = :email, telefono = :telefono, empresa_cargo = :empresa_cargo, descripcion = :descripcion, estado = :estado WHERE id = :id";
        $data['id'] = $id;
    } else {
        $sql = "INSERT INTO clientes_potenciales (nombre, email, telefono, empresa_cargo, descripcion, estado) VALUES (:nombre, :email, :telefono, :empresa_cargo, :descripcion, :estado)";
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($data);
    echo json_encode(['success' => true, 'message' => 'Cliente potencial guardado correctamente']);
}

/**
 * Elimina un cliente potencial
 */
function deletePotentialClient($pdo) {
    $id = $_POST['id'] ?? null;
    if (!$id) throw new Exception("ID no proporcionado");
    
    $stmt = $pdo->prepare("DELETE FROM clientes_potenciales WHERE id = ?");
    $stmt->execute([$id]);
    echo json_encode(['success' => true, 'message' => 'Cliente potencial eliminado']);
}

/**
 * Marca que se enviaron las credenciales de un mensaje DEMO
 */
function markCredsSent($pdo) {
    $id = $_POST['id'] ?? null;
    if (!$id) throw new Exception("ID no proporcionado");
    
    $stmt = $pdo->prepare("UPDATE mensajes SET creds_sent = 1 WHERE id = ?");
    $stmt->execute([$id]);
    echo json_encode(['success' => true, 'message' => 'Credenciales marcadas como enviadas']);
}

/**
 * Convierte un mensaje de CONTACTO a un Cliente Potencial
 */
function convertMessageToLead($pdo) {
    $id = $_POST['id'] ?? null;
    if (!$id) throw new Exception("ID del mensaje no proporcionado");

    // 1. Obtener mensaje
    $stmt = $pdo->prepare("SELECT * FROM mensajes WHERE id = ?");
    $stmt->execute([$id]);
    $msg = $stmt->fetch();

    if (!$msg) throw new Exception("Mensaje no encontrado");
    if (!empty($msg['lead_id'])) throw new Exception("Este mensaje ya fue convertido en lead");

    // 2. Insertar como lead
    $origenPrefix = ($msg['tipo'] === 'plantilla') ? "Origen: Correo electrónico" : "Origen: Formulario de Contacto";
    
    $sqlInsert = "INSERT INTO clientes_potenciales (nombre, email, telefono, descripcion, estado) VALUES (:nombre, :email, :telefono, :descripcion, 'nuevo')";
    $stmtInsert = $pdo->prepare($sqlInsert);
    $stmtInsert->execute([
        'nombre' => $msg['nombre'],
        'email' => $msg['email'],
        'telefono' => $msg['celular'],
        'descripcion' => $origenPrefix . "\n\n" . $msg['descripcion']
    ]);
    
    $leadId = $pdo->lastInsertId();

    // 3. Marcar mensaje con el lead_id e idealmente como leído
    $sqlUpdate = "UPDATE mensajes SET lead_id = ?, estado = 'leido', fecha_lectura = NOW() WHERE id = ?";
    $stmtUpdate = $pdo->prepare($sqlUpdate);
    $stmtUpdate->execute([$leadId, $id]);

    echo json_encode(['success' => true, 'message' => 'Mensaje convertido a cliente potencial exitosamente', 'lead_id' => $leadId]);
}

/**
 * Actualiza una configuración global en la tabla ajustes
 */
function updateAjusteAction($pdo) {
    if (!isset($_POST['clave']) || !isset($_POST['valor'])) {
        throw new Exception("Faltan parámetros");
    }
    
    $clave = $_POST['clave'];
    $valor = $_POST['valor'];
    
    $stmt = $pdo->prepare("UPDATE ajustes SET valor = ? WHERE clave = ?");
    $stmt->execute([$valor, $clave]);
    
    echo json_encode(['success' => true, 'message' => 'Configuración actualizada']);
}

/**
 * Guarda o actualiza una plantilla de correo
 */
function saveTemplate($pdo) {
    $id = $_POST['id'] ?? null;
    $data = [
        'titulo' => $_POST['titulo'] ?? '',
        'asunto' => $_POST['asunto'] ?? '',
        'cuerpo' => $_POST['cuerpo'] ?? ''
    ];

    if ($id) {
        $sql = "UPDATE plantillas_email SET titulo = :titulo, asunto = :asunto, cuerpo = :cuerpo WHERE id = :id";
        $data['id'] = $id;
    } else {
        $sql = "INSERT INTO plantillas_email (titulo, asunto, cuerpo) VALUES (:titulo, :asunto, :cuerpo)";
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($data);
    echo json_encode(['success' => true, 'message' => 'Plantilla guardada correctamente']);
}

/**
 * Elimina una plantilla
 */
function deleteTemplate($pdo) {
    $id = $_POST['id'] ?? null;
    if (!$id) throw new Exception("ID no proporcionado");
    
    $stmt = $pdo->prepare("DELETE FROM plantillas_email WHERE id = ?");
    $stmt->execute([$id]);
    echo json_encode(['success' => true, 'message' => 'Plantilla eliminada']);
}

/**
 * Envía un correo basado en una plantilla y lo registra en el CRM
 */
function sendTemplateEmail($pdo) {
    $email_destinatario = $_POST['email'] ?? '';
    $template_id = $_POST['template_id'] ?? '';
    $mensaje_libre = $_POST['mensaje_libre'] ?? '';
    
    if (empty($email_destinatario)) throw new Exception("Email de destinatario obligatorio");
    if (empty($template_id)) throw new Exception("Debes seleccionar una plantilla");

    // 1. Obtener Plantilla
    $stmt = $pdo->prepare("SELECT * FROM plantillas_email WHERE id = ?");
    $stmt->execute([$template_id]);
    $template = $stmt->fetch();
    if (!$template) throw new Exception("Plantilla no encontrada");

    // 2. Procesar Variables y Mensaje Libre
    // Buscamos el nombre del cliente basado en el email
    $stmtClient = $pdo->prepare("SELECT nombre FROM clientes_potenciales WHERE email = ? LIMIT 1");
    $stmtClient->execute([$email_destinatario]);
    $client = $stmtClient->fetch();

    if (!$client) {
        $stmtClient = $pdo->prepare("SELECT nombre FROM mensajes WHERE email = ? LIMIT 1");
        $stmtClient->execute([$email_destinatario]);
        $client = $stmtClient->fetch();
    }
    
    $nombre_cliente = $client ? $client['nombre'] : 'Cliente';

    $cuerpo_final = str_replace('{{nombre}}', $nombre_cliente, $template['cuerpo']);
    $cuerpo_final = str_replace('[[CONTENIDO_LIBRE]]', $mensaje_libre, $cuerpo_final);

    // 3. Envío vía PHPMailer
    $mailConfig = require __DIR__ . '/../config/mail.php';
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = $mailConfig['host'];
        $mail->SMTPAuth   = $mailConfig['auth'];
        $mail->Username   = $mailConfig['username'];
        $mail->Password   = $mailConfig['password'];
        $mail->SMTPSecure = $mailConfig['secure'];
        $mail->Port       = $mailConfig['port'];
        $mail->CharSet    = 'UTF-8';

        $mail->setFrom($mailConfig['from_email'], $mailConfig['from_name']);
        $mail->addAddress($email_destinatario);

        $mail->isHTML(true);
        $mail->Subject = $template['asunto'];
        
        // Sincronizar estilos con el visualizador del dashboard
        $baseStyles = "
            <style>
                body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 20px; }
                .email-container { white-space: pre-wrap; }
            </style>
        ";
        $mail->Body = $baseStyles . "<div class='email-container'>" . $cuerpo_final . "</div>";

        $mail->send();

        // 4. Registrar en la tabla mensajes como comunicación SALIENTE
        $statusMsg = "Propuesta enviada — esperando confirmación del cliente";
        $stmtLog = $pdo->prepare("INSERT INTO mensajes (nombre, email, descripcion, tipo, estado) VALUES (?, ?, ?, 'plantilla', 'leido')");
        $stmtLog->execute([$nombre_cliente, $email_destinatario, $statusMsg]);

        echo json_encode(['success' => true, 'message' => 'Correo enviado exitosamente y registrado en el CRM']);
    } catch (Exception $e) {
        throw new Exception("Error al enviar el correo: {$mail->ErrorInfo}");
    }
}
?>
