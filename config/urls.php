<?php
/**
 * Configuración centralizada de URLs para el proyecto
 * Cambiar aquí para pasar de producción a local
 */

// Detectar si estamos en local o producción
$isLocal = ($_SERVER['HTTP_HOST'] === 'localhost' || strpos($_SERVER['HTTP_HOST'], '127.0.0.1') !== false);

// URLs base
define('BASE_URL', $isLocal ? 'http://localhost/public_html' : 'https://viñasantodomingo.com/public_html');
define('CYM_URL', BASE_URL . '/CYM');

// APIs externas (estas pueden necesitar configuración según el ambiente)
// Para desarrollo local, comentar o usar endpoints locales si están disponibles
define('API_DNI_URL', 'http://magustechnologies.com:9091/consulta/dni2/');
define('API_RUC_URL', 'https://magustechnologies.com/api/consulta/ruc/');
define('API_MARCAS_URL', 'http://computer.brunoas.com/marcas.php');

// URLs de facturación
define('API_FACTURA_URL', 'https://magustechnologies.com/factura_santodomingo/datosrec.php');

// API pública de facturacion_santoDomingo (Laravel)
// En local usa: php artisan serve (puerto 8000) o Apache XAMPP
define('LARAVEL_API_URL', $isLocal
    ? 'http://localhost:8000/api'
    : 'https://viñasantodomingo.com/facturacion/api');

// Emails
define('EMAIL_EMPRESA', 'ventas@viñasantodomingo.com');
define('EMAIL_SOPORTE', 'envio@magus-qa.com');
define('NOMBRE_EMPRESA', 'VIÑASANTODOMINGO');
