<?php

require_once "../utils/Conexion.php";

$conexion = (new Conexion())->getConexion();

/* var_dump($_POST);
die(); */
$respuesta['res'] = false;
$respuesta['msj'] = 'No se pudo editar el tipo de pago';
$sql = "UPDATE tipo_pago set nombre='{$_POST['nombreEdit']}', estado ='{$_POST['estadoEdit']}' WHERE id_tipo_pago='{$_POST['idTipoPago']}'";
$result = $conexion->query($sql);
if ($result) {
    $respuesta['res'] = true;
    $respuesta['msj'] = 'Actualizacion correcta';
}
echo json_encode($respuesta);
