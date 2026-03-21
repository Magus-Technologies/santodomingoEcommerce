<?php
ini_set('display_errors', 0);
error_reporting(0);

require_once '../vendor/autoload.php';
require "../utils/Tools.php";
require "../dao/ProductoDao.php";
require "../extra/ProductosApi.php";
require_once "../extra/TasaCambioApi.php";

// Config PDF desde admin
$_pdfConf     = (new Tools())->getConfiguracion()['pdf_empresa'] ?? [];
$_pdfEmpresa  = $_pdfConf['empresa']   ?? 'Ace Advance Group S.A.C';
$_pdfRuc      = $_pdfConf['ruc']       ?? '20613235168';
$_pdfDir      = $_pdfConf['direccion'] ?? 'Av Bolivia 180 int 318 tercer piso, Lima, Peru';
$_pdfGarantia = $_pdfConf['garantia']  ?? '12 meses';

// Logo: ruta absoluta para mPDF
$_pdfLogo = realpath(__DIR__ . '/../public/images/cym.png');
if (!empty($_pdfConf['logo'])) {
    $custom = realpath(__DIR__ . '/../' . ltrim(str_replace('../', '', $_pdfConf['logo']), '/'));
    if ($custom && file_exists($custom)) $_pdfLogo = $custom;
}
$_pdfLogo = str_replace('\\', '/', (string)$_pdfLogo);

$tasaCambioApi = new TasaCambioApi();
$cambio = $tasaCambioApi->getTasaCambio();
$tc = $cambio['cambio'];

$tools       = new Tools();
$productoDao = new ProductoDao();
$productosApi = new ProductosApi();

$explode  = explode('/', $_SERVER['REQUEST_URI']);
$idPedido = (int) end($explode);

$sql = "SELECT pdd.pedido_id,
    CONCAT(pdd.nombre , ' ' , IF(ISNULL(pdd.apellido), '', pdd.apellido)) AS nombre_cliente,
    pdd.nun_doc, pdd.email, pdd.direccion, pdd.celular,
    te.nombre AS tipo_envio, tpa.nombre AS tipo_pago, pdd.fecha,
    dep.dep_nombre, pro.pro_nombre, dis.dis_nombre, pdd.distrito_opcional
FROM pedidos AS pdd
JOIN usuarios u ON u.use_id = pdd.id_usuario
LEFT JOIN tipo_envio AS te ON pdd.tipo_envio = te.id_tipo_envio
LEFT JOIN tipo_pago AS tpa ON pdd.tipo_pago = tpa.id_tipo_pago
INNER JOIN sys_dir_departamento AS dep ON pdd.departamento_id = dep.dep_id
INNER JOIN sys_dir_provincia AS pro ON pdd.provincia_id = pro.pro_id
INNER JOIN sys_dir_distrito AS dis ON pdd.distrito_id = dis.dis_id
WHERE pdd.pedido_id = '{$idPedido}'";

$data_pedido = $productoDao->exeSQL($sql)->fetch_assoc();

$nombre    = $data_pedido['nombre_cliente'] ?? '';
$ndoc      = $data_pedido['nun_doc'] ?? '';
$celular   = $data_pedido['celular'] ?? '';
$fecha     = $data_pedido['fecha'] ?? '';
$dis_nombre = !empty($data_pedido['dis_nombre']) ? $data_pedido['dis_nombre'] : ($data_pedido['distrito_opcional'] ?? '');

// Productos del pedido
$sql2 = "SELECT pd.cantidad, pd.precio, pd.estado,
    COALESCE(p.nombre, pd.nombre, pd.id_producto) AS nombre,
    COALESCE(p.prod_cod, '') AS prod_cod
FROM pedido_detalles AS pd
LEFT JOIN producto p ON p.prod_id = pd.id_producto
WHERE pd.id_pedido = '{$idPedido}'";

$lista_ped = $productoDao->exeSQL($sql2);

// Construir filas de productos
$total_lis = 0;
$htmlTd    = '';
foreach ($lista_ped as $i => $row_pd) {
    $total_lis += $row_pd['precio'] * $row_pd['cantidad'];
    $precio  = number_format($row_pd['precio'], 2, '.', ',');
    $importe = number_format($row_pd['precio'] * $row_pd['cantidad'], 2, '.', ',');
    $htmlTd .= "<tr>
        <td class='text-center' style='font-size:12px;padding:5px'>{$row_pd['cantidad']}</td>
        <td style='font-size:12px;padding:5px'>{$row_pd['nombre']}</td>
        <td class='text-center' style='font-size:12px;padding:5px'>{$_pdfGarantia}</td>
        <td class='text-center' style='font-size:12px;padding:5px'>{$precio}</td>
        <td class='text-center' style='font-size:12px;padding:5px'>{$importe}</td>
    </tr>";
}
$total = number_format($total_lis, 2, '.', ',');

