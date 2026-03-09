<?php

/* use Tools;
use Conexion;
use ProductosApi;
 */
session_start();

require_once "../model/EnvioEmail.php";
require_once "../utils/Conexion.php";
require_once "../utils/Tools.php";
require_once "../dao/ProductoDao.php";
require_once "../extra/ProductosApi.php";

$conexion = (new Conexion())->getConexion();
$tools = new Tools();
$email = new EnvioEmail();

$tipo = $_POST['tipo'];

$respuesta = ["res" => false];

switch ($tipo) {
    case 'reset-pass-user':
        $user = base64_decode(base64_decode($_POST['user']));
        $clave = $_POST['clave'];
        $token = $_POST['token'];

        $sql = "update usuarios set clave='$clave', token_reset='' where use_id='$user' and token_reset='$token'";
        if ($conexion->query($sql)) {
            $respuesta['res'] = true;
        }
        break;
    case 'udt-pedido-estd':
        $sql = "update pedidos set estado='{$_POST['estado']}',  usuario_cambio_estado = '{$_SESSION['usuario']}' where pedido_id='{$_POST['pedido']}'";
        $conexion->query($sql);
        break;
    case 'udt-compra-estd':
        $sql = "UPDATE compras set estado='{$_POST['estado']}',  usuario_cambio_estado = '{$_SESSION['usuario']}' where compra_id='{$_POST['pedido']}'";
        $conexion->query($sql);
        break;
    case 'del-pedido-nrl':

        $sql = "select * from pedidos  where pedido_id='{$_POST['pedido']}'";
        if ($row = $conexion->query($sql)->fetch_assoc()) {
            $ruta = "../public/data/files/" . $row['id_usuario'] . "/" . $row['archivo'];
            unlink($ruta);
        }
        $sql = "update pedidos set archivo='' where pedido_id='{$_POST['pedido']}'";
        if ($conexion->query($sql)) {
            $respuesta['res'] = true;
        }
        break;
    case 'data-pdds-clien':
        $sql = "select ped.*, u.nombres from pedidos as ped 
    join usuarios u on u.use_id = ped.id_usuario
order by ped.pedido_id desc ";
        $result = $conexion->query($sql);
        foreach ($result as $ped) {
        }
        break;
    case 'data-pdds-user':
        $productosApi = new ProductosApi();
        $sql = "select * from pedidos where pedido_id='{$_POST['pedido']}'";
        $result = $conexion->query($sql);
        if ($row = $result->fetch_assoc()) {
            $respuesta['res'] = true;
            $sql = "select pd.*, p.nombre,p.prod_cod from pedido_detalles as pd join producto p on p.prod_id = pd.id_producto where pd.id_pedido='{$_POST['pedido']}' ";
            $row["productos"] = [];
            $result_prod = $conexion->query($sql);
            foreach ($result_prod as $prodt) {
                $conRay = $productosApi->getDataProd($prodt['prod_cod']);
                $prodt['precio'] = $conRay['precio_venta'];
                $row["productos"][] = $prodt;
            }
            $respuesta['data'] = $row;
        }
        break;
    case 'lts-pdds-user':
        $sql = "select * from pedidos where id_usuario='{$_SESSION['usuario']}'";
        $result = $conexion->query($sql);
        $respuesta = [];
        foreach ($result as $item) {
            $item['fecha'] = $tools->formatoFechaVisual($item['fecha']);
            $respuesta[] = $item;
        }
        break;
    case 'lts-comp-user':
        $sql = "SELECT * from compras where id_usuario='{$_SESSION['usuario']}'";
        $result = $conexion->query($sql);
        $respuesta = [];
        foreach ($result as $item) {
            $item['fecha'] = $tools->formatoFechaVisual($item['fecha']);
            $respuesta[] = $item;
        }
        break;
       case 'prodce-prod':
        //$sql="DELETE FROM carrito_compra where  usuario_id='{$_SESSION['usuario']}'";
        //$conexion->query($sql);

        $car_list = json_decode($_POST['carr'], true);
        if (!empty($car_list)) {
            /* $respuesta['repo'] = $_POST['distritoAgregar']; */
            $respuesta['pos'] = $_POST;
            if ($_POST['distritoAgregar'] !== '') {
                $distritoId = $_POST['distritoAgregar'];
                $getProvincia = $conexion->query("SELECT * FROM sys_dir_provincia WHERE dep_codigo ='{$_POST['departamentoAgregar']}' AND pro_cod ='{$_POST['provinciaAgregar']}'")->fetch_assoc();
                $sql = "insert into pedidos set id_usuario='{$_SESSION['usuario']}',fecha=now(),
        nombre='{$_GET['nomc']}',nun_doc='{$_POST['ndoc']}',celular='{$_POST['phone']}',
        email='{$_SESSION['email']}',notas='{$_POST['nota']}',estado=1,departamento_id ='{$_POST['departamentoAgregar']}',provincia_id='{$getProvincia['pro_id']}',
        distrito_id =$distritoId, direccion='{$_POST['direccion']}',tipo_pago ='{$_POST['formaPagoAgregar']}',tipo_envio ='{$_POST['formEnvioAgregar']}',distrito_opcional =''";
            } /* else {
                $sql = "INSERT INTO pedidos set id_usuario='{$_SESSION['usuario']}',fecha=now(),
        nombre='{$_POST['nombre']}',nun_doc='{$_POST['ndoc']}',celular='{$_POST['phone']}',
        email='{$_SESSION['email']}',notas='nota',estado=1,departamento_id ='{$_POST['departamentoAgregar']}',provincia_id='{$getProvincia['pro_id']}',
        distrito_id =null, direccion='{$_POST['direccion']}',tipo_pago ='{$_POST['formaPagoAgregar']}',tipo_envio ='{$_POST['formEnvioAgregar']}',distrito_opcional ='{$_POST['distritoOpcionalAgregar']}'";
            } */


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
    <img src="https://viñasantodomingo.com/public_html/public/images/logo-white.png"
         alt="Creating Email Magic" width="300" style="display: block;"/>
  </td>
  <tr>
    <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
      <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
          <td style="text-align: center; color: black">
            <h2><strong>Te saluda ACEADVANCE</strong></h2>
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
          Hola  ' . $correoSus . ' te saluda ACEADVANCE, tu cotizacion se esta procesando <br><br>
          </td>
        </tr>
        <tr>
            <td style="text-align: center; color: black">
                 <h2><strong>Total ' . $monedaUsada . ' ' . $totalTransacc . '</strong></h2>
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
                class="btn btn-green">Ver detalle de la cotizacion</a>
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
    <td bgcolor="#FF00FE" style="padding: 30px 30px 30px 30px;">
      <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
          <td style="color: white" width="75%">
            &reg; ACEADVANCE. <br/>
            Los mejores en hardware.
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
                    $ressss = $email->de(USER_SMTP, "VIÑASANTODOMINGO")
                        ->addEmail($_SESSION['email'], "VIÑASANTODOMINGO")
                        ->setasunto("Compra Cliente")
                        ->cuerpo(avisarCliente($_SESSION['email'], "$", $_GET['total'], 'https://viñasantodomingo.com/public_html/CYM/lista_pedidos_cliente.php/' . $pedido_id))
                        ->enviar();


            }
        }        break;
    case "chg-pass-user":
        $sql = "UPDATE usuarios SET clave = '{$_POST['npss']}' WHERE use_id = '{$_SESSION['usuario']}';";
        if ($conexion->query($sql)) {
            $respuesta['res'] = true;
        }
        break;
    case "chg-name-user":
        $sql = "UPDATE usuarios SET nombres = '{$_POST['name']}' WHERE use_id = '{$_SESSION['usuario']}';";
        if ($conexion->query($sql)) {
            $respuesta['res'] = true;
        }
        break;
}

echo json_encode($respuesta);
