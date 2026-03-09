<?php

require_once '../vendor/autoload.php';

require "../utils/Tools.php";
require "../dao/ProductoDao.php";
require "../extra/ProductosApi.php";
require_once "../extra/TasaCambioApi.php";


$tasaCambioApi = new TasaCambioApi();
$cambio = $tasaCambioApi->getTasaCambio();
$tc = $cambio['cambio'];

$tools = new Tools();
$productoDao = new ProductoDao();
$productosApi = new ProductosApi();
$url = $_GET;
$explode = explode('/', $_SERVER['REQUEST_URI']);

$idPedido = $explode[4];
$sql = "SELECT pdd.pedido_id,CONCAT(pdd.nombre , ' ' , IF(ISNULL(pdd.apellido), '', pdd.apellido)) AS nombre_cliente,pdd.nun_doc,pdd.email,pdd.direccion,pdd.celular,
te.nombre AS tipo_envio,tpa.nombre AS tipo_pago,pdd.fecha,dep.dep_nombre,pro.pro_nombre,dis.dis_nombre,pdd.distrito_opcional
FROM pedidos AS pdd JOIN usuarios u ON u.use_id = pdd.id_usuario
LEFT JOIN tipo_envio AS te ON pdd.tipo_envio=te.id_tipo_envio
LEFT JOIN tipo_pago AS tpa ON pdd.tipo_pago=tpa.id_tipo_pago 
INNER JOIN sys_dir_departamento AS dep ON pdd.departamento_id=dep.dep_id
INNER JOIN sys_dir_provincia AS pro ON pdd.provincia_id=pro.pro_id
INNER JOIN sys_dir_distrito AS dis ON pdd.distrito_id=dis.dis_id where pdd.pedido_id ='{$idPedido}'";

$data_pedido = $productoDao->exeSQL($sql)->fetch_assoc();
/* echo "<pre>";
var_dump($data_pedido);
die(); */
/* echo "<pre>";
var_dump($data_pedido);
die(); */
$nombre = '';
$ndoc = '';
$correo = '';
$direccion = '';
$celular = '';
$tipopago = '';
$tipoenvio = '';
$fecha = '';
/* $tc = '';
$dni = ''; */

$nombre = $data_pedido['nombre_cliente'];
$ndoc = $data_pedido['nun_doc'];
$correo = $data_pedido['email'];
$direccion = $data_pedido['direccion'];
$celular = $data_pedido['celular'];
$tipoenvio = $data_pedido['tipo_envio'];
$tipopago = $data_pedido['tipo_pago'];
$fecha = $data_pedido['fecha'];
$departamento = $data_pedido['dep_nombre'];
$pro_nombre = $data_pedido['pro_nombre'];

$dis_nombre = '';
if (is_null($data_pedido['dis_nombre'])) {
    $dis_nombre = $data_pedido['distrito_opcional'];
} else {
    $dis_nombre = $data_pedido['dis_nombre'];
}


/*   $nombre = $value['nombre_cliente']; */

$sql = "select pd.*,p.nombre,prod_cod from pedido_detalles as pd join producto p on p.prod_id = pd.id_producto where pd.id_pedido='{$idPedido}'";


$lista_ped = $productoDao->exeSQL($sql);
/* echo "<pre>";
var_dump($lista_ped->fetch_assoc());
die(); */
$mpdf  = new \Mpdf\Mpdf([
    'margin_bottom' => 15,
    'margin_top' => 15,
    'margin_left' => 15,
    'margin_right' => 15,
    'mode' => 'utf-8',
]);


$total_lis = 0;
$htmlTd = '';
$total = '';
$totalSoles = 0;
foreach ($lista_ped as $i => $row_pd) {
    
    $bg = $i % 2 == 0 ? 'background-color: #CCCCCC;' : '';
    /* $conRay = $productosApi->getDataProd($row_pd['prod_cod']); */
    $total_lis += $row_pd['precio'] * $row_pd['cantidad'];
    /*  var_dump($row_pd['pedido_detalle_id']); */
    $precio = number_format($row_pd['precio'], 2, '.', ',');
    $importe = number_format($row_pd['precio'] * $row_pd['cantidad'], 2, '.', ',');
    $total  = number_format($total_lis, 2, ".", ",");
    /*   var_dump($total_lis . ' - ' . $tc); */
    $totalSoles = number_format($total_lis * $tc, 2, ".", ",");
    $htmlTd .=  "<tr style='$bg'>
            <td class='text-center' style='$bg font-size:12px;padding:5px'> {$row_pd['cantidad']} </td>       
            <td style='$bg font-size:12px;padding:5px'> {$row_pd['nombre']} </td>
            <td class='text-center' style='$bg font-size:12px;padding:5px'> 12 meses </td>
            <td class='text-center' style='$bg font-size:12px;padding:5px'> {$precio} </td>
            <td class='text-center' style='$bg font-size:12px;padding:5px'> {$importe} </td>
        </tr>";
    
}

