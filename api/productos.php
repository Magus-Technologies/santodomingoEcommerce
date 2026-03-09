<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

require "utils/Conexion.php";

$conexion  = (new Conexion())->getConexion();

$tipo = $_POST['tipo'];

$respuesta =[];

if ($tipo == 'lista'){
    $sql ="SELECT 
  precios.cod_prod,
  precios.cod_suc,
  sopprod.cod_cate,
  sopprod.cod_subc,
  sopprod.cod_espe,
  sopprod.nom_prod,
  sopprod.nom_unid
FROM
  precios 
  INNER JOIN sopprod 
    ON precios.cod_prod = sopprod.cod_prod 
WHERE precios.cod_suc = 1 AND sopprod.cod_clasi != '00'";

    $res = $conexion->query($sql);

    foreach ($res as $row){
        $respuesta[]=$row;
    }

}elseif($tipo == 'prod'){
    $cod_prod = $_POST['cod_prod'];

    $sql="SELECT 
  precios.cod_prod,
  precios.cod_suc,
  precios.precio_venta,
  sopprod.cod_cate,
  sopprod.cod_subc,
  sopprod.cod_espe,
  sopprod.nom_prod,
  sopprod.nom_unid,
  sopsub1.nom_sub1,
  sopsub2.nom_sub2
FROM
  precios 
  INNER JOIN sopprod 
    ON precios.cod_prod = sopprod.cod_prod 
    INNER JOIN sopsub1 ON sopprod.cod_cate = sopsub1.cod_sub1
    INNER JOIN sopsub2 ON sopprod.cod_subc = sopsub2.cod_sub2
WHERE precios.cod_suc = 1 
  AND sopprod.cod_clasi != '00'
  AND precios.cod_prod = '$cod_prod'";

    $res = $conexion->query($sql);
    if ($row = $res->fetch_assoc()){
        $sql="SELECT SUM(stock_act) AS 'stock' FROM stocks WHERE cod_suc = 1 AND cod_prod =  '{$row['cod_prod']}'";
        $row['stock']=0;
        $rsul = $conexion->query($sql);
        if ($row2 = $rsul->fetch_assoc()){
            $row['stock'] = $row2['stock'];
        }
        $respuesta=$row;
    }

}elseif($tipo == 'prodD'){
    $cod_prod = $_POST['cod_prod'];

    $sql="SELECT 
  precios.cod_prod,
  precios.cod_suc,
  precios.precio_venta,
  sopprod.cod_cate,
  sopprod.cod_subc,
  sopprod.cod_espe,
  sopprod.nom_prod,
  sopprod.nom_unid,
  sopsub1.nom_sub1,
  sopsub2.nom_sub2
FROM
  precios 
  INNER JOIN sopprod 
    ON precios.cod_prod = sopprod.cod_prod 
    INNER JOIN sopsub1 ON sopprod.cod_cate = sopsub1.cod_sub1
    INNER JOIN sopsub2 ON sopprod.cod_subc = sopsub2.cod_sub2
WHERE precios.cod_suc = 1 
  AND sopprod.cod_clasi != '00' 
  AND precios.cod_prod = '$cod_prod'";

    $res = $conexion->query($sql);
    if ($row = $res->fetch_assoc()){
        $sql="SELECT SUM(stock_act) AS 'stock' FROM stocks WHERE cod_suc = 1 AND cod_prod =  '{$row['cod_prod']}'";
        $row['stock']=0;
        $rsul = $conexion->query($sql);
        if ($row2 = $rsul->fetch_assoc()){
            $row['stock'] = $row2['stock'];
        }
        $respuesta=$row;
    }

}
elseif($tipo == 'prodCate'){
    $cod_cate = $_POST['codcate'];
    //echo $cod_cate;
    $arrC = explode("-", $cod_cate);
    $ccond ="";
    foreach ($arrC as $von){
        $ccond = $ccond ."  sopprod.cod_cate ='$von' OR";
    }
    $restee = substr($ccond, 0, -2);
    $sql="SELECT 
  precios.cod_prod,
  precios.cod_suc,
  precios.precio_venta,
  sopprod.cod_cate,
  sopprod.cod_subc,
  sopprod.cod_espe,
  sopprod.nom_prod,
  sopprod.nom_unid,
  sopsub1.nom_sub1,
  sopsub2.nom_sub2
FROM
  precios 
  INNER JOIN sopprod 
    ON precios.cod_prod = sopprod.cod_prod 
    INNER JOIN sopsub1 ON sopprod.cod_cate = sopsub1.cod_sub1
    INNER JOIN sopsub2 ON sopprod.cod_subc = sopsub2.cod_sub2
WHERE precios.cod_suc = 1 
  AND sopprod.cod_clasi != '00' 
    AND $restee";

   // echo $sql;

    $res = $conexion->query($sql);
    while ($row = $res->fetch_assoc()){
        $sql="SELECT SUM(stock_act) AS 'stock' FROM stocks WHERE cod_suc = 1 AND cod_prod =  '{$row['cod_prod']}'";
        $row['stock']=0;
        $rsul = $conexion->query($sql);
        if ($row2 = $rsul->fetch_assoc()){
            $row['stock'] = $row2['stock'];
        }
        $respuesta[]=$row;
    }

}elseif($tipo == 'prodCateMarc'){
    $cod_cate = $_POST['codcate'];
    $cod_marca = $_POST['codmarca'];

    $sql="SELECT 
  precios.cod_prod,
  precios.cod_suc,
  precios.precio_venta,
  sopprod.cod_cate,
  sopprod.cod_subc,
  sopprod.cod_espe,
  sopprod.nom_prod,
  sopprod.nom_unid,
  sopsub1.nom_sub1,
  sopsub2.nom_sub2
FROM
  precios 
  INNER JOIN sopprod 
    ON precios.cod_prod = sopprod.cod_prod 
    INNER JOIN sopsub1 ON sopprod.cod_cate = sopsub1.cod_sub1
    INNER JOIN sopsub2 ON sopprod.cod_subc = sopsub2.cod_sub2
WHERE precios.cod_suc = 1 
  AND sopprod.cod_clasi != '00' 
  AND sopprod.cod_cate ='$cod_cate'
  AND sopprod.cod_subc ='$cod_marca' ";

    $res = $conexion->query($sql);
    while ($row = $res->fetch_assoc()){
        $sql="SELECT SUM(stock_act) AS 'stock' FROM stocks WHERE cod_suc = 1 AND cod_prod =  '{$row['cod_prod']}'";
        $row['stock']=0;
        $rsul = $conexion->query($sql);
        if ($row2 = $rsul->fetch_assoc()){
            $row['stock'] = $row2['stock'];
        }
        $respuesta[]=$row;
    }

}elseif ($tipo=='prodliscod'){
    $prodCod = $_POST['cod_prod'];
    $arr = explode("-", $prodCod);
   // $respuesta = $arr;
    $condconsul ="";
    $respuesta=[];
    foreach ($arr as $roArr){
        $condconsul = "  AND precios.cod_prod='".$roArr."' ";
        $sql ="SELECT 
  precios.cod_prod,
  precios.cod_suc,
  precios.precio_venta,
  sopprod.cod_cate,
  sopprod.cod_subc,
  sopprod.cod_espe,
  sopprod.nom_prod,
  sopprod.nom_unid,
  sopsub1.nom_sub1,
  sopsub2.nom_sub2
FROM
  precios 
  INNER JOIN sopprod 
    ON precios.cod_prod = sopprod.cod_prod 
    INNER JOIN sopsub1 ON sopprod.cod_cate = sopsub1.cod_sub1
    INNER JOIN sopsub2 ON sopprod.cod_subc = sopsub2.cod_sub2
WHERE precios.cod_suc = 1 
  AND sopprod.cod_clasi != '00'
  $condconsul";
        $resss = $conexion->query($sql);
        if ($roww = $resss->fetch_assoc()){
            $sql="SELECT SUM(stock_act) AS 'stock' FROM stocks WHERE cod_suc = 1 AND cod_prod =  '{$roww['cod_prod']}'";
            $roww['stock']=0;
            $rsul = $conexion->query($sql);
            if ($row2 = $rsul->fetch_assoc()){
                $roww['stock'] = $row2['stock'];
            }
            $respuesta[]=$roww;
        }

    }

    /*$sql ="SELECT
  precios.cod_prod,
  precios.cod_suc,
  precios.precio_venta,
  sopprod.cod_cate,
  sopprod.cod_subc,
  sopprod.cod_espe,
  sopprod.nom_prod,
  sopprod.nom_unid,
  sopsub1.nom_sub1,
  sopsub2.nom_sub2
FROM
  precios 
  INNER JOIN sopprod 
    ON precios.cod_prod = sopprod.cod_prod 
    INNER JOIN sopsub1 ON sopprod.cod_cate = sopsub1.cod_sub1
    INNER JOIN sopsub2 ON sopprod.cod_subc = sopsub2.cod_sub2
WHERE precios.cod_suc = 1 
  AND sopprod.cod_clasi != '00'
  $condconsul";
    echo $sql;*/


}

echo json_encode($respuesta);






