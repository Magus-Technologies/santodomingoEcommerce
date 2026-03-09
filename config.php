<?php
// Configuración de URLs según el entorno
define('API_URL', getenv('API_URL') ?: 'http://localhost:8000');
define('APP_URL', getenv('APP_URL') ?: 'http://localhost');
