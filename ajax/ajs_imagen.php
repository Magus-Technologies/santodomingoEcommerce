<?php
require_once "../utils/Conexion.php";

$conexion = (new Conexion())->getConexion();

$tipo = $_POST['tipo'];
$respuesta = array("res"=>false);

if($tipo=='u'){
    $posision = $_POST['orden'];
    $idFoto = $_POST['foto_id'];
    $sql ="UPDATE producto_foto
SET 
  orden = '$posision'
WHERE foto_id = '$idFoto'";
    if ($conexion->query($sql)){
        $respuesta['res'] = true;
    }
}elseif($tipo=='del'){
    echo $_POST['imasgg'];
    $imagenesDel = json_decode($_POST['imasgg']);
    foreach ($imagenesDel as $img){
        unlink("../public/img/productos/".$img->imagen_url);
        $sql = "DELETE FROM producto_foto WHERE foto_id = ".$img->foto_id;
        $conexion->query($sql);
    }
}

echo json_encode($respuesta);

