<?php

require_once "../utils/Conexion.php";
$conexion = (new Conexion())->getConexion();

/* $respuesta =array("res"=>false);
 *//* str_pad($numero, 2, "0", STR_PAD_LEFT) */

$emailValido = filter_var($_POST['emailRegistrar'], FILTER_VALIDATE_EMAIL);
$respuesta['res'] = false;
$respuesta['msj'] = 'Ingrese un email valido';
if ($emailValido) {
    $sqlVerificar = "SELECT * FROM registrados_x_promociones WHERE email ='{$_POST['emailRegistrar']}'";
    $result =  $conexion->query($sqlVerificar);
    if (!($res = $result->fetch_assoc())) {
        $result = $conexion->query("INSERT INTO registrados_x_promociones set email='{$_POST['emailRegistrar']}'");
        $respuesta['res'] = true;
        $respuesta['msj'] = 'Te registraste Correctamente';
    }else{
        $respuesta['msj'] = 'Ya estas suscrito';
    }
}
echo json_encode($respuesta);
