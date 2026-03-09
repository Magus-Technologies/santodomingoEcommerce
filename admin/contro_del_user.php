<?php

require_once "../utils/Conexion.php";

$conexion = (new Conexion())->getConexion();

$respuesta['res'] = false;
$respuesta['msj'] = 'No se pudo eliminar el usuario';
$sql = "DELETE FROM usuarios WHERE use_id = '{$_POST['id']}';";
$result = $conexion->query($sql);
if ($result) {
    $respuesta['res'] = true;
    $respuesta['msj'] = 'Se eliminó correctamente el usuario';
}
echo json_encode($respuesta);
