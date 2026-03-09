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
    $sql = "SELECT * FROM cotizaciones WHERE id ='{$idPedido}'";

    $data_pedido = $productoDao->exeSQL($sql)->fetch_assoc();

    $nombre = '';
    $ndoc = '';
    $correo = '';
    $direccion = '';
    $celular = '';
    $tipopago = '';
    $tipoenvio = '';
    $fecha = '';

    $nombre = $data_pedido['nombres'];
    $ndoc = $data_pedido['dni_ruc'];
    $correo = $data_pedido['email'];
    $direccion = $data_pedido['direccion'];
    $celular = $data_pedido['telefono'];
    $tipoenvio = '';
    $tipopago = '';
    $fecha = $data_pedido['fecha_create'];
    $departamento = '';
    $pro_nombre = '';

    $dis_nombre = '';
    #if (is_null($data_pedido['dis_nombre'])) {
    #    $dis_nombre = $data_pedido['distrito_opcional'];
    #} else {
    #    $dis_nombre = $data_pedido['dis_nombre'];
    #}


    $sql = "select pd.*,p.nombre,prod_cod 
                    from cotizaciones_items as pd join producto p on p.prod_id = pd.idproducto
                        where pd.idcotizacion='{$idPedido}'";


    $lista_ped = $productoDao->exeSQL($sql);

    $mpdf = new \Mpdf\Mpdf([
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
        $total_lis += $row_pd['precio'] * $row_pd['cantidad'];
        $precio = number_format($row_pd['precio'], 2, '.', ',');
        $importe = number_format($row_pd['precio'] * $row_pd['cantidad'], 2, '.', ',');
        $total = number_format($total_lis, 2, ".", ",");
        $totalSoles = number_format($total_lis * $tc, 2, ".", ",");
        $htmlTd .= "<tr style='$bg'>
            <td class='text-center' style='$bg font-size:12px;padding:5px'> {$row_pd['cantidad']} </td>       
            <td style='$bg font-size:12px;padding:5px'> {$row_pd['nombre']} </td>
            <td class='text-center' style='$bg font-size:12px;padding:5px'> 12 meses </td>
            <td class='text-center' style='$bg font-size:12px;padding:5px'> {$precio} </td>
            <td class='text-center' style='$bg font-size:12px;padding:5px'> {$importe} </td>
        </tr>";

    }

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
                        <th class='text-center' style='background-color:#18368E;color:white;font-weight:bold;font-size:12px;border:none'>#</th>
                        <th class='text-center' style='background-color:#18368E;color:white;font-weight:bold;font-size:12px;border:none'>Producto</th>
                        <th class='text-center' style='background-color:black;color:white;font-weight:bold;font-size:12px;border:none'>Garant</th>
                        <th class='text-center' style='background-color:black;color:white;font-weight:bold;font-size:12px;border:none'>Precio U.</th>
                        <th class='text-center' style='background-color:black;color:white;font-weight:bold;font-size:12px;border:none'>Total</th>
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
                        <p style='font-weight:bold;padding: 0px 0 0 55px'>US$ <span style='font-weight:bold'>{$data_pedido->}</span></p>
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

    #die();
    $mpdf->WriteHTML($stylesheet, 1);
    $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);
    $mpdf->Output();
