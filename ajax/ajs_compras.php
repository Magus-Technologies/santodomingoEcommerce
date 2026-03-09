<?php

use Openpay\Data\Openpay;

session_start();
require "../model/EnvioEmail.php";
require_once "../utils/Conexion.php";
require_once "../utils/Tools.php";
require_once "../dao/ProductoDao.php";
require_once "../extra/ProductosApi.php";
require_once "../utils/openpay/vendor/autoload.php";

$tools = new Tools();
$email = new EnvioEmail();

$montoCompra=$_POST['monto'];

$conexion = (new Conexion())->getConexion();
$frm = $_POST['frm'];
$car_list = json_decode($_POST['carr'], true);
//var_dump($_SESSION);
$tools = new Tools();
Openpay::setProductionMode(true);

$openpay = Openpay::getInstance('mpqeozsvp9heu93igzij', 'sk_ad9fb3e7fd5e4cf6ac985c8fa78d8e7f', 'PE');
//$openpay = Openpay::getInstance('mknezia3udhml9m9mnon', 'sk_296be43f8c864b7195d109519c24ad4b', 'PE');

//$monto = str_replace(".", "", $_POST['moneda'][0]['value']);

$respuesta=["res"=>false,"msg"=>""];

$monedaUsada = '';
if ($_POST['tipoMoneda']=='USD') {
    $monedaUsada = '$ ';
} else {
    $monedaUsada = 'S/ ';
}
$compra_id = '';
$totalTransacc =  $_POST['monto'] / 100;
$totalTransacc = number_format($totalTransacc, 2, ".", ",");

try{
    $chargeData = array(
        'method' => 'card',
        'device_session_id' => $_POST['deviceDataId'],
        'source_id' => $_POST['token'],
        'amount' => $_POST['monto'] ,
        'description' => "Venta de productos",
        'currency'=> $_POST['tipoMoneda'],
        'order_id' => date("Y").date("m").date("d").$tools->getToken(5),
        "customer"  => [
            "name"  => $_POST['nomc'],
            "last_name"  => $_POST['apec'],
            "email" => $frm[10]['value']
        ]
    );

//var_dump($chargeData);
    $charge = $openpay->charges->create($chargeData);
    if ($charge->status=='completed'){
        $respuesta['res']=true;

        $cargoDetalle = json_encode($charge);

        if ($_POST['tipoMoneda'] == 'USD') {
            $monedaUsar = 2;
        } else {
            $monedaUsar = 1;
        }
        $nomClie=$_POST['nomc'].' '.$_POST['apec'];
        if ($frm[8]['value'] !== '') {
            $distritoId = $frm[7]['value'];
            $getProvincia = $conexion->query("SELECT * FROM sys_dir_provincia WHERE dep_codigo ='{$frm[5]['value']}' AND pro_cod ='{$frm[6]['value']}'")->fetch_assoc();


            $sql = "INSERT INTO compras set id_usuario='{$_SESSION['usuario']}',fecha=now(),
    nombre='$nomClie',nun_doc='{$frm[2]['value']}',celular='{$frm[4]['value']}',
    email='{$frm[10]['value']}',notas='nota',estado=1,departamento_id ='{$frm[5]['value']}',provincia_id='{$getProvincia['pro_id']}',
    distrito_id =$distritoId, direccion='{$frm[3]['value']}',tipo_pago =4,tipo_envio ={$_POST['forpago']},distrito_opcional ='{$frm[9]['value']}',moneda_id='$monedaUsar',detalle_pago ='$cargoDetalle',costo_flete={$_POST['flete']} ";
        } else {
            $sql = "INSERT INTO compras set id_usuario='{$_SESSION['usuario']}',fecha=now(),
    nombre='$nomClie',nun_doc='{$frm[2]['value']}',celular='{$frm[4]['value']}',
    email='{$frm[10]['value']}',notas='nota',estado=1,departamento_id ='{$frm[5]['value']}',provincia_id='{$getProvincia['pro_id']}',
    distrito_id =null, direccion='{$frm[3]['value']}',tipo_pago =4,tipo_envio ={$_POST['forpago']},distrito_opcional ='{$frm[9]['value']}',moneda_id='$monedaUsar',detalle_pago ='$cargoDetalle',costo_flete={$_POST['flete']} ";
        }

        if ($conexion->query($sql)) {
            $compra_id = $conexion->insert_id;

            /*  $respuesta['compra'] = $compra_id; */


            foreach ($car_list as $car) {

                $sql2 = "INSERT INTO compras_detalles set id_compra='$compra_id',id_producto='{$car['prod']}',
            cantidad='{$car['cantidad']}',precio='{$car['precio']}',estado=1";

                if ($conexion->query($sql2)) {
                    $respuesta["res"] = true;
                } else {
                    $respuesta["msg"] = 'Ocurrio un error';
                }
            }
            $_SESSION['emaail'] = $frm[11]['value'];
            $sql = "DELETE FROM carrito_compra where  usuario_id='{$_SESSION['usuario']}'";
            $conexion->query($sql);
        }





    }else{
        $respuesta["msg"]=$charge->status;
    }
}catch (Exception $e){
    $respuesta["msg"]=$e->getMessage();

}

