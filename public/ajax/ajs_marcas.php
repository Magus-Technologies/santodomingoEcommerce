<?php

require "../dao/MarcaSeleccionDao.php";

$conexion = (new Conexion())->getConexion();

$respuesta =array("res"=>false);
$tipo = $_POST['tipo'];
/*$marcaSeleccionDao = new MarcaSeleccionDao();

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://computer.brunoas.com/marcas.php" );
curl_setopt($ch, CURLOPT_POST, 1);// set post data to true
curl_setopt($ch, CURLOPT_POSTFIELDS,"tipo=lista");   // post data
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$json = curl_exec($ch);
curl_close($ch);

//echo $json;

$respuesta =[];
$listaJSON = json_decode($json);

foreach ($listaJSON as $mar){
    $marcaSeleccionDao->setCodMarca($mar->cod_sub2);
    $marTem=array("cod_mar"=>$mar->cod_sub2,"marca"=>$mar->nom_sub2,"imagen"=>'');
    if ($row = $marcaSeleccionDao->getDataImagen()->fetch_assoc()){
        $marTem['imagen'] =$row['imagen'];

    }
    $respuesta[]=$marTem;
}*/

if ($tipo =="s"){
    $sql ="SELECT
  marca_id,
  nombre_marca as 'nombre',
  cod_marca,
  imagen
FROM marcra_productos ";
    $res = $conexion->query($sql);
    $respuesta=[];
    foreach ($res as $re) {
      /*  $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://computer.brunoas.com/marcas.php" );
        curl_setopt($ch, CURLOPT_POST, 1);// set post data to true
        curl_setopt($ch, CURLOPT_POSTFIELDS,"tipo=data&cod=". $re['cod_marca']);   // post data
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $json = curl_exec($ch);
       // echo $json;
        curl_close($ch);
        $arr = json_decode($json);*/
        $re['imagen']= strlen($re['imagen'])<5?'sin_imagen.png':$re['imagen'];
        //$re['nombre']=$arr->nom_sub2;
        $respuesta[]=$re;
    }

}elseif ($tipo =='lis'){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://computer.brunoas.com/marcas.php" );
    curl_setopt($ch, CURLOPT_POST, 1);// set post data to true
    curl_setopt($ch, CURLOPT_POSTFIELDS,"tipo=lista");   // post data
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $json = curl_exec($ch);
    // echo $json;
    curl_close($ch);
    $respuesta=json_decode($json);
}elseif ($tipo =='in'){
    $sql = "INSERT INTO marcra_productos
VALUES (null,
'{$_POST['nom']}',
        '{$_POST['cod']}',
        '{$_POST['imagen']}');";

    if ($conexion->query($sql)){
        $respuesta['res']=true;
    }
}elseif ($tipo =='up'){
    $sql = "UPDATE marcra_productos
SET 
  imagen = '{$_POST['imagen']}'
WHERE marca_id = '{$_POST['marc']}'";

    if ($conexion->query($sql)){
        $respuesta['res']=true;
    }
}

echo json_encode($respuesta);