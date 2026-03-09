<?php

require_once '../vendor/autoload.php';

require "../utils/Tools.php";
require "../dao/ProductoDao.php";
require "../extra/ProductosApi.php";
require_once "../extra/TasaCambioApi.php";

$totalCompraDol=0;

$tasaCambioApi = new TasaCambioApi();
$cambio = $tasaCambioApi->getTasaCambio();
$tc = $cambio['cambio'];

$tools = new Tools();
$productoDao = new ProductoDao();
$productosApi = new ProductosApi();
$url = $_GET;
$explode = explode('/', $_SERVER['REQUEST_URI']);
$idCompra = $explode[count($explode) - 1];
$sql = "SELECT DATE_FORMAT(cd.fecha, '%Y-%m-%d') fecha_cc, cd.tipo_envio,cd.compra_id,CONCAT(cd.nombre , ' ' , IF(ISNULL(cd.apellido), '', cd.apellido)) AS nombre_cliente,
       cd.nun_doc,cd.email,cd.direccion,cd.celular,
te.nombre AS tipo_envio,tpa.nombre AS tipo_pago,cd.fecha,dep.dep_nombre,pro.pro_nombre,dis.dis_nombre,cd.distrito_opcional,cd.costo_flete
FROM compras AS cd JOIN usuarios u ON u.use_id = cd.id_usuario
LEFT JOIN tipo_envio AS te ON cd.tipo_envio=te.id_tipo_envio
LEFT JOIN tipo_pago AS tpa ON cd.tipo_pago=tpa.id_tipo_pago 
INNER JOIN sys_dir_departamento AS dep ON cd.departamento_id=dep.dep_id
INNER JOIN sys_dir_provincia AS pro ON cd.provincia_id=pro.pro_id
INNER JOIN sys_dir_distrito AS dis ON cd.distrito_id=dis.dis_id where cd.compra_id ='{$idCompra}'";



$data_pedido = $productoDao->exeSQL($sql)->fetch_assoc();
$cambioCC = $tasaCambioApi->getTasaCambioFecha($data_pedido['fecha_cc']);
$tcCC = $cambioCC['cambio'];

//var_dump($data_pedido);
//die();

$sql="SELECT cd.*,p.nombre,prod_cod,co.*,u.nombres,te.nombre AS tipoenvio,tp.nombre AS tipopago,
SUM(precio * cantidad) AS total ,co.costo_flete
FROM compras_detalles AS cd 
JOIN compras AS co ON co.compra_id=cd.id_compra
LEFT JOIN tipo_envio AS te ON co.tipo_envio=te.id_tipo_envio
LEFT JOIN tipo_pago AS tp ON co.tipo_pago=tp.id_tipo_pago
JOIN usuarios u ON u.use_id = co.id_usuario
JOIN producto p ON p.prod_id = cd.id_producto where co.compra_id='{$idCompra}'  GROUP BY cd.id_compra  ";
$data_pedido2 = $productoDao->exeSQL($sql)->fetch_assoc();

$totalFinalFfF=$data_pedido2['total'];
$totalFinalFfFSol=$data_pedido2['total']*$tcCC;


/* e
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

$sql = "SELECT cd.*,p.nombre,prod_cod FROM compras_detalles AS cd JOIN producto p ON p.prod_id = cd.id_producto WHERE cd.id_compra='{$idCompra}'";


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
$costeFlete = 0;
$porcentajeACobrarDol = 0;
$porcentajeACobrarSol = 0;
if ($data_pedido['costo_flete'] == 7) {
    $costeFlete = ($data_pedido['costo_flete']);
} else if ($data_pedido['costo_flete'] == 30) {
    $costeFlete = ($data_pedido['costo_flete']);
    $costeFlete = number_format($costeFlete, 2, ".", ",");
} else {
    $costeFlete = 0;
}
foreach ($lista_ped as $row_pd) {
    /* $conRay = $productosApi->getDataProd($row_pd['prod_cod']); */



    $total_lis += $row_pd['precio'] * $row_pd['cantidad'];
    /*  var_dump($row_pd['pedido_detalle_id']); */
    $precio = number_format($row_pd['precio'], 2, '.', ',');
    $importe = number_format($row_pd['precio'] * $row_pd['cantidad'], 2, '.', ',');
    $total  = doubleval($total_lis);

    if ($data_pedido['costo_flete'] == 7) {
        if ($data_pedido['tipo_envio']=='Envío'){
            $total = $total + ($data_pedido['costo_flete']);
        }

        $porcentajeACobrarDol = ($total * 0.05);
        $total = $total + $porcentajeACobrarDol;
        $totalCompraDol=$total;
        $total = number_format($total, 2, ".", ",");
    } else {
        if ($data_pedido['tipo_envio']=='Envío'){
            $total = $total + (intval($data_pedido['costo_flete']) / $tcCC);
        }

        $porcentajeACobrarDol = ($total * 0.05);
        $total = $total + $porcentajeACobrarDol;
        $totalCompraDol=$total;
        $total = number_format($total, 2, ".", ",");
    }
    /* $total = $total  +  */
    /*   var_dump($total_lis . ' - ' . $tc); */

    if ($data_pedido['costo_flete'] == 7) {
        $totalSoles = ($total_lis * $tcCC);
        if ($data_pedido['tipo_envio']=='Envío'){
            $totalSoles = ($totalSoles + (intval($data_pedido['costo_flete']) / $tcCC));
        }

        $porcentajeACobrarSol = ($totalSoles * 0.05);
        $totalSoles = $totalSoles + $porcentajeACobrarSol;
        $totalSoles = number_format($totalSoles, 2, ".", ",");
    } else {
        $totalSoles = ($total_lis * $tcCC);
        if ($data_pedido['tipo_envio']=='Envío'){
            $totalSoles = ($totalSoles + (intval($data_pedido['costo_flete'])));
        }

        $porcentajeACobrarSol = ($totalSoles * 0.05);
       /*  $totalSoles = $totalSoles + $porcentajeACobrarSol;
        $totalSoles = number_format($totalSoles, 2, ".", ","); */
    }
    $htmlTd .=  "<tr >
            <td class='text-center' style='font-size:9px;padding:5px'> {$row_pd['compra_detalle_id']} </td>
            <td class='text-center' style='font-size:9px;padding:5px'> {$row_pd['cantidad']} </td>       
            <td style='font-size:9px;padding:5px'> {$row_pd['nombre']} </td>
            <td class='text-center' style='font-size:9px;padding:5px'> 12 meses </td>
            <td class='text-center' style='font-size:9px;padding:5px'> {$precio} </td>
            <td class='text-center' style='font-size:9px;padding:5px'> $ {$importe} </td>
        </tr>";
}

