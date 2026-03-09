<?php
require_once "../utils/Conexion.php";

class ProductosApi
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = (new Conexion())->getConexion();
    }

    public function getDataProd($cod_prod, $filtro){
        $respuesta =[];

        $sql="SELECT 
                  precios.cod_prod,
                  precios.cod_suc,
                  (CASE WHEN '$filtro'='' THEN precios.precio_venta 
		  WHEN   '$filtro'='vp' THEN precios.precio_tres 
		  WHEN   '$filtro'='dt' THEN precios.precio_mayor 

			ELSE 0 END) AS precio_venta,

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
        $res = $this->conexion->query($sql);

        if ($row = $res->fetch_assoc()){
            $sql="SELECT SUM(stock_act) AS 'stock' FROM stocks WHERE (cod_alma='109' OR cod_alma='105' OR cod_alma ='101' OR cod_alma = '301' ) AND cod_prod =  '{$row['cod_prod']}'";
            $row['stock']=0;
            $rsul = $this->conexion->query($sql);
            if ($row2 = $rsul->fetch_assoc()){
                $row['stock'] = $row2['stock'];
            }
            $respuesta=$row;
        }

        return $respuesta;
    }
    public function getinfoData($prodCod){

        $arr = explode("-", $prodCod);
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

            //var_dump($sql);

            $resss = $this->conexion->query($sql);
            if ($roww = $resss->fetch_assoc()){
                $sql="SELECT SUM(stock_act) AS 'stock' FROM stocks WHERE (cod_alma='109' OR cod_alma='105' OR cod_alma ='101' OR cod_alma = '301' ) AND cod_prod =  '{$roww['cod_prod']}'";
                $roww['stock']=0;
                $rsul = $this->conexion->query($sql);
                if ($row2 = $rsul->fetch_assoc()){
                    $roww['stock'] = $row2['stock'];
                }
                $respuesta[]=$roww;
            }

        }
        return $respuesta;
    }
    public function getProdCateMarc($cod_cate,$cod_marca){
        $respuesta=[];

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

        $res = $this->conexion->query($sql);
        while ($row = $res->fetch_assoc()){
            $sql="SELECT SUM(stock_act) AS 'stock' FROM stocks WHERE (cod_alma='109' OR cod_alma='105' OR cod_alma ='101' OR cod_alma = '301' ) AND cod_prod =  '{$row['cod_prod']}'";
            $row['stock']=0;
            $rsul = $this->conexion->query($sql);
            if ($row2 = $rsul->fetch_assoc()){
                $row['stock'] = $row2['stock'];
            }
            $respuesta[]=$row;
        }
        return $respuesta;
    }

    public function getDataCatego($cod_cate){

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

        $res = $this->conexion->query($sql);
        while ($row = $res->fetch_assoc()){
            $sql="SELECT SUM(stock_act) AS 'stock' FROM stocks WHERE (cod_alma='109' OR cod_alma='105' OR cod_alma ='101' OR cod_alma = '301' ) AND cod_prod =  '{$row['cod_prod']}'";
            $row['stock']=0;
            $rsul = $this->conexion->query($sql);
            if ($row2 = $rsul->fetch_assoc()){
                $row['stock'] = $row2['stock'];
            }
            $respuesta[]=$row;
        }

        return $respuesta;
    }
}