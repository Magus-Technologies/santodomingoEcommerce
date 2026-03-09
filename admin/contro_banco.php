<?php

require_once "../utils/Conexion.php";

$conexion = (new Conexion())->getConexion();

/* var_dump($_POST);
die(); */
$respuesta['res'] = false;
$respuesta['msj'] = 'No se pudo responder el caso';
$hoy = date("Y-m-d");
$vacio ="SL";

$opc = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
switch ($opc) {

    case 'agregar-banco':
	$sql = "INSERT INTO bancos_detalles(det_soles, det_dolares, det_banco ) VALUES('{$_POST['passsoles']}','{$_POST['passdolares']}','{$_POST['passbanco']}') ";
	$result = $conexion->query($sql);
		if ($result) {
		    $respuesta['res'] = true;
		    $respuesta['msj'] = 'Agregado';
		}
	echo json_encode($respuesta);
	break;

    case 'editar-banco':
	$sql = "UPDATE bancos_detalles SET det_soles='{$_POST['epasssoles']}', det_dolares='{$_POST['epassdolares']}', det_banco ='{$_POST['epassbanco']}' WHERE id_det='{$_POST['idedit']}'";
	$result = $conexion->query($sql);
		if ($result) {
		    $respuesta['res'] = true;
		    $respuesta['msj'] = 'Actualizado';
		}
	echo json_encode($respuesta);
	break;	

     case 'eliminar-banco':
	$sql = "DELETE FROM bancos_detalles WHERE id_det ='{$_POST['id']}'";
	$result = $conexion->query($sql);
		if ($result) {
		    $respuesta['res'] = true;
		    $respuesta['msj'] = 'Eliminado';
		}
	echo json_encode($respuesta);
	break;

	case 'buscar-banco':
	$sql = "SELECT * from bancos_detalles WHERE id_det = '{$_POST['id']}'"; 
		$result = $conexion->query($sql)->fetch_assoc();
            if ($result) {
		    $respuesta['res'] = true;
                $respuesta['msj'] = true;
		    $respuesta['data'] = $result;
		}

		echo json_encode($respuesta);
	break;

    }   

