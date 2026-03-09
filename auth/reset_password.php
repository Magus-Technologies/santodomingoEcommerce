<?php

require "../model/EnvioEmail.php";
require "../utils/Tools.php";
require "../utils/Conexion.php";

$tools=new Tools();
$email = new EnvioEmail();
$conexion=(new Conexion())->getConexion();


 function reset_email_plantilla($basehost,$nombre, $tocken){
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
  <td align="center" style="padding: 40px 0 30px 0; color: white; background-color:#000;">
   	<h2><strong>Gracias por preferirnos </strong></h2>
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
            Te informamos <b>'.$nombre.'</b> que tienes una solicitud abierta
          </td>
        </tr>
        <tr>
          <td style="padding: 20px 0 30px 0; color: black">
            Tienes una solicitud de recuperación de contraseña, has clik en el siguiente botón para ir a
            recuperar tu contraseña, si no fuiste tú, ingresa a tu cuenta y cambia la contraseña.<br><br>
          </td>
        </tr>
        <tr>
          <td style="text-align: center;color: #ffffff">
            <a href="'.$basehost.'/reset_pass.php?token='.$tocken.'" target="_blank" style="text-decoration: none;cursor: pointer;"
               class="btn btn-green">Restablecer contraseña</a>
          </td>
        </tr>
        <tr>
          <td style="text-align: left;">
            <br>
	         <p>O puedes usar el siguiente link para recuperar tu contraseña <a target="_blank" href="'.$basehost.'/reset_pass.php?token='.$tocken.'">Restablecer contrase&ntilde;a</a></p>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <td align="center" style="padding: 40px 0 30px 0; color: black; background-color:#c2c2c2;">
   	 &reg; &nbsp; VIÑASANTODOMINGO - Te invitamos a visitar en nuestra tienda.<br/>
            
  </td>

  
</table>
</body>
</html>
    ';
}


if (isset($_POST['email'])){

    $token = $tools->getToken(120);

    $sql="select * from usuarios where email='{$_POST['email']}'";

    $result = $conexion->query($sql);
    if ($row=$result->fetch_assoc()){
        $sql="update usuarios set token_reset='$token' where use_id='{$row['use_id']}'";
        if ($conexion->query($sql)){
            ob_start();
            $ressss= $email->de("envio@magus-qa.com","VIÑASANTODOMINGO")
                ->addEmail($row['email'],$row['nombres'])
                ->setasunto("Recuperacion de contraseña")
                ->cuerpo(reset_email_plantilla("http://localhost/public_html/CYM",$row['nombres'],"$token"))
                ->enviar();
            ob_end_clean();
            if ($ressss){
                echo 'true';
                die();
            }else{

            }
        }else{

        }
    }else{

    }
}
echo 'false';

