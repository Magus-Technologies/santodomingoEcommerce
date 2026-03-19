<?php
/**
 * Proxy para Productos en Remate
 * Acciones: listar, quitar
 */
session_start();
require "../dao/Session.php";
$sessionModel = new Session;
$validate = $sessionModel->validateSession();

if (!isset($_SESSION['usuario'])) {
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit;
}

header('Content-Type: application/json');

require "../config.php";

$accion = $_GET['accion'] ?? $_POST['accion'] ?? 'listar';

if ($accion === 'listar') {
    $url = API_URL . '/api/public/productos-en-remate';
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

} elseif ($accion === 'actualizar') {
    $id            = intval($_POST['id'] ?? 0);
    $precioRemate  = floatval($_POST['precio_remate'] ?? 0);
    if ($id <= 0) {
        echo json_encode(['success' => false, 'message' => 'ID inválido']);
        exit;
    }

    $url = API_URL . '/api/public/productos-en-remate/' . $id;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(['precio_remate' => $precioRemate]));
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept: application/json', 'X-Internal-Request: 1']);
    $response = curl_exec($ch);
    $error    = curl_error($ch);
    curl_close($ch);

    if ($error) {
        echo json_encode(['success' => false, 'message' => 'Error de conexión: ' . $error]);
        exit;
    }
    echo $response ?: json_encode(['success' => true]);

} elseif ($accion === 'quitar') {
    $id = intval($_POST['id'] ?? 0);
    if ($id <= 0) {
        echo json_encode(['success' => false, 'message' => 'ID inválido']);
        exit;
    }

    $url = API_URL . '/api/public/productos-en-remate/' . $id;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept: application/json', 'X-Internal-Request: 1']);
    $response = curl_exec($ch);
    $error    = curl_error($ch);
    curl_close($ch);

    if ($error) {
        echo json_encode(['success' => false, 'message' => 'Error de conexión: ' . $error]);
        exit;
    }
    echo $response ?: json_encode(['success' => true]);

} else {
    echo json_encode(['success' => false, 'message' => 'Acción inválida']);
}
