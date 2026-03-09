<?php
include "BD.php";


$opc = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

switch ($opc) {

    case '11': // AGREGAR  MODULO
            $fecharec  = $_POST['fecharec'];
            $numrecla = $_POST['numrecla'];
            $negocio = $_POST['negocio'];
            $tienda =  $_POST['tienda'];
            $nombre = $_POST['nombre'];
            $domicilio = $_POST['domicilio'];
            $dni = $_POST['dni'];
            $telefono = $_POST['telefono'];
            $email = $_POST['email'];
            $menor = $_POST['menor'];
            if ($menor =="") { $menor = 0; }
            
            $nombre_padre = $_POST['nombre_padre'];
            $domicilio_padre = $_POST['domicilio_padre'];
            $dni_padre =  $_POST['dni_padre'];
            $telefono_padre = $_POST['telefono_padre'];
            $email_padre = $_POST['email_padre'];
            $producto = $_POST['producto'];
           
            $monto =  $_POST['monto'];
            $descripcion = $_POST['descripcion'];
            $reclamo = $_POST['reclamo'];   
           
            $detalle = $_POST['detalle'];
            $pedido = $_POST['pedido'];
            $fechares ='0000-00-00';
            $respuesta="";
	if ($fecharec !='0000-00-00') {
	$sqlfil = "SELECT COUNT(lib_id) as canti FROM `libro_reclamacion` WHERE LENGTH(lib_respuesta) =0 AND TRIM(lib_emailcli)=TRIM('$email')";
            $resfil = mysqli_query($con,$sqlfil);
            $arrfil = mysqli_fetch_array($resfil,MYSQLI_ASSOC);
            $ncanti = $arrfil['canti'];

	if ($ncanti < 2) {
            $sqlarq = "INSERT INTO libro_reclamacion VALUES ('0','$numrecla','$fecharec','$negocio','$tienda','$nombre','$domicilio','$dni',
            '$telefono','$email','$menor','$nombre_padre','$domicilio_padre',
            '$dni_padre','$telefono_padre','$email_padre','$producto','$descripcion','$monto','$reclamo','$detalle','$pedido',
            '$fechares','$respuesta')";  
            if (!mysqli_query ($con,$sqlarq)) { 
              echo("Error arqueo: " . mysqli_error($con)); 
            }
           }
          }
            //echo $sqlarq;
        ///
        $listar = array("data" =>'1');
        $data[] = $listar;
      break;

      
    case '2': // 
        $numerorec= $_POST['numerorec'];
        $sql0 = "SELECT * FROM libro_reclamacion WHERE lib_code='$numerorec'";
        $res0 = mysqli_query($con,$sql0);
        while($row = mysqli_fetch_assoc($res0))
        { $data[] = $row; }
      break;

     case '3':
      $idre = $_POST['idre'];
      $resppo = $_POST['resppo'];
      $fecres = $_POST['fecres']; 
      $sql0 = "UPDATE libro_reclamacion SET lib_fecres='$fecres', lib_respuesta='$resppo' 
        WHERE lib_id='$idre'";
      $res0 = mysqli_query($con,$sql0);

      ///
      $listar = array("data" =>'1');
      $data[] = $listar;
      break; 
    
      case '9': // FILTRAR  CLIENTE
    $numfil = $_POST['numfil'];
    $tipo = $_POST['tipo'];
    $urlDNI = 'http://magustechnologies.com:9091/consulta/dni2/';
    $urlRUC = 'https://magustechnologies.com/api/consulta/ruc/';
    if ($_POST['tipo'] == 'dni') {
      $url = $urlDNI . $numfil;
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HEADER, 0);
      $data = curl_exec($ch);
      curl_close($ch);
    } else if ($_POST['tipo'] == 'ruc') {
      $url = $urlRUC . $numfil;
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HEADER, 0);
      $data = curl_exec($ch);
      curl_close($ch);
    } 
    break;

    }         
  print json_encode($data);

 ?>
