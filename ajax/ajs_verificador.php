<?php

require_once "../utils/Conexion.php";
require_once "../model/EnvioEmail.php";

$email = new EnvioEmail();


$resultado=["res"=>false, "msg"=>"Este Email ya fue registrado"];

$conexion = (new Conexion())->getConexion();

$sql="select * from usuarios where email='{$_POST['email']}'  ";

$result = $conexion->query($sql);
if ($row=$result->fetch_assoc()){

}else{
    $resultado["res"]=true;
    ob_start();
    $ressss = $email->de(USER_SMTP, "VIÑASANTODOMINGO")
        ->addEmail($_POST['email'], "VIÑASANTODOMINGO")
        ->setasunto("Verificacion de Email")
        ->cuerpo(avisarCliente($_POST['email'], $_POST['co']))
        /*      ->cuerpo(avisarCliente($_SESSION['emaail'], $monedaUsada, $totalTransacc, 'http://localhost/compuvision2/CYM/lista_compras_cliente.php/' . $compra_id)) */
        ->enviar();
    ob_end_clean();
}
echo  json_encode($resultado);


function avisarCliente($correoSus, $code )
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
  <td align="center"  style="padding: 40px 0 30px 0; color: white; background-color:#000;">
   	<h2><strong>Estas a un paso de tu registro </strong></h2> 
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
          Hola  ' . $correoSus . ', tu codigo de verificacion es la siguiente <br><br>
          </td>
        </tr>
        <tr>
            <td style="text-align: center; color: black">
                 <h2><strong>Codigo: ' .$code . '</strong></h2>
            </td>
        </tr>
        <tr>
             
      </tr>
  
      
      </table> 
    </td>
  </tr>
  <td align="center" style="padding: 40px 0 30px 0; color: black; background-color:#c2c2c2;">
   	 &reg; &nbsp; VIÑASANTODOMINGO | Los mejores en Vino y Pisco.<br/>    
  </td>

  
</table>
</body>
</html>
    ';
}
