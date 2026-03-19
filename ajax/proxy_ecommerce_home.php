<?php
/**
 * Proxy para secciones del Home Ecommerce
 * Endpoints: nuevos-ingresos, mas-vendidos, ofertas-especiales
 */
require "../config.php";

header('Content-Type: application/json');

$seccion = $_GET['seccion'] ?? $_POST['seccion'] ?? '';

$endpoints = [
    'nuevos-ingresos'           => '/api/public/nuevos-ingresos',
    'mas-vendidos'              => '/api/public/mas-vendidos',
    'ofertas-especiales'        => '/api/public/ofertas-especiales',
    'productos-de-tendencia'    => '/api/public/productos-de-tendencia',
    'productos-mas-rentables'   => '/api/public/productos-mas-rentables',
    'productos-mejor-valorados-mes' => '/api/public/productos-mejor-valorados-mes',
];

if (!isset($endpoints[$seccion])) {
    echo json_encode(['success' => false, 'message' => 'Sección inválida']);
    exit;
}

$url = API_URL . $endpoints[$seccion];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept: application/json']);

$response = curl_exec($ch);
$error    = curl_error($ch);
curl_close($ch);

if ($error) {
    echo json_encode(['success' => false, 'message' => 'Error de conexión: ' . $error]);
    exit;
}

echo $response;