if (isset($_SESSION['emaail']) &&  $respuesta["res"]) {
    /*  echo "avisar"; */

    function avisarCliente($correoSus, $monedaUsada, $totalTransacc, $basehost)
    {
        /* echo "avisar CLIENTE"; */
        return '
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <title>email</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <style type="">
    .btn.btn-green {
      background: #ff324d;
      border-color: #c12336;
      color: #ffffff;
      margin: 0 28px;
      border-radius: 50px;
      font-size: 16px;
      padding: 8px 35px;
      line-height: 1.8em;
      cursor: pointer;
    }
    .btn.btn-green {
      background: #ff324d;
      border-color: #c12336;
      color: #ffffff;
      margin: 0 28px;
    }
    .btn.btn-rounded {
      border-radius: 50px;
    }
    .btn.btn-large {
      font-size: 16px;
      padding: 8px 35px;
      line-height: 1.8em;
    }
    .btn {
      -webkit-appearance: initial;
      overflow: hidden;
      position: -webkit-sticky;
      position: sticky;
      z-index: 2;
      display: inline-block;
      font-size: 16px;
      border: 2px solid transparent;
      letter-spacing: .5px;
      line-height: inherit;
      border-radius: 0;
      text-transform: capitalize;
      width: auto;
      font-family: "Roboto", sans-serif;
      font-weight: bold;
      -webkit-transition: all .5s ease;
      -o-transition: all .5s ease !important;
      transition: all .5s ease !important;
    }
    .btn {
      display: inline-block;
      font-weight: 400;
      color: #212529;
      text-align: center;
      vertical-align: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
      background-color: transparent;
      border: 1px solid transparent;
      padding: .375rem .75rem;
      font-size: 1rem;
      line-height: 1.5;
      border-radius: .25rem;
      transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    }
  </style>
</head>
<body>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
  <tr>
    <td style="font-size: 0; line-height: 0;" height="10">&nbsp;</td>
  </tr>
  <td align="center" bgcolor="#000000" style="padding: 40px 0 30px 0;">
    <img src="https://xn--viasantodomingo-zqb.com/public_html/public/cymw.png"
         alt="Creating Email Magic" width="300" style="display: block;"/>
  </td>
  <tr>
    <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
      <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
          <td style="text-align: center; color: black">
            <h2><strong>Te saluda VIÑASANTODOMINGO</strong></h2>
          </td>
        </tr>
        <tr>
          <td style="font-size: 0; line-height: 0;" height="10">&nbsp;</td>
        </tr>
        <tr>
          <td style=" color: black">
        
          </td>
        </tr>
        <tr>
          <td style="padding: 20px 0 30px 0; color: black">
          Hola  ' . $correoSus . ' te saluda VIÑASANTODOMINGO, tu compra se esta procesando <br><br>
          </td>
        </tr>
        <tr>
            <td style="text-align: center; color: black">
                 <h2><strong>Total pagado ' . $monedaUsada . ' ' . $totalTransacc . '</strong></h2>
            </td>
        </tr>
        <tr>
            <td style="padding: 20px 0 30px 0; color: black">
                Para ver el detalle de su pedido haga click en el botón<br><br>
            </td>
      </tr>
        <tr>
            <td style="text-align: center;color: #ffffff">
                <a href="' . $basehost . '"
                class="btn btn-green">Ver detalle de compra</a>
            </td>
      </tr>
        <tr>
          <td style="padding: 20px 0 30px 0; color: black">
            <br><br><br>
          </td>
        </tr>
      
      </table> 
    </td>
  </tr>
  <tr>
    <td bgcolor="#ff324d" style="padding: 30px 30px 30px 30px;">
      <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
          <td style="color: white" width="75%">
            &reg; VIÑASANTODOMINGO <br/>
            Compra en nuestra tienda.
          </td>
          <td align="right">
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>
    ';
    }


    if (isset($_SESSION['email'])) {
        //$_SESSION['emaail']='1994.brunoalva@gmail.com';
        ob_start();
        $ressss = $email->de(USER_SMTP, "VIÑASANTODOMINGO")
            ->addEmail($_SESSION['email'], "VIÑASANTODOMINGO")
            ->setasunto("Compra Cliente")
            ->cuerpo(avisarCliente($_SESSION['emaail'], $monedaUsada, $montoCompra, 'http://localhost/public_html/CYM/lista_compras_cliente.php/' . $compra_id))
            /*      ->cuerpo(avisarCliente($_SESSION['emaail'], $monedaUsada, $totalTransacc, 'http://localhost/compuvision2/CYM/lista_compras_cliente.php/' . $compra_id)) */
            ->enviar();
        ob_end_clean();
    }


    function avisarEmpresa($correoSus)
    {
        /*   echo "avisar EMPRESA"; */
        return '
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <title>email</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <style type="">
    .btn.btn-green {
      background: #ff324d;
      border-color: #c12336;
      color: #ffffff;
      margin: 0 28px;
      border-radius: 50px;
      font-size: 16px;
      padding: 8px 35px;
      line-height: 1.8em;
      cursor: pointer;
    }
    .btn.btn-green {
      background: #ff324d;
      border-color: #c12336;
      color: #ffffff;
      margin: 0 28px;
    }
    .btn.btn-rounded {
      border-radius: 50px;
    }
    .btn.btn-large {
      font-size: 16px;
      padding: 8px 35px;
      line-height: 1.8em;
    }
    .btn {
      -webkit-appearance: initial;
      overflow: hidden;
      position: -webkit-sticky;
      position: sticky;
      z-index: 2;
      display: inline-block;
      font-size: 16px;
      border: 2px solid transparent;
      letter-spacing: .5px;
      line-height: inherit;
      border-radius: 0;
      text-transform: capitalize;
      width: auto;
      font-family: "Roboto", sans-serif;
      font-weight: bold;
      -webkit-transition: all .5s ease;
      -o-transition: all .5s ease !important;
      transition: all .5s ease !important;
    }
    .btn {
      display: inline-block;
      font-weight: 400;
      color: #212529;
      text-align: center;
      vertical-align: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
      background-color: transparent;
      border: 1px solid transparent;
      padding: .375rem .75rem;
      font-size: 1rem;
      line-height: 1.5;
      border-radius: .25rem;
      transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    }
  </style>
</head>
<body>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
  <tr>
    <td style="font-size: 0; line-height: 0;" height="10">&nbsp;</td>
  </tr>
  <td align="center" bgcolor="#000000" style="padding: 40px 0 30px 0;">
    <img src="https://viñasantodomingo.com/public_html/public/cymw.png"
         alt="Creating Email Magic" width="300" style="display: block;"/>
  </td>
  <tr>
    <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
      <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
          <td style="text-align: center; color: black">
            <h2><strong>Te saluda VIÑASANTODOMINGO</strong></h2>
          </td>
        </tr>
        <tr>
          <td style="font-size: 0; line-height: 0;" height="10">&nbsp;</td>
        </tr>
        <tr>
          <td style=" color: black">
        
          </td>
        </tr>
        <tr>
          <td style="padding: 20px 0 30px 0; color: black">
         El usuario  ' . $correoSus . ' ha realizado una compra<br><br>
          </td>
        </tr>
        <tr>
         
        </tr>
        <tr>
          <td style="padding: 20px 0 30px 0; color: black">
            <br><br><br>
          </td>
        </tr>
      
      </table> 
    </td>
  </tr>
  <tr>
    <td bgcolor="#ff324d" style="padding: 30px 30px 30px 30px;">
      <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
          <td style="color: white" width="75%">
            &reg; VIÑASANTODOMINGO <br/>
            Compra en nuestra tienda.
          </td>
          <td align="right">
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>
    ';
    }


    if (isset($_SESSION['email'])) {
        ob_start();
        $ressss = $email->de(USER_SMTP, "VIÑASANTODOMINGO")
            ->addEmail("admin@viñasantodomingo.com", "VIÑASANTODOMINGO")
            ->setasunto("Compra Cliente")
            ->cuerpo(avisarEmpresa($_SESSION['email']))
            ->enviar();

        $ressss = $email->de(USER_SMTP, "VIÑASANTODOMINGO")
            ->addEmail("admin@viñasantodomingo.com", "VIÑASANTODOMINGO")
            ->setasunto("Compra Cliente")
            ->cuerpo(avisarEmpresa($_SESSION['email']))
            ->enviar();
        ob_end_clean();
    }
}


 echo json_encode($respuesta);

