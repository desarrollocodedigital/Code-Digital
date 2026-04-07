<?php
/**
 * Cargador de Variables de Entorno (.env)
 * Este script lee el archivo .env en la raíz del proyecto y lo carga en $_ENV y putenv().
 */

function loadEnv($path) {
    if (!file_exists($path)) {
        return false;
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        // Ignorar comentarios
        if (strpos(trim($line), '#') === 0) continue;

        // Separar clave y valor
        list($name, $value) = explode('=', $line, 2);
        
        $name = trim($name);
        $value = trim($value);

        // Guardar en el entorno
        if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
            putenv(sprintf('%s=%s', $name, $value));
            $_ENV[$name] = $value;
            $_SERVER[$name] = $value;
        }
    }
    return true;
}

// Cargar automáticamente desde la raíz del proyecto
// __DIR__ es config/, así que subimos un nivel
loadEnv(__DIR__ . '/../.env');
