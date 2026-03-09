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
$location = "../public/img/banner/" . $newName .'.'. $path_parts;
$uploadOk = 1;
$imageFileType = pathinfo($location, PATHINFO_EXTENSION);
//echo $tools->getToken(80);


$arr = array( 'res' => false);
if (move_uploaded_file($_FILES['file']['tmp_name'], $location)) {
    $arr['res']=true;
    $arr['dstos']= $newName.".".$path_parts;
    echo json_encode($arr);
} else {
    echo json_encode($arr);
}
