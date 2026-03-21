<?php
// Configuración de URLs según el entorno
$_isLocal = ($_SERVER['HTTP_HOST'] === 'localhost' || strpos($_SERVER['HTTP_HOST'], '127.0.0.1') !== false);
define('API_URL', getenv('API_URL') ?: ($_isLocal ? 'http://localhost:8000' : 'http://84.247.162.204/facturaD'));
define('APP_URL', getenv('APP_URL') ?: ($_isLocal ? 'http://localhost' : 'http://84.247.162.204'));
