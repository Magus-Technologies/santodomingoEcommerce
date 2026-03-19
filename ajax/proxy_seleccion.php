<?php
/**
 * Proxy para API pública de grupo-seleccion
 */
require "../config.php";

$tipo    = $_POST['tipo'] ?? $_GET['tipo'] ?? '';
$apiBase = API_URL . '/api/public/grupo-seleccion';

function curlCall($url, $method = 'GET', $data = null, $isMultipart = false) {
    $ch = curl_init();
    $headers = ['Accept: application/json'];

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    if ($method === 'POST') {
        curl_setopt($ch, CURLOPT_POST, true);
        if ($isMultipart) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        } else {
            $headers[] = 'Content-Type: application/json';
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }
    } elseif ($method === 'DELETE') {
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
    }

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($ch);

    return $response;
}

header('Content-Type: application/json');

// GET categorías
if ($tipo === 'categorias') {
    $url = API_URL . '/api/public/categorias';
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept: application/json']);
    echo curl_exec($ch);
    exit;
}

// GET lista
if ($tipo === 'lista') {
    echo curlCall($apiBase);
    exit;
}

// GET uno
if ($tipo === 'get') {
    $id = (int)($_POST['id'] ?? 0);
    echo curlCall($apiBase . '/' . $id);
    exit;
}

// POST crear
if ($tipo === 'crear') {
    $postData = [
        'nombre_cate'    => $_POST['nombre_cate'] ?? '',
        'codi_categoria' => $_POST['codi_categoria'] ?? '',
        'estado'         => $_POST['estado'] ?? '1',
    ];
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
        $postData['imagen'] = new CURLFile(
            $_FILES['imagen']['tmp_name'],
            $_FILES['imagen']['type'],
            $_FILES['imagen']['name']
        );
    }
    $ch = curl_init($apiBase);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept: application/json']);
    echo curl_exec($ch);

    exit;
}

// POST actualizar (ruta pública usa POST con id en URL)
if ($tipo === 'actualizar') {
    $id = (int)($_POST['id'] ?? 0);
    $postData = [
        'nombre_cate'    => $_POST['nombre_cate'] ?? '',
        'codi_categoria' => $_POST['codi_categoria'] ?? '',
        'estado'         => $_POST['estado'] ?? '1',
    ];
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
        $postData['imagen'] = new CURLFile(
            $_FILES['imagen']['tmp_name'],
            $_FILES['imagen']['type'],
            $_FILES['imagen']['name']
        );
    }
    $ch = curl_init($apiBase . '/' . $id);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept: application/json']);
    echo curl_exec($ch);

    exit;
}

// DELETE eliminar
if ($tipo === 'eliminar') {
    $id = (int)($_POST['id'] ?? 0);
    echo curlCall($apiBase . '/' . $id, 'DELETE');
    exit;
}

echo json_encode(['success' => false, 'message' => 'Tipo de operacion invalido']);
