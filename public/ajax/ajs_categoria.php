<?php
require_once "../utils/Conexion.php";
$conexion = (new Conexion())->getConexion();
require_once "../extra/CategoriaApi.php";
$tipo = $_POST['tipo'];
$respuesta = array("res" => false);
if ($tipo == 's') {
    $sql = "SELECT
  id_seleccion,
  id_grupo,
   nombre_cate AS 'nombre',
  codi_categoria,
  imagen,
  estado
FROM grupo_seleccion ";
    $res = $conexion->query($sql);
    $respuesta = [];
    foreach ($res as $row) {
        /*
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://computer.brunoas.com/categorias.php" );
        curl_setopt($ch, CURLOPT_POST, 1);// set post data to true
        curl_setopt($ch, CURLOPT_POSTFIELDS,"tipo=data&cod=". $row['codi_categoria']);   // post data
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $json = curl_exec($ch);
        curl_close($ch);
        $arr = json_decode($json);
        $row['nombre']= $arr->nom_sub1;*/
        $row['imagen'] = strlen($row['imagen']) < 5 ? 'sinimagen_menu_20sba.jpg' : $row['imagen'];
        $respuesta[] = $row;
    }
} elseif ($tipo == 'lis') {
    $categoriaApi = new CategoriaApi();
    $respuesta = $categoriaApi->getLista();
    
} elseif ($tipo == 'in') {
    $respuesta['res'] = false;
    if ($_POST['cod'] == '') {
        $respuesta['res'] = false;
    } else {
        $sql = "INSERT INTO grupo_seleccion set id_grupo=null,nombre_cate = '{$_POST['nom']}',imagen ='{$_POST['imagen']}',estado='1', codi_categoria='{$_POST['cod']}'";
        /* VALUES (null,
             null,
             '{$_POST['nom']}',
            '{$_POST['cod']}',
            '{$_POST['imagen']}',
            '1');"; */
        /*  echo $sql; */

        if ($conexion->query($sql)) {
            $respuesta['res'] = true;
        }
    }
} elseif ($tipo == 'up') {
    $sql = "UPDATE grupo_seleccion
SET  
  imagen = '{$_POST['imagen']}' 
WHERE id_seleccion = '{$_POST['cate']}';";

    if ($conexion->query($sql)) {
        $respuesta['res'] = true;
    }
} elseif ($tipo == 'sub_c') {
    $sql = "SELECT 
  sub_categoria.* 
FROM
  sub_categoria 
  INNER JOIN grupo_seleccion 
    ON sub_categoria.id_catego = grupo_seleccion.id_seleccion 
WHERE grupo_seleccion.codi_categoria ='{$_POST['cat']}'";
    $resp = $conexion->query($sql);
    $respuesta = [];
    foreach ($resp as $row) {
        $respuesta[] = $row;
    }
}

echo json_encode($respuesta);
