<?php
    session_start();

    require_once '../vendor/autoload.php';

    require "../utils/Tools.php";
    require "../dao/ProductoDao.php";
    require "../extra/ProductosApi.php";
    require_once "../extra/TasaCambioApi.php";

    $comprador = isset($_GET['comprador']) ? true : false;

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
    $data_pedido = (object)$data_pedido;


    $sql = "SELECT * FROM usuarios WHERE use_id ='{$data_pedido->idusuario}'";
    $usuario_vendedor = $productoDao->exeSQL($sql)->fetch_assoc();
    $vendedor_item = (object)$usuario_vendedor;


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

    $htmlTd_2 = "";
    $htmlTd = "";
    foreach ($lista_ped as $i => $row_pd) {
        $i++;
        $datos = (object)$row_pd;
        $datos->total_venta = $datos->otro_produc_total_venta + $datos->igv;
        $datos->mi_comision = $tools->money($datos->mi_comision);
        $datos->mi_comision_extra = $tools->money($datos->mi_comision_extra);
        $datos->mi_ganancia = $tools->money($datos->mi_ganancia);

        $datos->total_venta = $tools->money($datos->total_venta);
        $datos->produc_precio = $tools->money($datos->produc_precio);
        $datos->otro_produc_total_venta = $tools->money($datos->otro_produc_total_venta);
        $datos->igv = $tools->money($datos->igv);
        $datos->total_venta = $tools->money($datos->total_venta);

        $bg = $i % 2 == 0 ? 'background-color: #CCCCCC;' : '';
        $htmlTd .= "
            <tr style='$bg'>
                <td class='text-center' style='$bg font-size:12px;padding:5px'> {$i} </td>       
                <td style='$bg font-size:12px;padding:5px'> {$datos->nombre} </td>
                <td style='text-align: right;$bg font-size:12px;padding: 0 10px 0 0 !important'> {$datos->otro_produc_precio} </td>
                <td style='text-align: right;$bg font-size:12px;padding: 0 10px 0 0 !important'> {$datos->cantidad} </td>
                <td style='text-align: right;$bg font-size:12px;padding: 0 10px 0 0 !important'> {$datos->otro_produc_total_venta} </td>
                <td style='text-align: right;$bg font-size:12px;padding: 0 10px 0 0 !important'> {$datos->igv} </td>
                <td style='text-align: right;$bg font-size:12px;padding: 0 10px 0 0 !important'> {$datos->total_venta} </td>
            </tr>";

        $datos->nombre = $tools->roundtxt($datos->nombre, 20);

        $datos->produc_precio = $tools->money($datos->produc_precio);
        $datos->produc_total_venta = $tools->money($datos->produc_total_venta);
        $datos->igv = $tools->money($datos->igv);
        $datos->total_venta = $tools->money($datos->total_venta);

        $htmlTd_2 .= "
            <tr style='$bg'>
                <td class='text-center' style='$bg font-size:12px;padding:5px'> {$i} </td>       
                <td style='$bg font-size:12px;padding: 0 10px 0 0 !important'> {$datos->nombre} </td>
                <td style='text-align: right;$bg font-size:12px;padding: 0 10px 0 0 !important'> {$datos->produc_precio} </td>
                <td style='text-align: right;$bg font-size:12px;padding: 0 10px 0 0 !important'> {$datos->cantidad} </td>
                <td style='text-align: right;$bg font-size:12px;padding: 0 10px 0 0 !important'> {$datos->produc_total_venta} </td>
                <td style='text-align: right;$bg font-size:12px;padding: 0 10px 0 0 !important'> {$datos->mi_comision} </td>
                <td style='text-align: right;$bg font-size:12px;padding: 0 10px 0 0 !important'> {$datos->mi_comision_extra} </td>
                <td style='text-align: right;$bg font-size:12px;padding: 0 10px 0 0 !important'> {$datos->mi_ganancia} </td>
            </tr>";

    }


    $mpdf = new \Mpdf\Mpdf([
        'format' => 'A4',
        'margin_left' => 0,
        'margin_right' => 0,
        'margin_top' => 40,
        'margin_bottom' => 50,
        'margin_header' => 0,
        'margin_footer' => 0
    ]);

    $data_pedido->aplica_igv_opcion = $data_pedido->aplica_igv == 1 ? 'Si' : 'No';
    $data_pedido->igv_dtalle = $data_pedido->aplica_igv == 1 ? '* LOS PRECIOS INCLUYEN I.G.V' : '* LOS PRECIOS NO INCLUYEN I.G.V';
    $mpdf->SetHTMLHeader("<img style='width: 100%;' src='../public/fondo_pedidos.png'>", 'e', true);

    $mpdf->SetHTMLFooter("<img style='width: 2500px;height:150px' src='../public/footer_pedidos.png'>");

    $vendedor = "";

    $resumen_vendedor = "";

    if (isset($_SESSION['usuario']) && ($_SESSION['perfil'] == 'admin' || $_SESSION['perfil'] == 'usuarios digital') and $comprador == false):
        $resumen_vendedor = "
            <table class='table' style='margin-top:-15px'>
                <thead>
                    <tr>
                        <th class='text-center' style='background-color:#18368E;color:white;font-weight:bold;font-size:12px;border:none'>#</th>
                        <th class='text-center' style='background-color:#18368E;color:white;font-weight:bold;font-size:12px;border:none'>Producto</th>
                        <!--<th class='text-center' style='background-color:black;color:white;font-weight:bold;font-size:12px;border:none'>Garant</th>-->
                        <th class='text-center' style='background-color:black;color:white;font-weight:bold;font-size:12px;border:none'>Precio U.</th>
                        <th class='text-center' style='background-color:black;color:white;font-weight:bold;font-size:12px;border:none'>Cant..</th>
                        <th class='text-center' style='background-color:black;color:white;font-weight:bold;font-size:12px;border:none'>Total</th>
                        <th class='text-center' style='background-color:#18368E;color:white;font-weight:bold;font-size:12px;border:none'>Com. 0.05 %</th>
                        <th class='text-center' style='background-color:black;color:white;font-weight:bold;font-size:12px;border:none'>Com. Ext.</th>
                        <th class='text-center' style='background-color:black;color:white;font-weight:bold;font-size:12px;border:none'>Total Comision</th>
                    </tr>
                </thead>
                <tbody>
                {$htmlTd_2}
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan='3' class='text-right' style='font-weight:bold;font-size:12px;border:none'></td>
                        <td class='text-right' style='text-align:right !important;font-weight:bold;font-size:12px;border:none;padding-left: 35px'>$data_pedido->total_items</td>
                        <td class='text-right' style='text-align:right !important;font-weight:bold;font-size:12px;border:none;padding-left: 35px'>S/ $data_pedido->total_pagar</td>
                        <td class='text-right' style='text-align:right !important;font-weight:bold;font-size:12px;border:none;padding-left: 35px'>S/ $data_pedido->total_comisiones</td>
                        <td class='text-right' style='text-align:right !important;font-weight:bold;font-size:12px;border:none;padding-left: 35px'>S/ $data_pedido->total_comisiones_extra</td>
                        <td class='text-right' style='text-align:right !important;font-weight:bold;font-size:12px;border:none;padding-left: 45px'>
                                S/ $data_pedido->total_comisiones_ganancia
                        </td>
                    </tr>
                </tfoot>
            </table>
        ";


        $vendedor = "
            <tr>
                <td style='color:white;background:black;font-size:11px; text-transform: uppercase;padding:5px 0 5x 10px'>VENDEDOR: {$vendedor_item->nombres}</td>
                <td style='color:white;background:black;font-size:11px; text-transform: uppercase;padding:5px 0 5x 10px'>Email: {$vendedor_item->email}</td>
            </tr>
        ";
    endif;


    $html = " 
    <div style='padding: 0 50px'>
        <div style='margin-top:10px'>
            <div class='table-responsive-sm' style='width: 100%;margin-bottom: 10px'>
                <table class='table table-responsive' style='width: 100%;'>
                    <thead>
                        <tr>
                            <th style='background-color:#18368E;color:white;font-weight:bold;font-size:12px;border:none;text-align:left'>COTIZACION : $data_pedido->serie_cotizacion</th>
                        </tr>
                    </thead>
                    <tbody style>
                        <tr>
                            <td style='padding: 0 !important;'>
                                <!---->
                                <!---->
                                <table class='table table-responsive' style='width: 100%;'>
                                    <tbody style>
                                        $vendedor
                                        <tr>
                                            <td style='background-color:white;font-size:11px; text-transform: uppercase;padding:5px 0 5x 10px'>CLIENTE: {$data_pedido->nombres}</td>
                                            <td style='background-color:white;font-size:11px; text-transform: uppercase;padding:5px 0 5x 10px'>N. Doc: {$data_pedido->dni_ruc}</td>
                                        </tr>
                                        <tr>
                                            <td style='background-color:#CCCCCC;font-size:11px; text-transform: uppercase;padding:5px 0 5x 10px'>Email.: {$data_pedido->email}</td>
                                            <td style='background-color:#CCCCCC;font-size:11px; text-transform: uppercase;padding:5px 0 5x 10px'>Fecha: {$data_pedido->fecha_create}</td>
                                        </tr>
                                        <tr>
                                            <td style='background-color:white;font-size:11px; text-transform: uppercase;padding:5px 0 5x 10px'>Aplica IGV: {$data_pedido->aplica_igv_opcion}  </td>
                                            <td style='background-color:white;font-size:11px; text-transform: uppercase;padding:5px 0 5x 10px'>Celular: {$data_pedido->telefono}  </td>
                                        </tr>
                                        <tr>
                                            <td colspan='2' style='background-color:#CCCCCC;font-size:11px; text-transform: uppercase;padding:5px 0 5x 10px'>Direccion: {$data_pedido->direccion}  </td>
                                        </tr>
                                    </tbody>
                            
                                </table>
                                <!---->
                                <!---->
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <table class='table' style='margin-top:-15px'>
                <thead>
                    <tr>
                        <th class='text-center' style='background-color:#18368E;color:white;font-weight:bold;font-size:12px;border:none'>#</th>
                        <th class='text-center' style='background-color:#18368E;color:white;font-weight:bold;font-size:12px;border:none'>Producto</th>
                        <!--<th class='text-center' style='background-color:black;color:white;font-weight:bold;font-size:12px;border:none'>Garant</th>-->
                        <th class='text-center' style='background-color:black;color:white;font-weight:bold;font-size:12px;border:none'>Precio U.</th>
                        <th class='text-center' style='background-color:black;color:white;font-weight:bold;font-size:12px;border:none'>Cant..</th>
                        <th class='text-center' style='background-color:black;color:white;font-weight:bold;font-size:12px;border:none'>Total</th>
                        <th class='text-center' style='background-color:#18368E;color:white;font-weight:bold;font-size:12px;border:none'>IGV</th>
                        <th class='text-center' style='background-color:black;color:white;font-weight:bold;font-size:12px;border:none'>Importe</th>
                    </tr>
                </thead>
                <tbody>
                {$htmlTd}
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan='3' class='text-right' style='padding: 0 10px 0 0 !important;font-weight:bold;font-size:12px;border:none;'> RESUMEN</td>
                        <td style='text-align:right !important;padding: 0 10px 0 0 !important;font-weight:bold;font-size:12px;border:none'>$data_pedido->total_items</td>
                        <td style='text-align:right !important;padding: 0 10px 0 0  !important;font-weight:bold;font-size:12px;border:none'>S/ $data_pedido->total_pagar</td>
                        <td style='text-align:right !important;padding: 0 10px 0 0  !important;font-weight:bold;font-size:12px;border:none'>S/ $data_pedido->igv</td>
                        <td style='text-align:right !important;padding: 0 10px 0 0  !important;font-weight:bold;font-size:12px;border:none'>S/ $data_pedido->suma_pedido_soles</td>
                    </tr>
                </tfoot>
            </table>
            
            <!---->
            <!---->
            {$resumen_vendedor}
            <!---->
            <!---->
            
            
            <div style='margin-top:5rem;'>
                <div style='color:red;background-color: #FFF;text-align: center;position: relative;z-index: 9999;width: 130px;margin: 10px 0 0 120px;font-weight:bold' id='why'>
                    TOTAL DOLARES
                </div>
                <div style='border: 3px solid;border-radius: 10px 10px 10px 10px;position: relative;margin: -10px 0 0 80px;width: 200px' id='large-div-text'>
                        <p style='font-weight:bold;padding: 0px 0 0 55px'>US$ <span style='font-weight:bold'>{$data_pedido->suma_pedido_usd}</span></p>
                </div>
                <div style='color:red;background-color: #FFF;text-align: center;position: relative;z-index: 9999;width: 130px;margin: -70px 0 0 420px;font-weight:bold' id='why'>
                    TOTAL SOLES
                </div>
                <div style='border: 3px solid;border-radius: 10px 10px 10px 10px;position: relative;margin: -10px 0 0 380px;width: 210px' id='large-div-text'>
                        <p style='font-weight:bold;padding: 0px 0 0 55px'>S/. <span style='font-weight:bold'>{$data_pedido->suma_pedido_soles}</span></p>
                </div>
                <div class='text-center mt-3 mb-3'>
                    <span style='font-weight:bold; font-size: 9px !important;color:red;'>$data_pedido->igv_dtalle</span>        
                </div>
            </div>
        </div>
    </div>
";

    $stylesheet = '.table {
    border-collapse: collapse !important;
}
    .table tbody td,
    .table thead th {
        background-color: #fff !important;
    }
    .table tbody td,
    .table thead th {
        background-color: #fff !important;
    }.table {
        width: 100%;
        margin-bottom: 1rem;
        color: #212529;
    }
    .table tbody td,
    .table thead th {
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
    }
    table tfoot td {
        text-align: right !important;
        padding: 0px !important;
    }
    .text-center {
        text-align: center !important;
    }
    
    .mt-3,.my-3 {
        margin-top: 1rem !important;
    }.mb-3,
    .my-3 {
        margin-bottom: 1rem !important;
    }';

    #die();
    #die($html);
    $mpdf->WriteHTML($stylesheet, 1);
    $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);

    $nombre_archivo = "$data_pedido->serie_cotizacion.pdf";
    #die();
    header('Content-Type: application/pdf');
    header("Content-Disposition: attachment; filename=\"$data_pedido->serie_cotizacion\"");
    header('Cache-Control: private, max-age=0, must-revalidate');
    header('Pragma: public');
    $mpdf->Output();