die();

include_once  '../culqi/Requests/library/Requests.php';
Requests::register_autoloader();
require_once '../culqi/culqi-php/lib/culqi.php';
$conexion = (new Conexion())->getConexion();
$tools = new Tools();
$email = new EnvioEmail();


/* $respuesta○['double'] = $_POST['totalTransac']; */
/* echo json_encode($respuesta○);
die(); */
$car_list = json_decode($_POST['carr'], true);
$respuesta["res"] = false;
$query['res'] = false;
$frm = $_POST['frm'];
$compra_id = '';
/* echo json_encode($frm);
die(); */
if (!empty($car_list)) {
    $culqi = new Culqi\Culqi(array('api_key' => 'sk_live_nZhdS5K9fo3uSRfW'));
    /*  $culqi = new Culqi\Culqi(array('api_key' => 'sk_test_bkfP7Z285iAEdm4W')); */

    $monto = str_replace(".", "", $_POST['moneda'][0]['value']);



    $tarjetApellido = '';
    $tarjetaNombre = '';
    if ($_POST['apellidoClienteTarjeta'] !== '') {
        $tarjetApellido = $_POST['apellidoClienteTarjeta'];
    } else {
        $tarjetApellido = $frm[3]['value'];
    }

    if ($_POST['nombreTarjeta'] !== '') {
        $tarjetaNombre = $_POST['nombreTarjeta'];
    } else {
        $tarjetaNombre = $frm[3]['value'];
    }
    try {
        $charge = $culqi->Charges->create(
            array(
                "amount" => $monto,
                "capture" => true,
                "currency_code" => $_POST['tipoMoneda'],
                "description" => "Venta de productos",
                "email" => $frm[11]['value'],
                "installments" => 0,
                "antifraud_details" => array(
                    "address" => $frm[4]['value'],
                    "address_city" => "PERU",
                    "country_code" => "PE",
                    "first_name" => $tarjetaNombre,
                    "last_name" =>  $tarjetApellido,
                    "phone_number" => $frm[5]['value'],
                ),
                "source_id" => $_POST['token']
            )
        );

        $cargoDetalle = json_encode($charge);

        if ($_POST['tipoMoneda'] == 'USD') {
            $monedaUsar = 2;
        } else {
            $monedaUsar = 1;
        }

        /*   $frm = json_decode($_POST['frm'], true); */


        /*  $respuesta['pos'] = $_POST; */
        if ($frm[8]['value'] !== '') {
            $distritoId = $frm[8]['value'];
            $getProvincia = $conexion->query("SELECT * FROM sys_dir_provincia WHERE dep_codigo ='{$frm[6]['value']}' AND pro_cod ='{$frm[7]['value']}'")->fetch_assoc();

            $sql = "INSERT INTO compras set id_usuario='{$_SESSION['usuario']}',fecha=now(),
    nombre='{$frm[3]['value']}',nun_doc='{$frm[2]['value']}',celular='{$frm[5]['value']}',
    email='{$_SESSION['email']}',notas='nota',estado=1,departamento_id ='{$frm[6]['value']}',provincia_id='{$getProvincia['pro_id']}',
    distrito_id =$distritoId, direccion='{$frm[4]['value']}',tipo_pago =4,tipo_envio ={$frm[9]['value']},distrito_opcional ='{$frm[9]['value']}',moneda_id='$monedaUsar',detalle_pago ='$cargoDetalle',costo_flete={$_POST['flete']} ";
        } else {
            $sql = "INSERT INTO compras set id_usuario='{$_SESSION['usuario']}',fecha=now(),
    nombre='{$frm[3]['value']}',nun_doc='{$frm[2]['value']}',celular='{$frm[5]['value']}',
    email='{$_SESSION['email']}',notas='nota',estado=1,departamento_id ='{$frm[6]['value']}',provincia_id='{$getProvincia['pro_id']}',
    distrito_id =null, direccion='{$frm[4]['value']}',tipo_pago =4,tipo_envio ={$frm[9]['value']},distrito_opcional ='{$frm[9]['value']}',moneda_id='$monedaUsar',detalle_pago ='$cargoDetalle',costo_flete={$_POST['flete']} ";
        }


        /*  $respuesta['query'] = $sql; */
        if ($conexion->query($sql)) {
            $compra_id = $conexion->insert_id;

            /*  $respuesta['compra'] = $compra_id; */


            foreach ($car_list as $car) {

                $sql2 = "INSERT INTO compras_detalles set id_compra='$compra_id',id_producto='{$car['prod']}',
            cantidad='{$car['cantidad']}',precio='{$car['precio']}',estado=1";

                if ($conexion->query($sql2)) {
                    $respuesta["res"] = true;
                } else {
                    $respuesta["msg"] = 'Ocurrio un error';
                }
            }
            $_SESSION['emaail'] = $frm[11]['value'];
            $sql = "DELETE FROM carrito_compra where  usuario_id='{$_SESSION['usuario']}'";
            $conexion->query($sql);
        }
    } catch (Exception $e) {
        $objerr = json_decode($e->getMessage(), true);
        //var_dump($objerr);
        /*  $respuesta["res"] = false; */
        $respuesta["msg"] = $objerr['merchant_message'];
    }
}

