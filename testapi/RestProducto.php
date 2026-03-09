<?php
include "BD.php";
header("Content-type: application/json");
$hoy = date("Y-m-d H:i:s");
$opc =  $_POST['opc'];

function escribirLog($mensaje)
{
	$archivo = 'log_productos.txt';
	$fecha = date('Y-m-d H:i:s');
	// Si el mensaje es un array, lo convertimos a texto para leerlo fácil
	if (is_array($mensaje) || is_object($mensaje)) {
		$mensaje = print_r($mensaje, true);
	}
	file_put_contents($archivo, "[$fecha] $mensaje" . PHP_EOL, FILE_APPEND);
}
//$opc = 'agregar-masivo';
//$data =$procosto;
switch ($opc) {
	case 'agregar-masivo';
		$listado = $_POST["listado"];
		$lista = json_decode($listado, true);
		$sqlcod = "SELECT (CASE WHEN COUNT(cod_prod) = 0 THEN 1 ELSE MAX(cod_prod) END) as xtot FROM `sopprod`";
		$rescod = mysqli_query($con, $sqlcod);
		$arrcod = mysqli_fetch_array($rescod, MYSQLI_ASSOC);
		$codnew = $arrcod['xtot'];

		$ejecval = 0;
		$recorrer = 0;
		$respArray = [];
		foreach ($lista as $item) {
			$recorrer++;
			$pronmbre = $item['descripcicon'];
			$promarca = "null";
			$prostock = $item['cantidad'];
			$proprecio = $item['precio_unidad'];
			$procosto = $item['costo'];
			$preciovip =  $item['precio'] ?? 0;
			$precioferta = $item['precio2'] ?? 0;
			$precioremate =  $item['precio3'] ?? 0;
			$preciodistri  = $item['precio4'] ?? 0;


			///VALIDAR LA CATEGORIA	
			$xcat = $item['codSunat'];
			$sqlf = "SELECT cod_sub1 AS valido FROM sopsub1 where cod_sub1='$xcat'";
			$resf = mysqli_query($con, $sqlf);
			$arrf = mysqli_fetch_array($resf, MYSQLI_ASSOC);
			$nfil = $arrf['valido'];
			if ($nfil == "") {
				$nfil = '000';
			}
			if ($pronmbre != '' and   $proprecio > 0 and   $prostock != '' and   $procosto != '') {
				///BUSCAR ULTIMO PRODUCTO REGISTRADO
				$codnew = $codnew  + $recorrer;
				$numcar = strlen($codnew);
				if ($numcar == 1) {
					$numrec =  '000' . $codnew;
				}
				if ($numcar == 2) {
					$numrec =  '00' . $codnew;
				}
				if ($numcar == 3) {
					$numrec =  '0' . $codnew;
				}
				if ($numcar >= 4) {
					$numrec =   $codnew;
				}
				$sql = "INSERT INTO zz_producto VALUES ('0','$nfil','1','$pronmbre','$promarca','$numrec','$proprecio','$prostock','$procosto','$hoy','0','$preciodistri','$preciovip','$precioferta','$precioremate')";
				if (!mysqli_query($con, $sql)) {
					$error = ("Error INSERT: " . mysqli_error($con));
					$listar = array("resp" => $error);
				} else {
					$respArray[] = [
						"resp" => $numrec,
						"descripcicon" => $item['descripcicon'],
						"cantidad" => $item['cantidad'],
						"precio" => $item['precio'],
						"precio2" => $item['precio2'],
						"precio3" => $item['precio3'],
						"precio4" => $item['precio4'],
						"costo" => $item['costo'],
						"codSunat" => $item['codSunat'],
						"almacen" => $item['almacen'],
						"afecto" => $item['afecto'],
						"precio_unidad" => $item['precio_unidad'],
						"codigoProd" => $item['codigoProd']
					];
				}
				//
				$ejecval = 1;
			} else {
				$ejecval = 0;
			}
		}
		//SI TODO SALE BIEN 
		$sqlprod = "CALL CargarProductos()";
		$resprod = mysqli_query($con, $sqlprod);


		$data = $respArray;
		break;
	case 'agregar-producto':
		escribirLog("--- INICIO PROCESO AGREGAR PRODUCTO ---");

		$pronmbre  = mysqli_real_escape_string($con, $_POST['pronmbre']);
		$proprecio = (float)$_POST['proprecio'];
		$procosto  = (float)$_POST['procosto'];
		$procate   = mysqli_real_escape_string($con, $_POST['procate']);
		$promarca  = mysqli_real_escape_string($con, $_POST['promarca']);
		$prostock  = (int)$_POST['prostock'];

		// 1. Obtener la Categoría (sopsub1) -
		$iicatego = '001';
		$resf = mysqli_query($con, "SELECT cod_sub1 FROM sopsub1 WHERE nom_sub1 = UPPER('$procate') LIMIT 1");
		if ($arrf = mysqli_fetch_assoc($resf)) {
			$iicatego = $arrf['cod_sub1'];
		} else {
			$resm = mysqli_query($con, "SELECT COALESCE(MAX(CAST(cod_sub1 AS UNSIGNED)), 0) + 1 AS maximo FROM sopsub1");
			$arrm = mysqli_fetch_assoc($resm);
			$iicatego = str_pad($arrm['maximo'], 3, "0", STR_PAD_LEFT);
			mysqli_query($con, "INSERT INTO sopsub1 (cod_sub1, nom_sub1) VALUES ('$iicatego', UPPER('$procate'))");
		}

		// 2. BUSCAR EL CÓDIGO REAL DE LA LÍNEA (soplinea) -
		// Buscamos 'MERCADERIA' para obtener su '01' exacto
		$res_l = mysqli_query($con, "SELECT cod_line FROM soplinea WHERE nom_line LIKE '%MERCADERIA%' LIMIT 1");
		$arr_l = mysqli_fetch_assoc($res_l);
		$linea_final = $arr_l['cod_line'] ?? '01';

		// 3. BUSCAR EL CÓDIGO REAL DE LA SUBCATEGORÍA (sopsub2) -
		// Buscamos 'GENERAL' para obtener su '1' exacto
		$res_s = mysqli_query($con, "SELECT cod_sub2 FROM sopsub2 WHERE nom_sub2 LIKE '%GENERAL%' LIMIT 1");
		$arr_s = mysqli_fetch_assoc($res_s);
		$sub2_final = $arr_s['cod_sub2'] ?? '1';

		if ($pronmbre != '' && $proprecio > 0) {

			// A. Manejo de Marca -
			$res_m = mysqli_query($con, "SELECT cod_marca FROM marcra_productos WHERE nombre_marca = '$promarca' LIMIT 1");
			if (mysqli_num_rows($res_m) > 0) {
				$row_m = mysqli_fetch_assoc($res_m);
				$codmarca_final = $row_m['cod_marca'];
			} else {
				$res_cm = mysqli_query($con, "SELECT COALESCE(MAX(cod_marca), 0) + 1 AS nuevo FROM marcra_productos");
				$codmarca_final = mysqli_fetch_assoc($res_cm)['nuevo'];
				mysqli_query($con, "INSERT INTO marcra_productos (nombre_marca, cod_marca) VALUES ('$promarca', '$codmarca_final')");
			}

			// B. Generar Código de Producto -
			$res_cod = mysqli_query($con, "SELECT COALESCE(MAX(prod_cod), 0) + 1 as xtot FROM producto");
			$numrec = str_pad(mysqli_fetch_assoc($res_cod)['xtot'], 4, "0", STR_PAD_LEFT);

			// C. INSERT en 'producto' -
			$sql_prod = "INSERT INTO producto VALUES (0, '$iicatego', '001', '$pronmbre', '', '', '', '$codmarca_final', '$numrec', '', '', $proprecio, $prostock, '', 1, 0, 0.0, 1)";

			if (mysqli_query($con, $sql_prod)) {

				// D. INSERT en 'sopprod' usando los códigos rescatados de la DB -
				$sql_sop = "INSERT INTO sopprod VALUES (
                '$numrec',      -- cod_prod
                '$linea_final', -- cod_clasi (01)
                '$iicatego',    -- cod_cate (Categoría dinámica)
                '$sub2_final',  -- cod_subc (1)
                '','','',       -- prov, espe, sunat
                '$pronmbre',    -- nom_prod
                '001',          -- cod_unid
                'UND',          -- nom_unid
                '1',            -- fac_unid
                $procosto,      -- kardoc_costo
                $prostock,      -- kardoc_stock
                '0000-00-00',0,'','0000-00-00',1,1,1,'',0,0,3,
                '','','','','','','','','','','','','','','',0,0,0,0,0,0,'',0,NOW(),
                0,0,0,0,0,'',0,0,0,0,0,0,0,0,0,0,0,0,0,''
            )";
				if (mysqli_query($con, $sql_sop)) {
					mysqli_query($con, "INSERT INTO precios VALUES ('$numrec',1,1,0,'0000-00-00',$proprecio,$proprecio,$proprecio,$proprecio,0,0,$procosto,0,0,0,0,0,0,0,0,0)");
					mysqli_query($con, "INSERT INTO stocks VALUES (1,109,'$numrec',$prostock,0,0,0,0,'')");

					escribirLog("¡ÉXITO TOTAL! Registrado con Línea: $linea_final y Sub2: $sub2_final");
					$listar = array("resp" => $numrec);
				} else {
					escribirLog("ERROR FINAL sopprod: " . mysqli_error($con) . " (L:$linea_final S:$sub2_final)");
					$listar = array("resp" => "Error");
				}
			}
		}
		$data[] = $listar;
		break;
	case 'editar-producto':
		$codpro = $_POST['codpro'];
		$pronmbre = $_POST['pronmbre'];
		$prostock = $_POST['prostock'];
		$procosto = $_POST['procosto'];
		$proprecio = $_POST['proprecio'];
		if ($codpro != '' and $pronmbre != '' and $prostock != '') {
			///actualizar nombre y stock 
			$sqlpro = "UPDATE producto SET nombre='$pronmbre', stock_prod='$prostock', precio_prod='$proprecio' WHERE prod_cod='$codpro'";
			if (!mysqli_query($con, $sqlpro)) {
				$error = ("Error UPDATE: " . mysqli_error($con));
				$listar = array("resp" => $error);
			} else {
				$sqlst = "UPDATE stocks SET stock_act='$prostock' WHERE cod_prod='$codpro'";
				$resst = mysqli_query($con, $sqlst);
				//actualizar precio
				$sqlst = "UPDATE precios SET precio_venta='$proprecio', precio_costo='$procosto' WHERE cod_prod='$codpro'";
				$resst = mysqli_query($con, $sqlst);

				$slqzz = "UPDATE zz_producto SET nombre='$pronmbre', stock='$prostock', preciopro='$proprecio' WHERE cod_pro='$codpro'";
				$resst = mysqli_query($con, $slqzz);

				$listar = array("resp" => $codpro);
			}
		} else {
			$listar = array("resp" => '-1');
		}

		$data[] = $listar;
		break;

	case 'editar-stock':
		$codpro = $_POST['codpro'];
		$prostock = $_POST['prostock'];
		if ($codpro != '' and $prostock != '') {
			///actualizar nombre y stock 
			$sqlpro = "UPDATE producto SET  stock_prod='$prostock' WHERE prod_cod='$codpro'";
			if (!mysqli_query($con, $sqlpro)) {
				$error = ("Error UPDATE: " . mysqli_error($con));
				$listar = array("resp" => $error);
			} else {
				$sqlst = "UPDATE stocks SET stock_act='$prostock' WHERE cod_prod='$codpro'";
				$resst = mysqli_query($con, $sqlst);
				$listar = array("resp" => $codpro);
			}
		} else {
			$listar = array("resp" => '-1');
		}

		$data[] = $listar;
		break;

	case 'editar-precio':
		$codpro = $_POST['codpro'];
		$pronombre = $_POST['$pronombre'];
		$proprecio = $_POST['proprecio'];
		$preciovip =  $_POST['precio'] ?? 0;
		$precioferta = $_POST['precio2'] ?? 0;
		$precioremate =  $_POST['precio3'] ?? 0;
		$preciodistri  = $_POST['precio4'] ?? 0;

		if ($codpro != '' and $proprecio != '') {
			$sqlst = "UPDATE precios SET precio_venta='$proprecio',  precio_mayor='$preciodistri', precio_tres='$preciovip', 
           precio_cuatro='$precioferta', precio_cinco ='$precioremate' WHERE cod_prod='$codpro'";
			$resst = mysqli_query($con, $sqlst);

			$sqlstr = "UPDATE precios v, producto p SET v.precio_venta='$proprecio',  v.precio_mayor='$preciodistri', v.precio_tres='$preciovip', 
           v.precio_cuatro='$precioferta', v.precio_cinco ='$precioremate', p.precio_prod='$proprecio' 
	   WHERE p.nombre='$pronombre' AND p.prod_cod = v.cod_prod";

			$rest = mysqli_query($con, $sqlstr);
			$listar = array("resp" => $codpro);
		} else {
			$listar = array("resp" => '-1');
		}
		$data[] = $listar;
		break;

	case 'test':

		$Datos = $_POST['productos'];

		$listar = array();
		foreach ($Datos[0] as $key => $value) {
			$codigo = $value['prod_cod'];
			$totalp = $value['totalpro'];
			$sqlst = "UPDATE stocks SET stock_act='$totalp' WHERE cod_prod='$codigo'";
			$resst = mysqli_query($con, $sqlst);
			$listar[$codigo] = $totalp;
		}

		// print json_encode($Datos);
		// print json_encode($listar);
		$data[] = $listar;
		break;
}
print json_encode($data);
