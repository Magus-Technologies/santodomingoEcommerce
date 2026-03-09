<?php

require_once "../utils/Conexion.php";

$conexion = (new Conexion())->getConexion();

$respuesta['res'] = false;
$respuesta['msj'] = 'No se pudo actualizar permiso';


$sqlf = "SELECT (CASE WHEN vip_estado = '0' THEN '1' ELSE '0' END)  AS vip  FROM usuarios_vip WHERE use_id='{$_POST['id']}'";
	$resulta = $conexion->query($sqlf);
        foreach ($resulta as $rowped) {
		$vip = $rowped['vip'];
 	}

	if ($vip !='') {
	$sql = "UPDATE usuarios_vip SET vip_estado='$vip' WHERE use_id='{$_POST['id']}' ";
	$result = $conexion->query($sql);
	} else {
	//se debe crear el permiso 
	 $idusu = $_POST['id'];
       		$sql ="INSERT INTO usuarios_vip VALUES (0,'{$_POST['id']}',1,CURRENT_TIMESTAMP())";
	       $result = $conexion->query($sql);
	}

if ($result) {
    $respuesta['res'] = true;
    $respuesta['msj'] = 'Se actualizo correctamente ';
}
echo json_encode($respuesta);
