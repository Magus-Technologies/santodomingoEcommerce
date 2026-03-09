<?php

require_once "../utils/Conexion.php";

$conexion = (new Conexion())->getConexion();

/* var_dump($_POST);
die(); */
$respuesta['res'] = false;
$respuesta['msj'] = 'No se pudo eliminar el usuario';
$sql = "UPDATE usuarios set nombres='{$_POST['nombreEditUser']}',email='{$_POST['emailEditUser']}'  WHERE use_id='{$_POST['idUser']}'";
$result = $conexion->query($sql);
if ($result) {
    $respuesta['res'] = true;
    $respuesta['msj'] = 'Actualizacion correcta';
}
echo json_encode($respuesta);
