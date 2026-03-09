<?php
error_reporting(-1);
require "../utils/Tools.php";
require "../utils/Conexion.php";

$tools = new Tools();
$conexion = (new Conexion())->getConexion();

$filename = $_FILES['file']['name'];

$path_parts = pathinfo($filename, PATHINFO_EXTENSION);
$newName =$tools->getToken(80);
/* Location */
$loc_ruta="../public/data/files/pedidos/".$_POST['clien'];
if (!file_exists($loc_ruta)) {
    mkdir($loc_ruta, 0777, true);
}
$location = $loc_ruta."/" . $newName .'.'. $path_parts;
$uploadOk = 1;
$imageFileType = pathinfo($location, PATHINFO_EXTENSION);

$arr = array( 'res' => false);
if (move_uploaded_file($_FILES['file']['tmp_name'], $location)) {
    $arr['res']=true;
    $arr['dstos']= $newName.".".$path_parts;
    $conexion->query("UPDATE pedidos set archivo='{$arr['dstos']}' where pedido_id='{$_POST['pedido']}'");
    echo json_encode($arr);
} else {
    echo json_encode($arr);
}