/* var_dump($totalSoles);
var_dump($porcentajeACobrarSol);
die(); */
$monedaFlete = '';
if (true) {
    $monedaFlete = '$ ';
} else if ($data_pedido['costo_flete'] == 30) {
    $monedaFlete = 'S/ ';
} else {
    $monedaFlete = '$ ';
}

if (true) {
    $porcentajeACobrar = $porcentajeACobrarDol;
} else if ($data_pedido['costo_flete'] == 30) {
    $porcentajeACobrar = $porcentajeACobrarSol;
} else {
    $porcentajeACobrar = 0;
}
$porcentajeACobrar= number_format($porcentajeACobrar,2,'.','.');

$monedaFlete2 = '';
if ($data_pedido['costo_flete'] == 7) {
    $monedaFlete2 = '$ ';
} else if ($data_pedido['costo_flete'] == 30) {
    $monedaFlete2 = 'S/ ';
} else {
    $monedaFlete2 = '$ ';
}
$envioPrecio=0;
if ($data_pedido['tipo_envio']=='Envío'){
    $envioPrecio=$costeFlete;
}
$htmlFlete='';
$htmlAumentoPorcentaje='';

$htmlFlete .=  "<tr >
<td class='text-center' style='font-size:9px;padding:5px'>  </td>
<td class='text-center' style='font-size:9px;padding:5px'> </td>       
<td style='font-size:9px;padding:5px'>Costo por Flete  </td>
<td class='text-center' style='font-size:9px;padding:5px'>  </td>
<td class='text-center' style='font-size:9px;padding:5px'> $tcCC </td>
<td class='text-center' style='font-size:9px;padding:5px'> $monedaFlete2 $envioPrecio </td>
</tr>";
$htmlAumentoPorcentaje .=  "<tr >
<td class='text-center' style='font-size:9px;padding:5px'>  </td>
<td class='text-center' style='font-size:9px;padding:5px'> </td>       
<td style='font-size:9px;padding:5px'>Costo por transaccion (5%)  </td>
<td class='text-center' style='font-size:9px;padding:5px'>  </td>
<td class='text-center' style='font-size:9px;padding:5px'>  </td>
<td class='text-center' style='font-size:9px;padding:5px'>$monedaFlete $porcentajeACobrar </td>
</tr>";

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
$totalCompraDol=$importe+$porcentajeACobrar+($monedaFlete2=='$ '?$costeFlete:$costeFlete/$tcCC);
$totalCompraDol = number_format($total*$tcCC, 2, '.', ',');

