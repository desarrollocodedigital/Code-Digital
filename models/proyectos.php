<?php
/**
 * Adaptador de Datos: Proyectos
 * Obtiene la información desde la base de datos MySQL.
 */
include_once __DIR__ . '/../config/db.php';

$proyectos = [];

if (isset($pdo)) {
    try {
        $stmt = $pdo->query("SELECT * FROM proyectos ORDER BY id ASC");
        while ($row = $stmt->fetch()) {
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
                'tecnologias' => array_map('trim', explode(',', $row['tecnologias']))
            ];
        }
    } catch (PDOException $e) {
        // En caso de error, podríamos cargar un log o un fallback
    }
}
