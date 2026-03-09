<?php
  include "BD.php";
  header("Content-type: application/json");
  $hoy = date("Y-m-d H:i:s"); 
  $opc =  $_POST['opc'];
  //$data =$procosto;
  switch ($opc) {
    case 'agregar-producto':
         $pronmbre = $_POST['pronmbre'];             $promarca = $_POST['promarca']; 
         $proprecio = $_POST['proprecio'];           $prostock = $_POST['prostock'];              $procosto = $_POST['procosto'];
		if ($pronmbre !='' and $promarca  !='' and   $proprecio>0 and   $prostock !='' and   $procosto!='') {
		        ///BUSCAR ULTIMO PRODUCTO REGISTRADO
		        $sqlcod = "SELECT (CASE WHEN COUNT(cod_prod) = 0 THEN 1 ELSE MAX(cod_prod)+1 END) as xtot FROM `sopprod`";
		        $rescod = mysqli_query($con,$sqlcod);
		        $arrcod = mysqli_fetch_array($rescod,MYSQLI_ASSOC);
		        $codnew = $arrcod['xtot'];
		        $numcar = strlen($codnew);
              if ($numcar ==1) { $numrec =  '000'.$codnew; }
              if ($numcar ==2) { $numrec =  '00'.$codnew; }
              if ($numcar ==3) { $numrec =  '0'.$codnew; }
              if ($numcar >=4) { $numrec =   $codnew; }

		        
			   	$sql= "INSERT INTO zz_producto VALUES ('0','001','1','$pronmbre','$promarca','$numrec','$proprecio','$prostock','$procosto','$hoy','0')";
	   	   	    if (!mysqli_query ($con,$sql)) {    
	   	   	        $error =("Error INSERT: " . mysqli_error($con));   
	   	   	        $listar = array("resp" =>$error); 
	   	   	        } else {
	   	   	         $sqlprod = "CALL CargarProductos()";
	   	   	         $resprod = mysqli_query($con,$sqlprod);
				  $sqlu = "SELECT cod_pro FROM zz_producto ORDER BY cod_pro DESC LIMIT 1";
					$resu = mysqli_query($con,$sqlu);
					$arru = mysqli_fetch_array($resu,MYSQLI_ASSOC);
					$respcod = $arru['cod_pro'];


	   	   	         $listar = array("resp" =>$numrec);
	   	   	        } 
			   	//
		    } else {
		        $listar = array("resp" =>'-1');
		    }	
	 $data[] = $listar;
	 break; 	
	case 'editar-producto': 
	    $codpro = $_POST['codpro'];      $pronmbre = $_POST['pronmbre'];   $prostock = $_POST['prostock'];      
	    $procosto = $_POST['procosto'];  $proprecio = $_POST['proprecio']; 
	    if ($codpro !='' and $pronmbre!='' and $prostock !='' ){
	        ///actualizar nombre y stock 
	        $sqlpro = "UPDATE producto SET nombre='$pronmbre', stock_prod='$prostock', precio_prod='$proprecio' WHERE prod_cod='$codpro'";
	        if (!mysqli_query ($con,$sqlpro)) {    
	   	   	        $error =("Error UPDATE: " . mysqli_error($con));   
	   	   	        $listar = array("resp" =>$error); 
	   	   	        } else {
	   	   	            $sqlst = "UPDATE stocks SET stock_act='$prostock' WHERE cod_prod='$codpro'";
	   	   	            $resst = mysqli_query($con,$sqlst);
	   	   	            //actualizar precio
	   	   	            $sqlst = "UPDATE precios SET precio_venta='$proprecio',  precio_mayor='$proprecio', precio_tres='$proprecio', precio_cuatro='$proprecio', 
	   	   	            precio_costo='$procosto' WHERE cod_prod='$codpro'";
	   	   	            $resst = mysqli_query($con,$sqlst);
				 
				    $slqzz = "UPDATE zz_producto SET nombre='$pronmbre', stock='$prostock', preciopro='$proprecio' WHERE cod_pro='$codpro'";	   	   	            
	                           $resst = mysqli_query($con,$slqzz);

	   	   	            $listar = array("resp" =>$codpro);
	   	   	        }        
	                
	    } else {
	         $listar = array("resp" =>'-1'); 
	    } 

	$data[] = $listar;    
    break;
    
    case 'editar-stock': 
    $codpro = $_POST['codpro'];         $prostock = $_POST['prostock'];      
     if ($codpro !='' and $prostock !='' ){
          ///actualizar nombre y stock 
	        $sqlpro = "UPDATE producto SET  stock_prod='$prostock' WHERE prod_cod='$codpro'";
	        if (!mysqli_query ($con,$sqlpro)) {    
	   	   	        $error =("Error UPDATE: " . mysqli_error($con));   
	   	   	        $listar = array("resp" =>$error); 
	   	   	        } else {
	   	   	            $sqlst = "UPDATE stocks SET stock_act='$prostock' WHERE cod_prod='$codpro'";
	   	   	            $resst = mysqli_query($con,$sqlst);
	   	   	            $listar = array("resp" =>$codpro);
	   	   	        } 
     } else {
	        $listar = array("resp" =>'-1'); 
	 }  
        
    $data[] = $listar;    
    break;
    
    case 'editar-precio': 
    $codpro = $_POST['codpro'];  $proprecio = $_POST['proprecio']; 
     if ($codpro !='' and $proprecio !='' ){
          $sqlst = "UPDATE precios SET precio_venta='$proprecio',  precio_mayor='$proprecio', precio_tres='$proprecio', 
           precio_cuatro='$proprecio' WHERE cod_prod='$codpro'";
	   	   $resst = mysqli_query($con,$sqlst);
	   	   $listar = array("resp" =>$codpro);
     } else {
	        $listar = array("resp" =>'-1'); 
	 }   
    $data[] = $listar;    
    break;
    
   case 'test': 
        
        $Datos = $_POST['productos'];
        
        $listar = array();
        foreach ($Datos[0] as $key => $value) {
            $codigo = $value['prod_cod'];
            $totalp= $value['totalpro'];
            $sqlst = "UPDATE stocks SET stock_act='$totalp' WHERE cod_prod='$codigo'";
	   	   	$resst = mysqli_query($con,$sqlst);
	   	   	$listar[$codigo]=$totalp;
        }
        
         // print json_encode($Datos);
        // print json_encode($listar);
      $data[] = $listar; 
      break;
    
  }
 print json_encode($data)

?>