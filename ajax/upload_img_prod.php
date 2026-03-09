<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
require "../utils/Tools.php";
require "../utils/Conexion.php";

$tools = new Tools();
$conexion = (new Conexion())->getConexion();

$filename = $_FILES['file']['name'];

$path_parts = pathinfo($filename, PATHINFO_EXTENSION);
$newName =$tools->getToken(80);
/* Location */
$location = "../public/img/productos/" . $newName .'.'. $path_parts;
$uploadOk = 1;
$imageFileType = pathinfo($location, PATHINFO_EXTENSION);

/* Upload file */
$arr = array( 'res' => false);
if (move_uploaded_file($_FILES['file']['tmp_name'], $location)) {
    $arr['res']=true;
    $arr['dstos']= $newName.".".$path_parts;
   // echo "INSERT INTO producto_foto VALUES (NULL, '{$_POST['produc']}', '{$arr['dstos']}', '{$_POST['posicion']}');" ;
    $conexion->query("INSERT INTO producto_foto VALUES (NULL, '{$_POST['produc']}', '{$arr['dstos']}', '{$_POST['posicion']}');");
    echo json_encode($arr);
} else {
    echo json_encode($arr);
}