// Generar PDF
$mpdf = new \Mpdf\Mpdf([
    'format'        => 'A4',
    'margin_left'   => 0,
    'margin_right'  => 0,
    'margin_top'    => 50,
    'margin_bottom' => 70,
    'margin_header' => 0,
    'margin_footer' => 0,
]);

$htmlCuadroHead = "<div style='width:34%;text-align:center;background:#fff;float:right;'>
    <div style='padding:5px;width:100%;height:100px;border:2px solid #1e1e1e;'>
        <div style='margin-top:10px'></div>
        <span><strong>COTIZACION: #{$idPedido}</strong></span><br>
        <div style='margin-top:10px'></div>
        <span><strong>RUC: {$_pdfRuc}</strong></span><br>
    </div>
</div>";

$mpdf->WriteFixedPosHTML("<img style='max-width:300px;max-height:95px' src='{$_pdfLogo}'>", 15, 5, 150, 120);
$mpdf->WriteFixedPosHTML($htmlCuadroHead, 0, 5, 195, 130);
$mpdf->WriteFixedPosHTML("<span style='font-size:12px'><strong>Empresa: </strong>{$_pdfEmpresa}</span>", 18, 32, 210, 130);
$mpdf->WriteFixedPosHTML("<span style='font-size:12px'><strong>Dirección:</strong> <span style='font-size:10px'>{$_pdfDir}</span></span>", 18, 37, 120, 130);

$html = "
<div style='padding:0 70px'>
    <div style='margin-top:10px'>
        <table class='table' style='width:100%'>
            <thead>
                <tr><th style='background:#000;color:#fff;font-size:12px;border:none;text-align:left'>DATOS DEL CLIENTE:</th></tr>
            </thead>
            <tbody>
                <tr><td style='background:#fff;font-size:11px;text-transform:uppercase;padding:5px 0'>CLIENTE: {$nombre}</td></tr>
                <tr><td style='background:#fff;font-size:11px;text-transform:uppercase;padding:5px 0'>N. Doc.: {$ndoc}</td></tr>
                <tr><td style='background:#fff;font-size:11px;text-transform:uppercase;padding:5px 0'>Fecha: {$fecha}</td></tr>
                <tr><td style='background:#fff;font-size:11px;text-transform:uppercase;padding:5px 0;border-bottom:1px solid #1e1e1e'>Celular: {$celular}</td></tr>
            </tbody>
        </table>

        <table class='table' style='margin-top:15px;border-bottom:1px solid #1e1e1e'>
            <thead>
                <tr>
                    <th class='text-center' style='background:#000;color:#fff;font-size:12px;border:none'>Cant.</th>
                    <th class='text-center' style='background:#000;color:#fff;font-size:12px;border:none'>Producto</th>
                    <th class='text-center' style='background:#000;color:#fff;font-size:12px;border:none'>Garant</th>
                    <th class='text-center' style='background:#000;color:#fff;font-size:12px;border:none'>Precio U.</th>
                    <th class='text-center' style='background:#000;color:#fff;font-size:12px;border:none'>Total</th>
                </tr>
            </thead>
            <tbody>{$htmlTd}</tbody>
        </table>

        <div style='margin-top:5rem;'>
            <div style='color:red;background:#fff;text-align:center;position:relative;z-index:9999;width:130px;margin:-70px 0 0 420px;font-weight:bold'>
                TOTAL SOLES
            </div>
            <div style='border:3px solid;border-radius:10px;position:relative;margin:-10px 0 0 380px;width:210px'>
                <p style='font-weight:bold;padding:0 0 0 55px'>S/. <strong>{$total}</strong></p>
            </div>
            <div class='text-center mt-3 mb-3'>
                <span style='font-weight:bold;font-size:9px;color:red'>* LOS PRECIOS INCLUYEN I.G.V</span>
            </div>
        </div>
    </div>
</div>";

$stylesheet = '
.table { border-collapse: collapse !important; width: 100%; color: #212529; margin-bottom: 1rem; }
.table td, .table th { background-color: #fff !important; padding: 0.75rem; vertical-align: top; border-top: 1px solid #dee2e6; }
.table thead th { vertical-align: bottom; border-bottom: 2px solid #dee2e6; }
.text-center { text-align: center !important; }
.mt-3 { margin-top: 1rem !important; }
.mb-3 { margin-bottom: 1rem !important; }';

$mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);
$mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);
$mpdf->Output();