$monedaUsada = '';
if ($_POST['monedaUsada']) {
    $monedaUsada = '$ ';
} else {
    $monedaUsada = 'S/ ';
}
$totalTransacc =  $_POST['totalTransac'] / 100;
$totalTransacc = number_format($totalTransacc, 2, ".", ",");
/* 
$respuesta○['format'] = $totalTransacc;
$respuesta○['noFor'] = $_POST['totalTransac'];
$totalTransacc =  number_format($_POST['totalTransac'], 2, ".", ","); */
/* var_dump($_SESSION); */

/* var_dump($query['res'] );
die(); */
if (isset($_SESSION['emaail']) &&  $respuesta["res"]) {
    /*  echo "avisar"; */

    function avisarCliente($correoSus, $monedaUsada, $totalTransacc, $basehost)
    {
        /* echo "avisar CLIENTE"; */
        return '
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <title>email</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <style type="">
    .btn.btn-green {
      background: #ff324d;
      border-color: #c12336;
      color: #ffffff;
      margin: 0 28px;
      border-radius: 50px;
      font-size: 16px;
      padding: 8px 35px;
      line-height: 1.8em;
      cursor: pointer;
    }
    .btn.btn-green {
      background: #ff324d;
      border-color: #c12336;
      color: #ffffff;
      margin: 0 28px;
    }
    .btn.btn-rounded {
      border-radius: 50px;
    }
    .btn.btn-large {
      font-size: 16px;
      padding: 8px 35px;
      line-height: 1.8em;
    }
    .btn {
      -webkit-appearance: initial;
      overflow: hidden;
      position: -webkit-sticky;
      position: sticky;
      z-index: 2;
      display: inline-block;
      font-size: 16px;
      border: 2px solid transparent;
      letter-spacing: .5px;
      line-height: inherit;
      border-radius: 0;
      text-transform: capitalize;
      width: auto;
      font-family: "Roboto", sans-serif;
      font-weight: bold;
      -webkit-transition: all .5s ease;
      -o-transition: all .5s ease !important;
      transition: all .5s ease !important;
    }
    .btn {
      display: inline-block;
      font-weight: 400;
      color: #212529;
      text-align: center;
      vertical-align: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
      background-color: transparent;
      border: 1px solid transparent;
      padding: .375rem .75rem;
      font-size: 1rem;
      line-height: 1.5;
      border-radius: .25rem;
      transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    }
  </style>
</head>
<body>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
  <tr>
    <td style="font-size: 0; line-height: 0;" height="10">&nbsp;</td>
  </tr>
  <td align="center" bgcolor="#000000" style="padding: 40px 0 30px 0;">
    <img src="https://viñasantodomingo/public_html/public/cymw.png"
         alt="Creating Email Magic" width="300" style="display: block;"/>
  </td>
  <tr>
    <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
      <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
          <td style="text-align: center; color: black">
            <h2><strong>Te saluda VIÑASANTODOMINGO</strong></h2>
          </td>
        </tr>
        <tr>
          <td style="font-size: 0; line-height: 0;" height="10">&nbsp;</td>
        </tr>
        <tr>
          <td style=" color: black">
        
          </td>
        </tr>
        <tr>
          <td style="padding: 20px 0 30px 0; color: black">
          Hola  ' . $correoSus . ' te saluda VIÑASANTODOMINGO, tu compra se esta procesando <br><br>
          </td>
        </tr>
        <tr>
            <td style="text-align: center; color: black">
                 <h2><strong>Total pagado ' . $monedaUsada . ' ' . $totalTransacc . '</strong></h2>
            </td>
        </tr>
        <tr>
            <td style="padding: 20px 0 30px 0; color: black">
                Para ver el detalle de su pedido haga click en el botón<br><br>
            </td>
      </tr>
        <tr>
            <td style="text-align: center;color: #ffffff">
                <a href="' . $basehost . '"
                class="btn btn-green">Ver detalle de compra</a>
            </td>
      </tr>
        <tr>
          <td style="padding: 20px 0 30px 0; color: black">
            <br><br><br>
          </td>
        </tr>
      
      </table> 
    </td>
  </tr>
  <tr>
    <td bgcolor="#ff324d" style="padding: 30px 30px 30px 30px;">
      <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
          <td style="color: white" width="75%">
            &reg; VIÑASANTODOMINGO <br/>
            Compra en nuestra tienda.
          </td>
          <td align="right">
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>
    ';
    }


    if (isset($_SESSION['emaail'])) {
        ob_start();
        $ressss = $email->de(USER_SMTP, "VIÑASANTODOMINGO")
            ->addEmail($_SESSION['emaail'], "VIÑASANTODOMINGO")
            ->setasunto("Compra Cliente")
            ->cuerpo(avisarCliente($_SESSION['emaail'], $monedaUsada, $totalTransacc, 'https://viñasantodomingo.com/public_html/CYM/lista_compras_cliente.php/' . $compra_id))
            /*      ->cuerpo(avisarCliente($_SESSION['emaail'], $monedaUsada, $totalTransacc, 'http://localhost/compuvision2/CYM/lista_compras_cliente.php/' . $compra_id)) */
            ->enviar();
        ob_end_clean();
    }


    function avisarEmpresa($correoSus)
    {
        /*   echo "avisar EMPRESA"; */
        return '
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <title>email</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <style type="">
    .btn.btn-green {
      background: #ff324d;
      border-color: #c12336;
      color: #ffffff;
      margin: 0 28px;
      border-radius: 50px;
      font-size: 16px;
      padding: 8px 35px;
      line-height: 1.8em;
      cursor: pointer;
    }
    .btn.btn-green {
      background: #ff324d;
      border-color: #c12336;
      color: #ffffff;
      margin: 0 28px;
    }
    .btn.btn-rounded {
      border-radius: 50px;
    }
    .btn.btn-large {
      font-size: 16px;
      padding: 8px 35px;
      line-height: 1.8em;
    }
    .btn {
      -webkit-appearance: initial;
      overflow: hidden;
      position: -webkit-sticky;
      position: sticky;
      z-index: 2;
      display: inline-block;
      font-size: 16px;
      border: 2px solid transparent;
      letter-spacing: .5px;
      line-height: inherit;
      border-radius: 0;
      text-transform: capitalize;
      width: auto;
      font-family: "Roboto", sans-serif;
      font-weight: bold;
      -webkit-transition: all .5s ease;
      -o-transition: all .5s ease !important;
      transition: all .5s ease !important;
    }
    .btn {
      display: inline-block;
      font-weight: 400;
      color: #212529;
      text-align: center;
      vertical-align: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
      background-color: transparent;
      border: 1px solid transparent;
      padding: .375rem .75rem;
      font-size: 1rem;
      line-height: 1.5;
      border-radius: .25rem;
      transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    }
  </style>
</head>
<body>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
  <tr>
    <td style="font-size: 0; line-height: 0;" height="10">&nbsp;</td>
  </tr>
  <td align="center" bgcolor="#000000" style="padding: 40px 0 30px 0;">
    <img src="https://viñasantodomingo.com/public_html/public/cymw.png"
         alt="Creating Email Magic" width="300" style="display: block;"/>
  </td>
  <tr>
    <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
      <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
          <td style="text-align: center; color: black">
            <h2><strong>Te saluda VIÑASANTODOMINGO</strong></h2>
          </td>
        </tr>
        <tr>
          <td style="font-size: 0; line-height: 0;" height="10">&nbsp;</td>
        </tr>
        <tr>
          <td style=" color: black">
        
          </td>
        </tr>
        <tr>
          <td style="padding: 20px 0 30px 0; color: black">
         El usuario  ' . $correoSus . ' ha realizado una compra<br><br>
          </td>
        </tr>
        <tr>
         
        </tr>
        <tr>
          <td style="padding: 20px 0 30px 0; color: black">
            <br><br><br>
          </td>
        </tr>
      
      </table> 
    </td>
  </tr>
  <tr>
    <td bgcolor="#ff324d" style="padding: 30px 30px 30px 30px;">
      <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
          <td style="color: white" width="75%">
            &reg; VIÑASANTODOMINGO <br/>
            Compra en nuestra tienda.
          </td>
          <td align="right">
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>
    ';
    }


    if (isset($_SESSION['emaail'])) {
        ob_start();
        $ressss = $email->de(USER_SMTP, "VIÑASANTODOMINGO")
            ->addEmail("admin@viñasantodomingo.com", "VIÑASANTODOMINGO")
            /*   ->addEmail("chrisandre23@gmail.com", "COMPU & VISION") */
            ->setasunto("Compra Cliente")
            ->cuerpo(avisarEmpresa($_SESSION['emaail']))
            ->enviar();

        $ressss = $email->de(USER_SMTP, "VIÑASANTODOMINGO")
            ->addEmail("admin@viñasantodomingo.com", "VIÑASANTODOMINGO")
            /*  ->addEmail("chrisandre23@gmail.com", "COMPU & VISION") */
            ->setasunto("Compra Cliente")
            ->cuerpo(avisarEmpresa($_SESSION['emaail']))
            ->enviar();
        ob_end_clean();
    }
}

