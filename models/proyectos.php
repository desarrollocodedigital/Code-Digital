<?php
/**
 * Adaptador de Datos: Proyectos
 * Obtiene la información desde la base de datos MySQL.
 */
include_once __DIR__ . '/../config/db.php';

$proyectos = [];

if (isset($pdo)) {
    // --- Lógica de Paginación y Búsqueda ---
    $p_items_per_page = 10;
    $p_current_page = isset($_GET['p_p']) ? max(1, intval($_GET['p_p'])) : 1;
    $p_search = $_GET['p_search'] ?? '';

    $p_where_clauses = [];
    $p_params = [];

    if (!empty($p_search)) {
        $p_where_clauses[] = "nombre LIKE :search";
        $p_params['search'] = "%$p_search%";
    }

    $p_where = !empty($p_where_clauses) ? "WHERE " . implode(" AND ", $p_where_clauses) : "";

    try {
        // 1. Contar total de registros filtrados
        $stmtTotal = $pdo->prepare("SELECT COUNT(*) as total FROM proyectos $p_where");
        $stmtTotal->execute($p_params);
        $p_total_items = $stmtTotal->fetch(PDO::FETCH_ASSOC)['total'];
        $p_total_pages = ceil($p_total_items / $p_items_per_page);

        // Ajustar página actual
        if ($p_current_page > $p_total_pages && $p_total_pages > 0) $p_current_page = $p_total_pages;
        $p_offset = ($p_current_page - 1) * $p_items_per_page;

        // 2. Obtener registros paginados
        $sql = "SELECT * FROM proyectos $p_where ORDER BY id ASC LIMIT $p_items_per_page OFFSET $p_offset";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($p_params);
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $proyectos[] = [
                'db_id' => $row['id'],
                'id' => $row['slug'],
                'nombre' => $row['nombre'],
                'inicial_logo' => $row['inicial_logo'],
                'tagline' => $row['tagline'],
                'descripcion' => $row['descripcion'],
                'imagen_url' => $row['imagen_url'],
                'color' => $row['color'],
                'icono_estado' => $row['icono_estado'],
                'texto_estado' => $row['texto_estado'],
                'subtexto_estado' => $row['subtexto_estado'],
                'estadisticas' => [
                    ['valor' => $row['stat1_valor'], 'etiqueta' => $row['stat1_etiqueta']],
                    ['valor' => $row['stat2_valor'], 'etiqueta' => $row['stat2_etiqueta']],
                    ['valor' => $row['stat3_valor'], 'etiqueta' => $row['stat3_etiqueta']]
                ],
                'tecnologias' => array_map('trim', explode(',', $row['tecnologias'])),
                'problema' => $row['problema'] ?? '',
                'funcionalidades' => $row['funcionalidades'] ?? '',
                'galeria' => [] // Se llenará a continuación
            ];
            
            // Obtener galería de imágenes si existe
            $stmtGaleria = $pdo->prepare("SELECT imagen_url FROM proyecto_imagenes WHERE proyecto_id = ? ORDER BY orden ASC");
            $stmtGaleria->execute([$row['id']]);
            $galeria = $stmtGaleria->fetchAll(PDO::FETCH_COLUMN);
            $proyectos[count($proyectos) - 1]['galeria'] = $galeria;
        }
    } catch (PDOException $e) {
        // En caso de error, podríamos cargar un log o un fallback
    }
}