$mpdf->SetHTMLFooter("<img style='width: 2500px;height:150px' src='../public/footer_pedidos.png'>");
$html = " 
    <div style='padding: 0 70px '>

    <h1 class='text-center' style='font-weight:bold;padding-top:0;color:#f44;font-family: Times New Roman, Times, serif;font-size:30px'>COMPRA N°-$idCompra</h1>
    <div class='form-group col-md-12' style='margin-top:10px'>
   
    
    <div class='table-responsive-sm'>
    <table class='table table-responsive' >
    <thead >
        <tr>
            <th   style='background-color:black;color:white;font-weight:bold;font-size:9px;border:none;text-align:left'>DATOS DEL CLIENTE:</th>
            <th  class='text-center' style='background-color:black;color:white;font-weight:bold;font-size:9px;border:none'>HORA Y FECHA:</th>
            <th  class='text-center' style='background-color:black;color:white;font-weight:bold;font-size:9px;border:none'>{$fecha}</th> 
        </tr>
    </thead>
    <tbody style>
    <tr>
        <td  style='background-color:#FCFCFC;font-size:9px; text-transform: uppercase;padding:5px 0 5x 10px'>CLIENTE: {$nombre}</td>
        <td class='text-center' style='background-color:#FCFCFC;font-size:9px; text-transform: uppercase;padding:5px 0 5x 10px '>CELULAR </td>
        <td class='text-center' style='background-color:#FCFCFC;font-size:9px; text-transform: uppercase;padding:5px 0 5x 10px '>{$celular}  </td>
    </tr>
    <tr>
        <td  style='background-color:#F5F5F5;font-size:9px; text-transform: uppercase;padding:5px 0 5x 10px'>N. Doc.: {$ndoc}</td>
        <td class='text-center' style='background-color:#F5F5F5;font-size:9px; text-transform: uppercase;padding:5px 0 5x 10px'>TIPO DE PAGO </td>
        <td class='text-center' style='background-color:#F5F5F5;font-size:9px; text-transform: uppercase;padding:5px 0 5x 10px'>{$tipopago}  </td>
    </tr>
    <tr>
        <td  style='background-color:#FCFCFC;font-size:9px; text-transform: uppercase;padding:5px 0 5x 10px'>Correo: {$correo}</td>
        <td class='text-center' style='background-color:#FCFCFC;font-size:9px; text-transform: uppercase;padding:5px 0 5x 10px'>TIPO ENVIO </td>
        <td class='text-center' style='background-color:#FCFCFC;font-size:9px; text-transform: uppercase;padding:5px 0 5x 10px'>{$tipoenvio}  </td>
    </tr>
    <tr>
        <td  colspan='4' style='background-color:#F5F5F5;font-size:9px; text-transform: uppercase;padding:5px 0 5x 10px;white-space:pre-wrap; word-wrap:break-word'>DIRECCION: {$direccion}</td>
    </tr>
    <tr>
    <td  style='background-color:#FCFCFC;font-size:9px; text-transform: uppercase;padding:5px 0 5x 10px'>DEPARTAMENTO: {$departamento}</td>
    <td class='text-center'  style='background-color:#FCFCFC;font-size:9px; text-transform: uppercase;padding:5px 0 5x 10px'>PROVINCIA :  </td>
    <td class='text-center' style='background-color:#FCFCFC;font-size:9px; text-transform: uppercase;padding:5px 0 5x 10px'> {$pro_nombre} </td>
    
</tr>
<tr>

<td  style='background-color:#FCFCFC;font-size:9px; text-transform: uppercase;padding:5px 0 5x 10px'>DISTRITO : {$dis_nombre}  </td>
</tr>
    </tbody>
 
</table>

</div>



<table class='table' style='margin-top:-10px'>
    <thead>
        <tr>
            <th class='text-center' style='background-color:black;color:white;font-weight:bold;font-size:12px;border:none'>Id</th>
            <th class='text-center' style='background-color:black;color:white;font-weight:bold;font-size:12px;border:none'>Cant.</th>
            <th class='text-center' style='background-color:black;color:white;font-weight:bold;font-size:12px;border:none'>Producto</th>
            <th class='text-center' style='background-color:black;color:white;font-weight:bold;font-size:12px;border:none'>Garant</th>
            <th class='text-center' style='background-color:black;color:white;font-weight:bold;font-size:12px;border:none'>Precio U.</th>
            <th class='text-center' style='background-color:black;color:white;font-weight:bold;font-size:12px;border:none'>Total</th>
        </tr>
    </thead>
    <tbody>

    {$htmlTd}
    {$htmlFlete}
    {$htmlAumentoPorcentaje}


    </tbody>
   
</table>






<div style='border-top:4px solid black;border-bottom:4px solid black;margin-top:1rem'>
        <div style='background-color: #FFF;text-align: center;position: relative;z-index: 9999;width: 130px;margin: 10px 0 0 120px;font-weight:bold' id='why'>
            TOTAL SOLES
        </div>
        <div style='border: 3px solid;border-radius: 10px 10px 10px 10px;position: relative;margin: -10px 0 0 80px;width: 200px' id='large-div-text'>
                <p style='color:red;font-weight:bold;padding: 0px 0 0 55px'>S/. <span style='color:red;font-weight:bold'>{$totalCompraDol}</span></p>
        </div>
        <div style='background-color: #FFF;text-align: center;position: relative;z-index: 9999;width: 130px;margin: -70px 0 0 420px;font-weight:bold' id='why'>
            TOTAL DOLARES
        </div>
        <div style='border: 3px solid;border-radius: 10px 10px 10px 10px;position: relative;margin: -10px 0 0 380px;width: 210px' id='large-div-text'>
                <p style='color:red;font-weight:bold;padding: 0px 0 0 55px'>US$ <span style='color:red;font-weight:bold'>{$total}</span></p>
        </div>
        <div class='text-center mt-3 mb-3'>
            <span style=font-weight:bold>* LOS PRECIOS INCLUYEN I.G.V</span>        
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
