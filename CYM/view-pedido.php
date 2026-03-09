<?php

require_once '../vendor/autoload.php';

require "../utils/Tools.php";
require "../dao/ProductoDao.php";
require "../extra/ProductosApi.php";

$tools = new Tools();
$productoDao = new ProductoDao();
$productosApi = new ProductosApi();
$url = $_GET;
$explode = explode('/', $_SERVER['REQUEST_URI']);
$idPedido = $explode[4];
$sql = "SELECT pdd.pedido_id,CONCAT(pdd.nombre , ' ' , IF(ISNULL(pdd.apellido), '', pdd.apellido)) AS nombre_cliente,pdd.nun_doc,pdd.email,pdd.direccion,pdd.celular,
te.nombre AS tipo_envio,tpa.nombre AS tipo_pago,pdd.fecha
FROM pedidos AS pdd JOIN usuarios u ON u.use_id = pdd.id_usuario
LEFT JOIN tipo_envio AS te ON pdd.tipo_envio=te.id_tipo_envio
LEFT JOIN tipo_pago AS tpa ON pdd.tipo_pago=tpa.id_tipo_pago where pdd.pedido_id ='{$idPedido}'";

$data_pedido = $productoDao->exeSQL($sql)->fetch_assoc();
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
/*   $nombre = $value['nombre_cliente']; */

$sql = "select pd.*,p.nombre,prod_cod from pedido_detalles as pd join producto p on p.prod_id = pd.id_producto where pd.id_pedido='{$idPedido}'";

$lista_ped = $productoDao->exeSQL($sql);
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
foreach ($lista_ped as $row_pd) {
    $conRay = $productosApi->getDataProd($row_pd['prod_cod']);
    $total_lis += $conRay['precio_venta'] * $row_pd['cantidad'];
    $precio = number_format($conRay['precio_venta'], 2, '.', ',');
    $importe = number_format($conRay['precio_venta'] * $row_pd['cantidad'], 2, '.', ',');
    $total  = number_format($total_lis, 2, ".", ",");
    $htmlTd .=  "<tr>
            <td class='text-center'> {$row_pd['prod_cod']} </td>
            <td> {$row_pd['nombre']} </td>
            <td class='text-center'> {$row_pd['cantidad']} </td>
            <td class='text-center'>$ {$precio} </td>
            <td class='text-center'>$ {$importe} </td>
        </tr>";
}

/*  var_dump($total);
die(); */
$mpdf->setFooter('{PAGENO}');
$mpdf = new \Mpdf\Mpdf([
    'format' => 'A4',
    'margin_left' => 0,
    'margin_right' => 0,
    'margin_top' => 0,
    'margin_bottom' => 0,
    'margin_header' => 0,
    'margin_footer' => 0
]);


$mpdf->WriteFixedPosHTML("<img style='width: 100%;' src='../public/fondo_pedidos.png'>", 0, 0, 320, 240);





$mpdf->SetHTMLFooter("<img style='width: 2500px;' src='../public/footer_pedidos.png'>");
$html = " 

<html>
  <head>
    <meta name='viewport' content='width=device-width, initial-scale=1' />
    <style>
      table {
        border-collapse: collapse;
        border-spacing: 0;
        width: 100%;
        border: 1px solid #ddd;
      }

      th,
      td {
        text-align: left;
        padding: 16px;
      }

      tr:nth-child(even) {
        background-color: #f2f2f2;
      }
    </style>
  </head>


 <br>
 <br>
 <br>
 <br>
 <br>
    <h1 class='text-center' style='font-weight:bold;margin-top:4rem;color:#f44;font-family: Times New Roman, Times, serif'>PROFORMA WEB : PW-$idPedido</h1>
    <div class='form-group col-md-12' style='margin-top:2rem'>
   
    

    <table class='table table-striped' style='border-collapse: separate;
    border-spacing: 3px 0;
    '>
    <thead>
    <tr>
      <th>#</th>
      <th>Firstname</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>1</td>
      <td>Anna</td>
    </tr>
    <tr>
      <td>2</td>
      <td>Debbie</td>
    </tr>
    <tr>
      <td>3</td>
      <td>John</td>
    </tr>
  </tbody>
 
</table>





<table class='table table-bordered'>
    <thead>
        <tr>
            <th class='text-center'>Codigo</th>
            <th class='text-center'>Producto</th>
            <th class='text-center'>Cnt</th>
            <th class='text-center'>Precio</th>
            <th class='text-center'>Importe</th>
        </tr>
    </thead>
    <tbody>

    {$htmlTd}


    </tbody>
    <tfoot>
        <tr>
            <td colspan='4' class='text-right'><strong>Total</strong></td>
            <td class='text-center'>$ $total</td>
        </tr>
    </tfoot>
</table>

<img src='../public/cuentas_bancarias.png'>
</div>
<html>
";

$stylesheet = file_get_contents('../public/css/bootsrap.css');
$mpdf->WriteHTML($stylesheet, 1);
/* $mpdf->WriteHTML($html, 2);  */
$mpdf->WriteFixedPosHTML($html, 5, 10, 200, 150);
$mpdf->Output();
