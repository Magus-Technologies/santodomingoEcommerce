<?php

require_once "../utils/Conexion.php";

$conexion = (new Conexion())->getConexion();

/* var_dump($_POST);
die(); */
$respuesta['res'] = false;
$respuesta['msj'] = 'No se pudo responder el caso';
 $hoy = date("Y-m-d");
$sql = "UPDATE libro_reclamacion set lib_respuesta='{$_POST['respecaso']}', lib_fecres='{$hoy}' WHERE lib_id='{$_POST['idreclama']}'";
$result = $conexion->query($sql);
if ($result) {
    $respuesta['res'] = true;
    $respuesta['msj'] = 'Caso respondido';
}
echo json_encode($respuesta);