/*  var_dump($total);
die(); */
/* $mpdf->setFooter('{PAGENO}'); */
$mpdf = new \Mpdf\Mpdf([
    'format' => 'A4',
    'margin_left' => 0,
    'margin_right' => 0,
    'margin_top' => 50,
    'margin_bottom' => 70,
    'margin_header' => 0,
    'margin_footer' => 0
]);


$mpdf->SetHTMLHeader("<img style='width: 100%;' src='../public/fondo_pedidos.png'>", 'e', true);

/* $mpdf->SetHTMLHeader()
 */


$mpdf->SetHTMLFooter("<img style='width: 2500px;height:150px' src='../public/footer_pedidos.png'>");
$html = " 
    <div style='padding: 0 70px'>
        <div style='margin-top:10px'>
            <div class='table-responsive-sm' style='width: 100%;'>
                <table class='table table-responsive' style='width: 80%;margin-left:20%'>
                    <thead>
                        <tr>
                            <th style='background-color:black;color:white;font-weight:bold;font-size:12px;border:none;text-align:left'>DATOS DEL CLIENTE:</th>
                        </tr>
                    </thead>
                    <tbody style>
                        <tr>
                            <td style='background-color:white;font-size:11px; text-transform: uppercase;padding:5px 0 5x 10px'>CLIENTE: {$nombre}</td>
                        </tr>
                        <tr>
                            <td style='background-color:#CCCCCC;font-size:11px; text-transform: uppercase;padding:5px 0 5x 10px'>N. Doc.: {$ndoc}</td>
                        </tr>
                        <tr>
                            <td style='background-color:white;font-size:11px; text-transform: uppercase;padding:5px 0 5x 10px'>Fecha: {$fecha}  </td>
                        </tr>
                        <tr>
                            <td style='background-color:#CCCCCC;font-size:11px; text-transform: uppercase;padding:5px 0 5x 10px'>Celular: {$celular}  </td>
                        </tr>
                    </tbody>
            
                </table>
            </div>

            <table class='table' style='margin-top:-15px'>
                <thead>
                    <tr>
                        <th class='text-center' style='background-color:#18368E;color:white;font-weight:bold;font-size:12px;border:none'>Cant.</th>
                        <th class='text-center' style='background-color:#18368E;color:white;font-weight:bold;font-size:12px;border:none'>Producto</th>
                        <th class='text-center' style='background-color:black;color:white;font-weight:bold;font-size:12px;border:none'>Garant</th>
                        <th class='text-center' style='background-color:black;color:white;font-weight:bold;font-size:12px;border:none'>Precio U.</th>
                        <th class='text-center' style='background-color:black;color:white;font-weight:bold;font-size:12px;border:none'>Total</th>
                    </tr>
                </thead>
                <tbody>

                {$htmlTd}


                </tbody>
            
            </table>

            <div style='margin-top:5rem;'>
                <div style='color:red;background-color: #FFF;text-align: center;position: relative;z-index: 9999;width: 130px;margin: 10px 0 0 120px;font-weight:bold' id='why'>
                    TOTAL DOLARES
                </div>
                <div style='border: 3px solid;border-radius: 10px 10px 10px 10px;position: relative;margin: -10px 0 0 80px;width: 200px' id='large-div-text'>
                        <p style='font-weight:bold;padding: 0px 0 0 55px'>US$ <span style='font-weight:bold'>{$total}</span></p>
                </div>
                <div style='color:red;background-color: #FFF;text-align: center;position: relative;z-index: 9999;width: 130px;margin: -70px 0 0 420px;font-weight:bold' id='why'>
                    TOTAL SOLES
                </div>
                <div style='border: 3px solid;border-radius: 10px 10px 10px 10px;position: relative;margin: -10px 0 0 380px;width: 210px' id='large-div-text'>
                        <p style='font-weight:bold;padding: 0px 0 0 55px'>S/. <span style='font-weight:bold'>{$totalSoles}</span></p>
                </div>
                <div class='text-center mt-3 mb-3'>
                    <span style='font-weight:bold; font-size: 9px !important;color:red;'>* LOS PRECIOS INCLUYEN I.G.V</span>        
                </div>
            </div>
        </div>
    </div>
";

$stylesheet = '.table {
    border-collapse: collapse !important;
}
.table td,
.table th {
    background-color: #fff !important;
}
.table td,
    .table th {
        background-color: #fff !important;
    }.table {
        width: 100%;
        margin-bottom: 1rem;
        color: #212529;
    }
    .table td,
    .table th {
        padding: 0.75rem;
        vertical-align: top;
        border-top: 1px solid #dee2e6;
    }
    .table thead th {
        vertical-align: bottom;
        border-bottom: 2px solid #dee2e6;
    }
    .table tbody + tbody {
        border-top: 2px solid #dee2e6;
    }.text-center {
        text-align: center !important;
    }.mt-3,
    .my-3 {
        margin-top: 1rem !important;
    }.mb-3,
    .my-3 {
        margin-bottom: 1rem !important;
    }';

$mpdf->WriteHTML($stylesheet, 1);
/* $mpdf->WriteHTML($html, 2);  */
/* $mpdf->WriteFixedPosHTML($html, 10, 10, 190, 150); */
$mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);
$mpdf->Output();
