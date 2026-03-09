<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

require "utils/Conexion.php";

$conexion = (new Conexion())->getConexion();

$tipo = $_POST['tipo'];


$respuesta = array("res"=>false);

if ($tipo =="lista"){
    $sql ="SELECT sopsub1.cod_sub1, sopsub1.nom_sub1 FROM sopsub1 WHERE cod_sub1 !='000'";
    $resul = $conexion->query($sql);
    $respuesta=[];
    foreach ($resul as $row){
        $respuesta[]=$row;
    }
}elseif ($tipo == 'data'){
    $sql ="SELECT
  cod_sub1,
  nom_sub1
FROM sopsub1 WHERE cod_sub1 = '{$_POST['cod']}'";
    $resul = $conexion->query($sql);
    if ( $rowCat = $resul->fetch_assoc() ){

        $respuesta= $rowCat;
    }
}


echo json_encode($respuesta);