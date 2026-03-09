<?php
require_once "../utils/Conexion.php";

$conexion = (new Conexion())->getConexion();
$tipo = $_POST['tipo'];


$respuesta = array("res"=>false);

if ($tipo == 'in'){
    $sql=" INSERT INTO productos_exclusivos
VALUES (NULL,
        '{$_POST['prod']}');";

    if ($conexion->query($sql)){
        $respuesta['res']=true;
    }

}elseif ($tipo == 'del'){
    $sql="DELETE
FROM productos_exclusivos
WHERE id_exclu =  '{$_POST['excl']}';";

    if ($conexion->query($sql)){
        $respuesta['res']=true;
    }

}


echo json_encode($respuesta);