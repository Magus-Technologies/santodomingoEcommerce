<?php

require_once "../utils/Conexion.php";

$conexion = (new Conexion())->getConexion();

/* var_dump($_POST);
die(); */
$respuesta['res'] = false;
$respuesta['msj'] = 'No se pudo editar la clave';
$sql = "UPDATE usuarios set clave='{$_POST['claveEditUser']}'  WHERE use_id='{$_POST['idUserPass']}'";
$result = $conexion->query($sql);
if ($result) {
    $respuesta['res'] = true;
    $respuesta['msj'] = 'Actualizacion correcta';
}
echo json_encode($respuesta);
