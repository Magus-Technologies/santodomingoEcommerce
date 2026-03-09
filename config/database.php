<?php
/**
 * Configuración de Base de Datos
 * 
 * IMPORTANTE: Nunca commitear este archivo con credenciales reales a Git
 * Usar variables de entorno en producción
 */

// Detectar ambiente
$isLocal = ($_SERVER['HTTP_HOST'] === 'localhost' || strpos($_SERVER['HTTP_HOST'], '127.0.0.1') !== false);

// Configuración por ambiente
if ($isLocal) {
    // DESARROLLO LOCAL
    define('DB_HOST', 'localhost:33068');
    define('DB_USER', 'root');
    define('DB_PASS', '7616');
    define('DB_NAME', 'compuvision');
    define('DB_CHARSET', 'utf8');
} else {
    // PRODUCCIÓN - Usar variables de entorno
    define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
    define('DB_USER', getenv('DB_USER') ?: 'root');
    define('DB_PASS', getenv('DB_PASS') ?: '');
    define('DB_NAME', getenv('DB_NAME') ?: 'compuvision');
    define('DB_CHARSET', 'utf8');
}

// Validar que las credenciales estén configuradas
if (empty(DB_HOST) || empty(DB_USER) || empty(DB_NAME)) {
    die('Error: Credenciales de base de datos no configuradas correctamente');
}
