<?php
/**
 * Proxy hacia las APIs públicas de facturacion_santoDomingo.
 *   tipo=productos  → GET /api/public/shop-productos
 *   tipo=marcas     → factura_santod3.marcra_productos (directo DB)
 *   tipo=categorias → factura_santod3.categorias (directo DB)
 */

require "../config/urls.php";
require "../utils/Conexion.php";

$laravelApi = LARAVEL_API_URL;

// URL base del storage de Laravel para construir URLs de imágenes
$scheme      = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host        = $_SERVER['HTTP_HOST'];
$scriptDir   = dirname($_SERVER['SCRIPT_NAME']);   // /demo/public_html/ajax
$publicRoot  = dirname($scriptDir);                // /demo/public_html
$demoRoot    = dirname($publicRoot);               // /demo
$storageBase = $scheme . '://' . $host . $demoRoot . '/facturacion_santoDomingo/public/storage/';

function fetchApi(string $url): ?array {
    $ctx = stream_context_create(['http' => ['timeout' => 8, 'ignore_errors' => true]]);
    $raw = @file_get_contents($url, false, $ctx);
    if ($raw === false) return null;
    return json_decode($raw, true);
}

header('Content-Type: application/json');

$tipo = $_POST['tipo'] ?? 'productos';

// ── PRODUCTOS ──────────────────────────────────────────────────────────────
if ($tipo === 'productos') {
    $params = http_build_query(array_filter([
        'categoria'  => $_POST['categoria']  ?? '',
        'marca'      => $_POST['marca']      ?? '',
        'search'     => $_POST['search']     ?? '',
        'min_precio' => $_POST['min_precio'] ?? '',
        'max_precio' => $_POST['max_precio'] ?? '',
        'sort'       => $_POST['sort']       ?? '',
        'per_page'   => 1000,
    ], fn($v) => $v !== ''));

    $data = fetchApi($laravelApi . '/public/shop-productos?' . $params);

    if (!$data || !isset($data['data'])) {
        echo json_encode([]);
        exit;
    }

    $result = [];
    foreach ($data['data'] as $prod) {
        $imagenRaw = $prod['imagen1'] ?? '';
        $imagen    = !empty($imagenRaw) ? $storageBase . $imagenRaw : '';

        $result[] = [
            'prod_id'  => $prod['prod_id'],
            'nom_prod' => $prod['nombre']   ?? '',
            'nombre'   => $prod['nombre']   ?? '',
            'content1' => $prod['content1'] ?? '',
            'content2' => '',
            'content3' => '',
            'precio'   => (float)($prod['precio'] ?? 0),
            'stock'    => (int)($prod['stock']    ?? 0),
            'imagen1'  => $imagen,
            'imagen2'  => $imagen,
            'marca'    => $prod['marca']    ?? '',
            'marca_id' => $prod['marca_id'] ?? '',
            'sub_cat'  => '',
            'is_ofert' => false,
        ];
    }

    echo json_encode($result);

// ── MARCAS ──────────────────────────────────────────────────────────────────
} elseif ($tipo === 'marcas') {
    $conexion = (new Conexion())->getConexion();
    $sql = "SELECT cod_marca, nombre_marca
            FROM marcra_productos
            WHERE estado = '1'
            ORDER BY nombre_marca";

    $res  = $conexion->query($sql);
    $data = [];
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $data[] = [
                'cod_marca'    => $row['cod_marca'],
                'nombre_marca' => $row['nombre_marca'],
            ];
        }
    }

    echo json_encode(['success' => true, 'data' => $data]);

// ── CATEGORÍAS ─────────────────────────────────────────────────────────────
} elseif ($tipo === 'categorias') {
    $conexion = (new Conexion())->getConexion();
    $sql = "SELECT cod_marca AS id, nombre_marca AS nombre
            FROM marcra_productos
            WHERE estado = '1'
            ORDER BY nombre_marca";

    $res  = $conexion->query($sql);
    $data = [];
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $data[] = ['id' => $row['id'], 'nombre' => $row['nombre']];
        }
    }

    echo json_encode(['success' => true, 'data' => $data]);
}
