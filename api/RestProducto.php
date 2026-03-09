<?php
  include "utils/BD.php";

  $pronmbre = $_POST['pronmbre'];
  $promarca = $_POST['promarca'];
  $proprecio = $_POST['proprecio'];
  $prostock = $_POST['prostock'];
  $procosto = $_POST['procosto'];
  $hoy = date("Y-m-d");
  $opc = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
  
  
  switch ($opc) {
    case 'agregar-producto':
		if ($pronmbre !='' and $promarca  !='' and   $proprecio>0 and   $prostock !='' and   $procosto!='') {
			$sql= "INSERT INTO zz_producto VALUES ('0','001','1','$pronmbre','$promarca','000','$proprecio','$prostock','$procosto','$hoy','0')";
			if (!mysqli_query ($con,$sql)) { 
        $listar =("Error Api: " . mysqli_error($con)); 
      } else {	
        $listar = array("resp" =>"Producto Agregado Api");	
      }
		}	
	 $data[] = $listar;
	 break; 	

	 case 'editar-producto':
    if ($pronmbre !='' and $promarca  !='' and   $proprecio>0 and   $prostock !='' and   $procosto!='') {
			 $sql= "UPDATE zz_producto SET nombre ='',  marca ='', preciopro ='', stock ='', precio_oferta=''
       WHERE pro_id = '1'";
		   if (!mysqli_query ($con,$sql)) { 
        $listar = ("Error Api: " . mysqli_error($con)); 
       } else {	
        $listar = array("resp" =>"Producto Actualizado Api");	
       }
		} 
	 $data[] = $listar;
	 break; 	 

  }
  print json_encode($data);

?>