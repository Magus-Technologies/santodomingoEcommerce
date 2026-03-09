<?php

require_once "../utils/Conexion.php";

$conexion = (new Conexion())->getConexion();

/* var_dump($_POST);
die(); */
$respuesta['res'] = false;
$respuesta['msj'] = 'No se pudo responder el caso';
$hoy = date("Y-m-d");

$opc = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
switch ($opc) {

    case 'agregar-paso':
	$sql = "INSERT INTO delivery_pasos(detalle_paso, num_paso, tipo ) VALUES('{$_POST['passdetalle']}','{$_POST['passnumero']}','{$_POST['passtipo']}') ";
	$result = $conexion->query($sql);
		if ($result) {
		    $respuesta['res'] = true;
		    $respuesta['msj'] = 'Agregado';
		}
	echo json_encode($respuesta);
	break;

    case 'editar-paso':
	$sql = "UPDATE delivery_pasos SET detalle_paso='{$_POST['epassdetalle']}', num_paso='{$_POST['passnumero']}' WHERE id_paso='{$_POST['idedit']}'";
	$result = $conexion->query($sql);
		if ($result) {
		    $respuesta['res'] = true;
		    $respuesta['msj'] = 'Actualizado';
		}
	echo json_encode($respuesta);
	break;	

     case 'eliminar-paso':
	$sql = "DELETE FROM delivery_pasos WHERE id_paso ='{$_POST['id']}'";
	$result = $conexion->query($sql);
		if ($result) {
		    $respuesta['res'] = true;
		    $respuesta['msj'] = 'Eliminado';
		}
	echo json_encode($respuesta);
	break;

	case 'buscar-paso':
	$sql = "SELECT * from delivery_pasos WHERE id_paso = '{$_POST['id']}'"; 
		$result = $conexion->query($sql)->fetch_assoc();
            if ($result) {
		    $respuesta['res'] = true;
                $respuesta['msj'] = true;
		    $respuesta['data'] = $result;
		}

		echo json_encode($respuesta);
	break;

    }   