echo json_encode($respuesta);

/* $car_list = json_decode($_POST['carr'], true);
if (!empty($car_list)) {
   
    $respuesta['pos'] = $_POST;
    if ($_POST['value'] !== '') {
        $distritoId = $_POST['value'];
        $getProvincia = $conexion->query("SELECT * FROM sys_dir_provincia WHERE dep_codigo ='{$_POST['value']}' AND pro_cod ='{$_POST['value']}'")->fetch_assoc();
        $sql = "insert into pedidos set id_usuario='{$_SESSION['usuario']}',fecha=now(),
        nombre='{$_POST['nombre']}',nun_doc='{$_POST['ndoc']}',celular='{$_POST['phone']}',
        email='{$_SESSION['email']}',notas='nota',estado=1,departamento_id ='{$_POST['value']}',provincia_id='{$getProvincia['pro_id']}',
        distrito_id =$distritoId, direccion='{$_POST['direccion']}',tipo_pago ='{$_POST['formaPagoAgregar']}',tipo_envio ='{$_POST['formEnvioAgregar']}',distrito_opcional ='{$_POST['distritoOpcionalAgregar']}'";
    } else {
        $sql = "INSERT INTO pedidos set id_usuario='{$_SESSION['usuario']}',fecha=now(),
        nombre='{$_POST['nombre']}',nun_doc='{$_POST['ndoc']}',celular='{$_POST['phone']}',
        email='{$_SESSION['email']}',notas='nota',estado=1,departamento_id ='{$_POST['value']}',provincia_id='{$getProvincia['pro_id']}',
        distrito_id =null, direccion='{$_POST['direccion']}',tipo_pago ='{$_POST['formaPagoAgregar']}',tipo_envio ='{$_POST['formEnvioAgregar']}',distrito_opcional ='{$_POST['distritoOpcionalAgregar']}'";
    }


    $respuesta['query'] = $sql;
    if ($conexion->query($sql)) {
        $pedido_id = $conexion->insert_id;
        $respuesta['res'] = true;
        $respuesta['pedido'] = $pedido_id;


        foreach ($car_list as $car) {

            $sql2 = "insert into pedido_detalles set id_pedido='$pedido_id',id_producto='{$car['prod']}',
                cantidad='{$car['cantidad']}',precio='{$car['precio']}',estado=1";
            $conexion->query($sql2);
        }
        $sql = "DELETE FROM carrito_compra where  usuario_id='{$_SESSION['usuario']}'";
        $conexion->query($sql);
    }
} */
