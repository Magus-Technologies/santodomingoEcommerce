<?php
require_once "../utils/Conexion.php";
/* require_once "../utils/Conexion2.php"; */
require "../model/Producto.php";
/* require_once "../extra/ProductosApi.php"; */



class ProductoDao extends Producto
{
    private $conexion;
    /*     private $productosApi;
    private $web;
    private $compuvision; */

    public function __construct()
    {
        $this->conexion = (new Conexion())->getConexion();
        /*     $this->conexion2 = (new Conexion2())->getConexion();
        $this->web = (new Conexion())->getBd();
        $this->compuvision = (new Conexion2())->getBd();
        $this->productosApi = new ProductosApi(); */
    }

    public function getCountProd()
    {
        $sql = "SELECT COUNT(*) AS'count_prod' FROM producto  ";
        return $this->conexion->query($sql);
    }
    public function getProdPag($minId, $cnt)
    {
        $sql = "SELECT producto.prod_id,producto.prod_cod FROM producto WHERE producto.prod_id>$minId ORDER BY producto.prod_id  ASC  LIMIT $cnt";
        return $this->conexion->query($sql);
    }
    public function getProdPagGate($categ)
    {
        // $sql="SELECT producto.* FROM producto WHERE producto.prod_id>$minId  AND producto.categoria='$categ' ORDER BY producto.prod_id  ASC  LIMIT $cnt";

        $sql = "SELECT   producto.content1,
  producto.content2,
  producto.content3,
  producto.nombre,
  producto.prod_id,
  producto.descripcion,
  producto.prod_cod,
  producto.sub_cat FROM producto WHERE   producto.categoria ='$categ' AND producto.estado = 1";
        return $this->conexion->query($sql);
    }
    public function getProdPagGruMar($minId, $cnt, $grupo, $marca)
    {
        //$sql="SELECT producto.prod_id,producto.prod_cod FROM producto WHERE producto.prod_id>$minId  AND producto.categoria='$categ' ORDER BY producto.prod_id  ASC  LIMIT $cnt";

        $sql = "SELECT 
  producto.*
  
FROM
  producto 
  INNER JOIN grupo_seleccion AS catego 
    ON producto.categoria = catego.codi_categoria 
WHERE producto.prod_id > $minId 
  AND producto.marca = '$marca'
  AND catego.codi_categoria = '$grupo' 
ORDER BY producto.prod_id ASC  LIMIT $cnt
";
        //echo $sql;
        return $this->conexion->query($sql);
    }
    public function getProdPagGruMarCount($grupo, $marca)
    {

        $sql = "SELECT 
  COUNT(producto.prod_id) AS'count_prod'
FROM
  producto 
  INNER JOIN grupo_seleccion AS catego 
    ON producto.categoria = catego.codi_categoria 
WHERE 
   producto.marca = '$marca'
   AND   catego.codi_categoria = '$grupo' ";
        //echo $sql;
        return $this->conexion->query($sql);
    }
    public function getProdPagGruCatCount($cate)
    {

        $sql = "SELECT 
  COUNT(producto.prod_id) AS'count_prod'
FROM
  producto  
WHERE 
   producto.categoria = '$cate' ";
        return $this->conexion->query($sql);
    }
    public function getData22()
    {
        $sql = "SELECT * FROM producto WHERE producto.prod_id=" . $this->getProdId();
        $dataR = [];
        $res =  $this->conexion->query($sql);
        if ($row = $res->fetch_assoc()) {

            $row['categoria_cod'] = $row['categoria'];
            $row['marca_cod'] =  $row['marca'];
            $row['imagenes'] = [];
            $sql = "SELECT * FROM producto_foto WHERE prod_id = {$row['prod_id']} ORDER BY  orden ";
            $resIma = $this->conexion->query($sql);
            foreach ($resIma as $rowIma) {
                $row['imagenes'][] = $rowIma;
            }
            $dataR = $row;
        }
        return $dataR;
    }
    public function getData()
    {
        $sql = "SELECT * FROM producto WHERE  producto.prod_id=" . $this->getProdId();
        $dataR = [];
        $res =  $this->conexion->query($sql);
        if ($row = $res->fetch_assoc()) {
            $conRay = $this->getDataProd($row['prod_cod']);
            $row['cod_esp'] = $conRay['cod_espe'];
            $row['nom_prod'] = $conRay['nom_prod'];
            $row['unidad'] = $conRay['nom_unid'];
            $row['precio'] = $conRay['precio_venta'];
            $row['stock'] = $conRay['stock'];
            $row['categoria_cod'] = $row['categoria'];
            $row['marca_cod'] =  $row['marca'];
            $row['marca'] = $conRay['nom_sub2'];
            $row['categoria'] = $conRay['nom_sub1'];
            $row['imagenes'] = [];
            $sql = "SELECT * FROM producto_foto WHERE prod_id = {$row['prod_id']} ORDER BY  orden ";
            $resIma = $this->conexion->query($sql);
            foreach ($resIma as $rowIma) {
                $row['imagenes'][] = $rowIma;
            }
            $sql3 = "SELECT * FROM ofertas_productos WHERE  fecha_termino >= NOW() AND estado ='1' AND producto_id = " . $this->getProdId();
            $respOfer = $this->getDataExeSQL($sql3);
            if ($respOfer->num_rows > 0) {
                foreach ($respOfer as $rowNice) {
                    $precio¡ = $rowNice['precio_oferta'];
                    /*  $precioOferta[] =  array(
                        'id' => $row['producto_id'],
                        'oferta' => $row['precio_oferta']
                    ); */
                    /*   array_push($row['precio_oferta'],  $rowNice['precio_oferta']); */
                    /* array_splice($row,0,0,array('precio_oferta' => $rowNice['precio_oferta']));
                    array_splice() */
                    $row['precio_oferta'] = $rowNice['precio_oferta'];
                }
            }

            $dataR = $row;
        }
        return $dataR;
    }
    public function getData2()
    {
        $sql = "SELECT * FROM producto WHERE producto.prod_id=" . $this->getProdId();
        $dataR = [];
        $res =  $this->conexion->query($sql);
        if ($row = $res->fetch_assoc()) {

            $row['imagenes'] = [];
            $sql = "SELECT * FROM producto_foto WHERE prod_id = {$row['prod_id']} ORDER BY  orden ";
            $resIma = $this->conexion->query($sql);
            foreach ($resIma as $rowIma) {
                $row['imagenes'][] = $rowIma;
            }
            $dataR = $row;
        }
        return $dataR;
    }
    public function getDataCopare()
    {

        $sql = "SELECT * FROM producto  WHERE  marca ='{$this->getMarca()}' AND categoria = '{$this->getCategoria()}' AND prod_id !='{$this->getProdId()}'  ORDER BY RAND() LIMIT 2 ";
        //echo $sql;
        $dataR = [];
        $res =  $this->conexion->query($sql);
        $codConsulta = "";
        while ($row = $res->fetch_assoc()) {
            $codConsulta = $codConsulta . $row['prod_cod'] . "-";
            $row['imagen1'] = '';
            $row['imagen2'] = '';

            $sql = "SELECT * FROM producto_foto WHERE prod_id = {$row['prod_id']} ORDER BY  orden ASC LIMIT 2";

            $respImg = $this->conexion->query($sql);
            $cont = 1;
            foreach ($respImg as $rowImg) {
                if ($cont == 1) {
                    $row['imagen1'] = $rowImg['imagen_url'];
                } elseif ($cont == 2) {
                    $row['imagen2'] = $rowImg['imagen_url'];
                }
                $cont++;
            }
            $row['imagen1'] = strlen($row['imagen1']) > 0 ? $row['imagen1'] : 'sinimagen_mtr_20sba.jpg';
            $row['imagen2'] = strlen($row['imagen2']) > 0 ? $row['imagen2'] : 'sinimagen_mtr_20sba.jpg';

            $dataR[] = $row;
        }
        $codConsulta = substr($codConsulta, 0, -1);
        //echo $codConsulta;



        $tempListData = $this->getinfoData($codConsulta);
        // $key = array_search($dataR[3]['prod_cod'], array_column($tempListData, 'cod_prod'));
        //print_r($tempListData[$key]);
        $reslFinalR = [];
        foreach ($dataR as $rowP) {
            $key = array_search($rowP['prod_cod'], array_column($tempListData, 'cod_prod'));
            $tempD = $tempListData[$key];

            $rowP['cod_esp'] = $tempD['cod_espe'];
            $rowP['nom_prod'] = $tempD['nom_prod'];
            $rowP['unidad'] = $tempD['nom_unid'];
            $rowP['precio'] = $tempD['precio_venta'];
            $rowP['stock'] = $tempD['stock'];
            $rowP['marca'] = $tempD['nom_sub2'];
            $rowP['categoria'] = $tempD['nom_sub1'];
            $reslFinalR[] = $rowP;
        }
        return $reslFinalR;
    }
    public function getListaProd()
    {
        $sql = "SELECT * FROM producto ";
        $dataR = [];
        $res =  $this->conexion->query($sql);
        $codConsulta = "";
        while ($row = $res->fetch_assoc()) {
            $codConsulta = $codConsulta . $row['prod_cod'] . "-";
            $row['imagen1'] = '';
            $row['imagen2'] = '';

            $sql = "SELECT * FROM producto_foto WHERE prod_id = {$row['prod_id']} ORDER BY  orden ASC LIMIT 2";

            $respImg = $this->conexion->query($sql);
            $cont = 1;
            foreach ($respImg as $rowImg) {
                if ($cont == 1) {
                    $row['imagen1'] = $rowImg['imagen_url'];
                } elseif ($cont == 2) {
                    $row['imagen2'] = $rowImg['imagen_url'];
                }
                $cont++;
            }
            $row['imagen1'] = strlen($row['imagen1']) > 0 ? $row['imagen1'] : 'sinimagen_mtr_20sba.jpg';
            $row['imagen2'] = strlen($row['imagen2']) > 0 ? $row['imagen2'] : 'sinimagen_mtr_20sba.jpg';

            $dataR[] = $row;
        }
        $codConsulta = substr($codConsulta, 0, -1);
        //echo $codConsulta;

        $tempListData = $this->getinfoData($codConsulta);
        // $key = array_search($dataR[3]['prod_cod'], array_column($tempListData, 'cod_prod'));
        //print_r($tempListData[$key]);
        $reslFinalR = [];
        foreach ($dataR as $rowP) {
            $key = array_search($rowP['prod_cod'], array_column($tempListData, 'cod_prod'));
            $tempD = $tempListData[$key];

            $rowP['cod_esp'] = $tempD['cod_espe'];
            $rowP['nom_prod'] = $tempD['nom_prod'];
            $rowP['unidad'] = $tempD['nom_unid'];
            $rowP['precio'] = $tempD['precio_venta'];
            $rowP['stock'] = $tempD['stock'];
            $rowP['marca'] = $tempD['nom_sub2'];
            $rowP['categoria'] = $tempD['nom_sub1'];
            $reslFinalR[] = $rowP;
        }
        return $reslFinalR;
    }
    public function getListaProdRemate()
    {
        $sql = " SELECT * FROM producto WHERE tipo_pro = '2'";
        $dataR = [];
        $res =  $this->conexion->query($sql);
        $codConsulta = "";
        while ($row = $res->fetch_assoc()) {
            $codConsulta = $codConsulta . $row['prod_cod'] . "-";
            $row['imagen1'] = '';
            $row['imagen2'] = '';

            $sql = "SELECT * FROM producto_foto WHERE prod_id = {$row['prod_id']} ORDER BY  orden ASC LIMIT 2";

            $respImg = $this->conexion->query($sql);
            $cont = 1;
            foreach ($respImg as $rowImg) {
                if ($cont == 1) {
                    $row['imagen1'] = $rowImg['imagen_url'];
                } elseif ($cont == 2) {
                    $row['imagen2'] = $rowImg['imagen_url'];
                }
                $cont++;
            }
            $row['imagen1'] = strlen($row['imagen1']) > 0 ? $row['imagen1'] : 'sinimagen_mtr_20sba.jpg';
            $row['imagen2'] = strlen($row['imagen2']) > 0 ? $row['imagen2'] : 'sinimagen_mtr_20sba.jpg';

            $dataR[] = $row;
        }

        $reslFinalR = [];
        foreach ($dataR as $rowP) {
            $sql = "SELECT nombre_marca FROM marcra_productos WHERE cod_marca = '{$rowP['marca']}'";
            $res__ =  $this->conexion->query($sql);
            $rowP['nombre_marca'] = '';
            if ($row__ = $res__->fetch_assoc()) {
                $rowP['nombre_marca'] = $row__['nombre_marca'];
            }
            $reslFinalR[] = $rowP;
        }
        return $reslFinalR;
    }

    public function getFiltrosProductos3Search($pal)
    {
        $sql = "SELECT
    prodod.*
FROM (SELECT
             producto.prod_cod,
          mp.nombre_marca,
             mp.cod_marca
                FROM
          producto
join marcra_productos mp on producto.marca = mp.cod_marca
      WHERE producto.estado = 1 AND producto.nombre LIKE '%$pal%' ORDER BY producto.prod_id DESC

     ) prodod
         JOIN precios
              ON precios.cod_prod = prodod.prod_cod
                  AND precios.cod_suc = 1
GROUP BY prodod.nombre_marca";
        $respuesta = $this->conexion->query($sql);
        $lista = [];
        foreach ($respuesta as $item) {
            $lista[] = ["cod" => $item['cod_marca'], "nombre" => $item['nombre_marca']];
        }
        return $lista;
    }

    public function getListaProd3SearchPag($pals, $tipo, $cnthp, $actual, $minUSD, $maxISD)
    {
        $actual = $actual * $cnthp;
        $limitador = ' limit ' . $actual . ',' . $cnthp;
        if ($tipo == 'last') {
            $limitador = ' order by temp.prod_id desc  limit ' . $actual . ',' . $cnthp;
        }
        $contLimits = '';
        if ($pals == '') {
            $contLimits = 'LIMIT 400';
        }

        $listaMArcas = json_decode($_POST['marcasFilt'], true);
        $listaTempMarc = [];

        foreach ($listaMArcas as $marcc) {
            $listaTempMarc[] = " producto.marca='$marcc' ";
        }
        if (count($listaTempMarc) > 0) {
            $listaTempMarc = " AND (" . implode(" OR ", $listaTempMarc) . ") ";
        } else {
            $listaTempMarc = '';
        }


        $sql = "SELECT  SQL_CALC_FOUND_ROWS
  temp.*,
  SUM(`stocks`.`stock_act`) AS `stock` 
FROM
  (SELECT 
    prodod.*, precios.precio_cuatro precio
  FROM
    (SELECT 
      producto.content1,
      producto.content2,
      producto.content3,
      producto.nombre,
      producto.prod_id,
      producto.prod_cod,
      producto.sub_cat,
      producto.estado 
    FROM
      producto 
    WHERE producto.estado = 1 AND producto.nombre LIKE '%$pals%' $listaTempMarc ORDER BY producto.prod_id DESC  $contLimits) prodod 
    
    JOIN precios 
      ON precios.cod_prod = prodod.prod_cod 
      AND precios.cod_suc = 1 
  GROUP BY prodod.prod_cod) temp 
  JOIN `stocks` 
    ON (
      `stocks`.`cod_prod` = `temp`.`prod_cod` 
       AND (cod_alma='109' OR cod_alma='105' OR cod_alma ='101' OR cod_alma = '301' )
    ) 
    AND stocks.stock_act > 0 where temp.precio between $minUSD and $maxISD  GROUP BY temp.prod_cod $limitador";

        /*$sql = "SELECT SQL_CALC_FOUND_ROWS
        producto.content1,
        producto.content2,
        producto.content3,
        producto.nombre,
        producto.prod_id,
        producto.prod_cod,
        producto.sub_cat,
        producto.estado,
        sc.nombre AS 'sub_cat',
        gs.nombre_cate,mp.nombre_marca,
        SUM(IF(`stocks`.`stock_act` IS NULL,0,`stocks`.`stock_act`)) AS `stock`
             
             
      FROM
        producto  LEFT JOIN sub_categoria sc ON producto.sub_cat = sc.sub_id
      LEFT JOIN grupo_seleccion gs ON producto.categoria = gs.codi_categoria
      LEFT JOIN marcra_productos mp ON producto.marca = mp.cod_marca 
      LEFT JOIN `stocks`
           ON (`stocks`.`cod_prod` = `producto`.`prod_cod`
               AND `stocks`.`cod_suc` = 1)
      WHERE  producto.nombre LIKE '%$pals%' AND producto.estado =1  AND stocks.stock_act>0
      GROUP BY producto.prod_cod $limitador 
";*/
        // echo $sql;


        $dataR = [];
        $res =  $this->conexion->query($sql);

        $cantidadRows = $this->conexion->query("SELECT FOUND_ROWS() AS coun")
            ->fetch_assoc()["coun"];

        $codConsulta = "";
        while ($row = $res->fetch_assoc()) {
            $codConsulta = $codConsulta . $row['prod_cod'] . "-";
            $row['imagen1'] = '';
            $row['imagen2'] = '';
            $row['is_ofert'] = false;

            $sql = "SELECT * FROM ofertas_productos WHERE  fecha_termino >= NOW() AND estado ='1' AND producto_id = " . $row['prod_id'];
            $respOfer = $this->getDataExeSQL($sql);
            if ($rowOffer = $respOfer->fetch_assoc()) {
                $row['is_ofert'] = true;
                $row['precio_ofer'] = $rowOffer['precio_oferta'];
            }
            $sql = "SELECT * FROM producto_foto WHERE prod_id = {$row['prod_id']} ORDER BY  orden ASC LIMIT 2";

            $respImg = $this->conexion->query($sql);
            $cont = 1;
            foreach ($respImg as $rowImg) {
                if ($cont == 1) {
                    $row['imagen1'] = $rowImg['imagen_url'];
                } elseif ($cont == 2) {
                    $row['imagen2'] = $rowImg['imagen_url'];
                }
                $cont++;
            }
            $row['imagen1'] = strlen($row['imagen1']) > 0 ? $row['imagen1'] : 'sinimagen_mtr_20sba.jpg';
            $row['imagen2'] = strlen($row['imagen2']) > 0 ? $row['imagen2'] : 'sinimagen_mtr_20sba.jpg';

            $dataR[] = $row;
        }
        $codConsulta = substr($codConsulta, 0, -1);
        //echo $codConsulta;


        /*$tempListData = $this->getinfoData($codConsulta);
        // $key = array_search($dataR[3]['prod_cod'], array_column($tempListData, 'cod_prod'));
        //print_r($tempListData[$key]);
        $reslFinalR = [];
        foreach ($dataR as $rowP) {
            $key = array_search($rowP['prod_cod'], array_column($tempListData, 'cod_prod'));
            $tempD = $tempListData[$key];

            $rowP['cod_esp'] = $tempD['cod_espe'];
            $rowP['nom_prod'] = $tempD['nom_prod'];
            $rowP['unidad'] = $tempD['nom_unid'];
            $rowP['precio'] = $tempD['precio_venta'];
            $rowP['stock'] = $tempD['stock'];
            $rowP['marca'] = $tempD['nom_sub2'];
            $rowP['categoria'] = $tempD['nom_sub1'];
            $reslFinalR[] = $rowP;
        }*/

        return ["datas" => $dataR, "cnt" => $cantidadRows];
        //return $reslFinalR;
    }

    public function getListaProd3Search($pals, $tipo)
    {
        $limitador = '';
        if ($tipo == 'last') {
            $limitador = ' order by producto.prod_id desc limit 300';
        }
        $sql = "SELECT 
        producto.content1,
        producto.content2,
        producto.content3,
        producto.nombre,
        producto.prod_id,
        producto.prod_cod,
        producto.sub_cat,
        producto.estado,
        sc.nombre AS 'sub_cat',
        gs.nombre_cate,mp.nombre_marca,
        SUM(IF(`stocks`.`stock_act` IS NULL,0,`stocks`.`stock_act`)) AS `stock`
             
             
      FROM
        producto  LEFT JOIN sub_categoria sc ON producto.sub_cat = sc.sub_id
      LEFT JOIN grupo_seleccion gs ON producto.categoria = gs.codi_categoria
      LEFT JOIN marcra_productos mp ON producto.marca = mp.cod_marca 
      LEFT JOIN `stocks`
           ON (`stocks`.`cod_prod` = `producto`.`prod_cod`
               AND `stocks`.`cod_suc` = 1)
      WHERE  producto.nombre LIKE '%$pals%' AND producto.estado =1  AND stocks.stock_act>0
      GROUP BY producto.prod_cod $limitador 
";

        $dataR = [];
        $res =  $this->conexion->query($sql);
        $codConsulta = "";
        while ($row = $res->fetch_assoc()) {
            $codConsulta = $codConsulta . $row['prod_cod'] . "-";
            $row['imagen1'] = '';
            $row['imagen2'] = '';
            $row['is_ofert'] = false;

            $sql = "SELECT * FROM ofertas_productos WHERE  fecha_termino >= NOW() AND estado ='1' AND producto_id = " . $row['prod_id'];
            $respOfer = $this->getDataExeSQL($sql);
            if ($rowOffer = $respOfer->fetch_assoc()) {
                $row['is_ofert'] = true;
                $row['precio_ofer'] = $rowOffer['precio_oferta'];
            }
            $sql = "SELECT * FROM producto_foto WHERE prod_id = {$row['prod_id']} ORDER BY  orden ASC LIMIT 2";

            $respImg = $this->conexion->query($sql);
            $cont = 1;
            foreach ($respImg as $rowImg) {
                if ($cont == 1) {
                    $row['imagen1'] = $rowImg['imagen_url'];
                } elseif ($cont == 2) {
                    $row['imagen2'] = $rowImg['imagen_url'];
                }
                $cont++;
            }
            $row['imagen1'] = strlen($row['imagen1']) > 0 ? $row['imagen1'] : 'sinimagen_mtr_20sba.jpg';
            $row['imagen2'] = strlen($row['imagen2']) > 0 ? $row['imagen2'] : 'sinimagen_mtr_20sba.jpg';

            $dataR[] = $row;
        }
        $codConsulta = substr($codConsulta, 0, -1);
        //echo $codConsulta;


        $tempListData = $this->getinfoData($codConsulta);
        // $key = array_search($dataR[3]['prod_cod'], array_column($tempListData, 'cod_prod'));
        //print_r($tempListData[$key]);
        $reslFinalR = [];
        foreach ($dataR as $rowP) {
            $key = array_search($rowP['prod_cod'], array_column($tempListData, 'cod_prod'));
            $tempD = $tempListData[$key];

            $rowP['cod_esp'] = $tempD['cod_espe'];
            $rowP['nom_prod'] = $tempD['nom_prod'];
            $rowP['unidad'] = $tempD['nom_unid'];
            $rowP['precio'] = $tempD['precio_venta'];
            $rowP['stock'] = $tempD['stock'];
            $rowP['marca'] = $tempD['nom_sub2'];
            $rowP['categoria'] = $tempD['nom_sub1'];
            $reslFinalR[] = $rowP;
        }
        return $reslFinalR;
    }
    public function getListaProd2Search($pals)
    {
        $sql = "SELECT 
        producto.content1,
        producto.content2,
        producto.content3,
        producto.nombre,
        producto.prod_id,
        producto.prod_cod,
        producto.sub_cat,
        producto.estado,
        sc.nombre AS 'sub_cat',
        gs.nombre_cate,mp.nombre_marca,
        SUM(IF(`stocks`.`stock_act` IS NULL,0,`stocks`.`stock_act`)) AS `stock`
             
             
      FROM
        producto  LEFT JOIN sub_categoria sc ON producto.sub_cat = sc.sub_id
      LEFT JOIN grupo_seleccion gs ON producto.categoria = gs.codi_categoria
      LEFT JOIN marcra_productos mp ON producto.marca = mp.cod_marca 
      LEFT JOIN `stocks`
           ON (`stocks`.`cod_prod` = `producto`.`prod_cod`
               AND `stocks`.`cod_suc` = 1)
      WHERE  producto.nombre LIKE '%$pals%' AND producto.estado =1 
      GROUP BY producto.prod_cod
";
        $dataR = [];
        $res =  $this->conexion->query($sql);
        $codConsulta = "";
        while ($row = $res->fetch_assoc()) {
            $codConsulta = $codConsulta . $row['prod_cod'] . "-";
            $row['imagen1'] = '';
            $row['imagen2'] = '';
            $row['is_ofert'] = false;

            $sql = "SELECT * FROM ofertas_productos WHERE  fecha_termino >= NOW() AND estado ='1' AND producto_id = " . $row['prod_id'];
            $respOfer = $this->getDataExeSQL($sql);
            if ($rowOffer = $respOfer->fetch_assoc()) {
                $row['is_ofert'] = true;
                $row['precio_ofer'] = $rowOffer['precio_oferta'];
            }
            $sql = "SELECT * FROM producto_foto WHERE prod_id = {$row['prod_id']} ORDER BY  orden ASC LIMIT 2";

            $respImg = $this->conexion->query($sql);
            $cont = 1;
            foreach ($respImg as $rowImg) {
                if ($cont == 1) {
                    $row['imagen1'] = $rowImg['imagen_url'];
                } elseif ($cont == 2) {
                    $row['imagen2'] = $rowImg['imagen_url'];
                }
                $cont++;
            }
            $row['imagen1'] = strlen($row['imagen1']) > 0 ? $row['imagen1'] : 'sinimagen_mtr_20sba.jpg';
            $row['imagen2'] = strlen($row['imagen2']) > 0 ? $row['imagen2'] : 'sinimagen_mtr_20sba.jpg';

            $dataR[] = $row;
        }
        $codConsulta = substr($codConsulta, 0, -1);
        //echo $codConsulta;


        $tempListData = $this->getinfoData($codConsulta);
        // $key = array_search($dataR[3]['prod_cod'], array_column($tempListData, 'cod_prod'));
        //print_r($tempListData[$key]);
        $reslFinalR = [];
        foreach ($dataR as $rowP) {
            $key = array_search($rowP['prod_cod'], array_column($tempListData, 'cod_prod'));
            $tempD = $tempListData[$key];

            $rowP['cod_esp'] = $tempD['cod_espe'];
            $rowP['nom_prod'] = $tempD['nom_prod'];
            $rowP['unidad'] = $tempD['nom_unid'];
            $rowP['precio'] = $tempD['precio_venta'];
            $rowP['stock'] = $tempD['stock'];
            $rowP['marca'] = $tempD['nom_sub2'];
            $rowP['categoria'] = $tempD['nom_sub1'];
            $reslFinalR[] = $rowP;
        }
        return $reslFinalR;
    }
    public function getListaProd2()
    {
        $sql = "SELECT 
  producto.content1,
  producto.content2,
  producto.content3,
  producto.nombre,
  producto.prod_id,
  producto.prod_cod,
  producto.sub_cat,
       sc.nombre as 'sub_cat'
FROM
  producto  left join sub_categoria sc on producto.sub_cat = sc.sub_id ";
        $dataR = [];
        $res =  $this->conexion->query($sql);
        $codConsulta = "";
        while ($row = $res->fetch_assoc()) {
            $codConsulta = $codConsulta . $row['prod_cod'] . "-";
            $row['imagen1'] = '';
            $row['imagen2'] = '';
            $row['is_ofert'] = false;

            $sql = "SELECT * FROM ofertas_productos WHERE  fecha_termino >= NOW() AND producto_id = " . $row['prod_id'];
            $respOfer = $this->getDataExeSQL($sql);
            if ($rowOffer = $respOfer->fetch_assoc()) {
                $row['is_ofert'] = true;
                $row['precio_ofer'] = $rowOffer['precio_oferta'];
            }
            $sql = "SELECT * FROM producto_foto WHERE prod_id = {$row['prod_id']} ORDER BY  orden ASC LIMIT 2";

            $respImg = $this->conexion->query($sql);
            $cont = 1;
            foreach ($respImg as $rowImg) {
                if ($cont == 1) {
                    $row['imagen1'] = $rowImg['imagen_url'];
                } elseif ($cont == 2) {
                    $row['imagen2'] = $rowImg['imagen_url'];
                }
                $cont++;
            }
            $row['imagen1'] = strlen($row['imagen1']) > 0 ? $row['imagen1'] : 'sinimagen_mtr_20sba.jpg';
            $row['imagen2'] = strlen($row['imagen2']) > 0 ? $row['imagen2'] : 'sinimagen_mtr_20sba.jpg';

            $dataR[] = $row;
        }
        $codConsulta = substr($codConsulta, 0, -1);
        //echo $codConsulta;


        $tempListData = $this->getinfoData($codConsulta);
        // $key = array_search($dataR[3]['prod_cod'], array_column($tempListData, 'cod_prod'));
        //print_r($tempListData[$key]);
        $reslFinalR = [];
        foreach ($dataR as $rowP) {
            $key = array_search($rowP['prod_cod'], array_column($tempListData, 'cod_prod'));
            $tempD = $tempListData[$key];

            $rowP['cod_esp'] = $tempD['cod_espe'];
            $rowP['nom_prod'] = $tempD['nom_prod'];
            $rowP['unidad'] = $tempD['nom_unid'];
            $rowP['precio'] = $tempD['precio_venta'];
            $rowP['stock'] = $tempD['stock'];
            $rowP['marca'] = $tempD['nom_sub2'];
            $rowP['categoria'] = $tempD['nom_sub1'];
            $reslFinalR[] = $rowP;
        }
        return $reslFinalR;
    }
    public function getListaProdmarc($marca)
    {
        $sql = "SELECT 
  producto.content1,
  producto.content2,
  producto.content3,
  producto.nombre,
  producto.prod_id,
  producto.prod_cod,
  producto.sub_cat 
FROM
  producto WHERE   producto.marca='$marca'";
        //echo $sql;
        $dataR = [];
        $res =  $this->conexion->query($sql);
        $codConsulta = "";
        while ($row = $res->fetch_assoc()) {
            $codConsulta = $codConsulta . $row['prod_cod'] . "-";
            $row['imagen1'] = '';
            $row['imagen2'] = '';
            $row['is_ofert'] = false;

            $sql = "SELECT * FROM ofertas_productos WHERE  fecha_termino >= NOW() AND  producto_id = " . $row['prod_id'];
            $respOfer = $this->getDataExeSQL($sql);
            if ($rowOffer = $respOfer->fetch_assoc()) {
                $row['is_ofert'] = true;
                $row['precio_ofer'] = $rowOffer['precio_oferta'];
            }

            $sql = "SELECT * FROM producto_foto WHERE prod_id = {$row['prod_id']} ORDER BY  orden ASC LIMIT 2";

            $respImg = $this->conexion->query($sql);
            $cont = 1;
            foreach ($respImg as $rowImg) {
                if ($cont == 1) {
                    $row['imagen1'] = $rowImg['imagen_url'];
                } elseif ($cont == 2) {
                    $row['imagen2'] = $rowImg['imagen_url'];
                }
                $cont++;
            }
            $row['imagen1'] = strlen($row['imagen1']) > 0 ? $row['imagen1'] : 'sinimagen_mtr_20sba.jpg';
            $row['imagen2'] = strlen($row['imagen2']) > 0 ? $row['imagen2'] : 'sinimagen_mtr_20sba.jpg';

            $dataR[] = $row;
        }
        $codConsulta = substr($codConsulta, 0, -1);
        //echo $codConsulta;


        $tempListData = $this->getinfoData($codConsulta);
        // $key = array_search($dataR[3]['prod_cod'], array_column($tempListData, 'cod_prod'));
        //print_r($tempListData[$key]);
        $reslFinalR = [];
        foreach ($dataR as $rowP) {
            $key = array_search($rowP['prod_cod'], array_column($tempListData, 'cod_prod'));
            $tempD = $tempListData[$key];

           
                $rowP['cod_esp'] = $tempD['cod_espe'];
                $rowP['nom_prod'] = $tempD['nom_prod'];
                $rowP['unidad'] = $tempD['nom_unid'];
                $rowP['precio'] = $tempD['precio_venta'];
                $rowP['stock'] = $tempD['stock'];
                $rowP['marca'] = $tempD['nom_sub2'];
                $rowP['categoria'] = $tempD['nom_sub1'];
                $reslFinalR[] = $rowP;
            
        }
        return $reslFinalR;
    }


    public function getListaProdExclu()
    {
        $sql = "SELECT 
  producto.content1,
  producto.content2,
  producto.content3,
  producto.nombre,
  producto.prod_id,
  producto.prod_cod,
  producto.sub_cat 
FROM
  producto 
  INNER JOIN productos_exclusivos AS eclu 
    ON producto.prod_id = eclu.prod_id ";
        //echo $sql;
        $dataR = [];
        $res =  $this->conexion->query($sql);
        $codConsulta = "";
        while ($row = $res->fetch_assoc()) {
            $codConsulta = $codConsulta . $row['prod_cod'] . "-";
            $row['imagen1'] = '';
            $row['imagen2'] = '';
            $row['is_ofert'] = false;

            $sql = "SELECT * FROM ofertas_productos WHERE  fecha_termino >= NOW() AND  producto_id = " . $row['prod_id'];
            $respOfer = $this->getDataExeSQL($sql);
            if ($rowOffer = $respOfer->fetch_assoc()) {
                $row['is_ofert'] = true;
                $row['precio_ofer'] = $rowOffer['precio_oferta'];
            }
            $sql = "SELECT * FROM producto_foto WHERE prod_id = {$row['prod_id']} ORDER BY  orden ASC LIMIT 2";

            $respImg = $this->conexion->query($sql);
            $cont = 1;
            foreach ($respImg as $rowImg) {
                if ($cont == 1) {
                    $row['imagen1'] = $rowImg['imagen_url'];
                } elseif ($cont == 2) {
                    $row['imagen2'] = $rowImg['imagen_url'];
                }
                $cont++;
            }
            $row['imagen1'] = strlen($row['imagen1']) > 0 ? $row['imagen1'] : 'sinimagen_mtr_20sba.jpg';
            $row['imagen2'] = strlen($row['imagen2']) > 0 ? $row['imagen2'] : 'sinimagen_mtr_20sba.jpg';

            $dataR[] = $row;
        }
        $codConsulta = substr($codConsulta, 0, -1);
        //echo $codConsulta;


        $tempListData = $this->getinfoData($codConsulta);
        // $key = array_search($dataR[3]['prod_cod'], array_column($tempListData, 'cod_prod'));
        //print_r($tempListData[$key]);
        $reslFinalR = [];
        foreach ($dataR as $rowP) {
            $key = array_search($rowP['prod_cod'], array_column($tempListData, 'cod_prod'));
            $tempD = $tempListData[$key];

            $rowP['cod_esp'] = $tempD['cod_espe'];
            $rowP['nom_prod'] = $tempD['nom_prod'];
            $rowP['unidad'] = $tempD['nom_unid'];
            $rowP['precio'] = $tempD['precio_venta'];
            $rowP['stock'] = $tempD['stock'];
            $rowP['marca'] = $tempD['nom_sub2'];
            $rowP['categoria'] = $tempD['nom_sub1'];
            $reslFinalR[] = $rowP;
        }
        return $reslFinalR;
    }
    public function getListaProdOfert()
    {



        $sql = "SELECT 
  prod.prod_id,
  prod.nombre,
   prod.prod_cod,
   prod.content1,
  prod.content2,
  prod.content3,
  cate.nombre_cate,
  ofer.* 
FROM
  ofertas_productos AS ofer 
  INNER JOIN producto AS prod 
    ON ofer.producto_id = prod.prod_id 
  INNER JOIN grupo_seleccion AS cate 
    ON prod.categoria = cate.codi_categoria 
WHERE NOW() <= ofer.fecha_termino";
        //echo $sql;
        $dataR = [];
        $res =  $this->conexion->query($sql);
        $codConsulta = "";
        while ($row = $res->fetch_assoc()) {
            $codConsulta = $codConsulta . $row['prod_cod'] . "-";
            $row['imagen1'] = '';
            $row['imagen2'] = '';

            $sql = "SELECT * FROM producto_foto WHERE prod_id = {$row['prod_id']} ORDER BY  orden ASC LIMIT 2";

            $respImg = $this->conexion->query($sql);
            $cont = 1;
            foreach ($respImg as $rowImg) {
                if ($cont == 1) {
                    $row['imagen1'] = $rowImg['imagen_url'];
                } elseif ($cont == 2) {
                    $row['imagen2'] = $rowImg['imagen_url'];
                }
                $cont++;
            }
            $row['imagen1'] = strlen($row['imagen1']) > 0 ? $row['imagen1'] : 'sinimagen_mtr_20sba.jpg';
            $row['imagen2'] = strlen($row['imagen2']) > 0 ? $row['imagen2'] : 'sinimagen_mtr_20sba.jpg';

            $dataR[] = $row;
        }
        $codConsulta = substr($codConsulta, 0, -1);
        //echo $codConsulta;


        $tempListData = $this->getinfoData($codConsulta);
        // $key = array_search($dataR[3]['prod_cod'], array_column($tempListData, 'cod_prod'));
        //print_r($tempListData[$key]);
        $reslFinalR = [];
        foreach ($dataR as $rowP) {
            $key = array_search($rowP['prod_cod'], array_column($tempListData, 'cod_prod'));
            $tempD = $tempListData[$key];

            $rowP['cod_esp'] = $tempD['cod_espe'];
            $rowP['nom_prod'] = $tempD['nom_prod'];
            $rowP['unidad'] = $tempD['nom_unid'];
            $rowP['precio'] = $tempD['precio_venta'];
            $rowP['stock'] = $tempD['stock'];
            $rowP['marca'] = $tempD['nom_sub2'];
            $rowP['categoria'] = $tempD['nom_sub1'];
            $reslFinalR[] = $rowP;
        }
        return $reslFinalR;
    }
    public function getListaProdRemate234()
    {
        $sql = "SELECT 
  producto.content1,
  producto.content2,
  producto.content3,
  producto.nombre,
  producto.prod_id,
  producto.prod_cod,
  producto.sub_cat,
  producto.precio_prod,
  producto.stock_prod,
  producto.marca as marca_cod,
  marca.nombre_marca as marca
FROM
  producto INNER JOIN marcra_productos 
      AS marca ON producto.marca = marca.cod_marca where  
    producto.tipo_pro = '1' and producto.estado_prod='2' order by producto.prod_id asc ";
        //echo $sql;
        $dataR = [];
        $res =  $this->conexion->query($sql);
        $codConsulta = "";
        while ($row = $res->fetch_assoc()) {
            $codConsulta = $codConsulta . $row['prod_cod'] . "-";
            $row['imagen1'] = '';
            $row['imagen2'] = '';

            $sql = "SELECT * FROM producto_foto WHERE prod_id = {$row['prod_id']} ORDER BY  orden ASC LIMIT 2";

            $respImg = $this->conexion->query($sql);
            $cont = 1;
            foreach ($respImg as $rowImg) {
                if ($cont == 1) {
                    $row['imagen1'] = $rowImg['imagen_url'];
                } elseif ($cont == 2) {
                    $row['imagen2'] = $rowImg['imagen_url'];
                }
                $cont++;
            }
            $row['imagen1'] = strlen($row['imagen1']) > 0 ? $row['imagen1'] : 'sinimagen_mtr_20sba.jpg';
            $row['imagen2'] = strlen($row['imagen2']) > 0 ? $row['imagen2'] : 'sinimagen_mtr_20sba.jpg';

            $dataR[] = $row;
        }
        $codConsulta = substr($codConsulta, 0, -1);
        $tempListData = $this->getinfoData($codConsulta);

        $reslFinalR = [];
        foreach ($dataR as $rowP) {
            $key = array_search($rowP['prod_cod'], array_column($tempListData, 'cod_prod'));
            $tempD = $tempListData[$key];
            $rowP['precio_prod'] = $tempD['precio_venta'];
            $rowP['precio'] = $tempD['precio_venta'];
            $rowP['stock'] = $tempD['stock'];
            $rowP['nom_prod'] = $rowP['nombre'];
            $rowP['stock_prod'] = $tempD['stock'];

            $reslFinalR[] = $rowP;
        }
        return $reslFinalR;
    }
    public function getListaProdRemate2()
    {
        $sql = "SELECT 
  producto.content1,
  producto.content2,
  producto.content3,
  producto.nombre,
  producto.prod_id,
  producto.prod_cod,
  producto.sub_cat,
  producto.precio_prod,
  producto.stock_prod,
  producto.marca as marca_cod,
  marca.nombre_marca as marca
FROM
  producto INNER JOIN marcra_productos AS marca ON producto.marca = marca.cod_marca where  producto.tipo_pro = '2' ";
        //echo $sql;
        $dataR = [];
        $res =  $this->conexion->query($sql);
        $codConsulta = "";
        while ($row = $res->fetch_assoc()) {
            $codConsulta = $codConsulta . $row['prod_cod'] . "-";
            $row['imagen1'] = '';
            $row['imagen2'] = '';

            $sql = "SELECT * FROM producto_foto WHERE prod_id = {$row['prod_id']} ORDER BY  orden ASC LIMIT 2";

            $respImg = $this->conexion->query($sql);
            $cont = 1;
            foreach ($respImg as $rowImg) {
                if ($cont == 1) {
                    $row['imagen1'] = $rowImg['imagen_url'];
                } elseif ($cont == 2) {
                    $row['imagen2'] = $rowImg['imagen_url'];
                }
                $cont++;
            }
            $row['imagen1'] = strlen($row['imagen1']) > 0 ? $row['imagen1'] : 'sinimagen_mtr_20sba.jpg';
            $row['imagen2'] = strlen($row['imagen2']) > 0 ? $row['imagen2'] : 'sinimagen_mtr_20sba.jpg';

            $dataR[] = $row;
        }

        $reslFinalR = [];
        foreach ($dataR as $rowP) {
            $reslFinalR[] = $rowP;
        }
        return $reslFinalR;
    }

    public function getDataExeSQL($sql)
    {
        return $this->conexion->query($sql);
    }
    public function insertar()
    {
        $sql = "INSERT INTO producto VALUES (NULL,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,NULL,'{$_POST['estado_prod']}');";

        $categoria = $this->getCategoria();
        $marca = $this->getMarca();
        $prod_cod = $this->getProdCod();
        $descripcion = $this->getDescripcion();
        $caracteristicas = $this->getCaracteristicas();
        $estado = $this->getEstado();
        $nombre  = $this->getNombre();
        $subCat = strlen($this->getSubCate() . "") > 0 ? $this->getSubCate() : null;
        $content1 = $this->getContent1();
        $content2 = $this->getContent2();
        $content3 = $this->getContent3();
        $precio_prod = $this->getPrecioProd();
        $stock_prod = $this->getStockProd();
        $tipo_pro = $this->getTipoPro();
        $garantia = $this->getGarantia();

        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("sssssssssssssss", $categoria, $subCat, $nombre, $content1, $content2, $content3, $marca, $prod_cod, $descripcion, $caracteristicas, $precio_prod, $stock_prod, $tipo_pro, $estado, $garantia);
        $res = $stmt->execute();
        echo  $stmt->error;
        if ($res) {
            $this->setProdId($stmt->insert_id);
        }
        return $res;
    }
    public function update($content1, $content2, $content3, $nombre, $descripcion, $caracteristicas, $garantia, $estado, $categoria, $subC, $prod_id)
    {

        if ($subC == null) {
            $sql = "UPDATE producto
                SET 
                 content1 = '$content1',
                  content2 = '$content2',
                  content3 = '$content3',
                  sub_cat=null,
                    nombre= '$nombre',
                  descripcion = '$descripcion',
                  caracteristicas = '$caracteristicas',
                    garantia = '$garantia',
                    estado = '$estado',
                    categoria='$categoria'
                WHERE prod_id = '$prod_id'";
        } else {
            $sql = "UPDATE producto
                SET 
                 content1 = '$content1',
                  content2 = '$content2',
                  content3 = '$content3',
                  sub_cat='$subC',
                    nombre= '$nombre',
                  descripcion = '$descripcion',
                  caracteristicas = '$caracteristicas',
                    garantia = '$garantia',
                    estado = '$estado',
                    categoria='$categoria'
                WHERE prod_id = '$prod_id'";
        }



        $stmt = $this->conexion->query($sql);
        /* $stmt = false; */
        /* $estado = $this->getEstado(); */
        /* $stmt->bind_param("sssssssssss", $content1, $content2, $content3, $subC, $nombre, $descripcion, $caracteristicas, $garantia, $estado, $prod_id, $categoria); */
        /* $res = $stmt->execute(); */
        /*  if ($stmt) {
            $stmt = true;
        } */
        // echo "Error:".$stmt->error;
        return $stmt;
    }
    public function update2()
    {
        $sql = "UPDATE producto
                SET 
                 content1 = ?,
                  content2 = ?,
                  content3 = ?,
                    nombre= ?,
                  descripcion = ?,
                  caracteristicas = ?,
                  precio_prod=?,
                  stock_prod=?
                WHERE prod_id = ?";


        $prod_id = $this->getProdId();
        $descripcion = $this->getDescripcion();
        $caracteristicas = $this->getCaracteristicas();
        $nombre = $this->getNombre();
        $content1 = $this->getContent1();
        $content2 = $this->getContent2();
        $content3 = $this->getContent3();
        $precio_prod = $this->getPrecioProd();
        $stock_prod = $this->getStockProd();

        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("sssssssss", $content1, $content2, $content3, $nombre, $descripcion, $caracteristicas, $precio_prod, $stock_prod, $prod_id);
        $res = $stmt->execute();
        if ($res) {
            $this->setProdId($stmt->insert_id);
        }
        return $res;
    }
    public function getListRandon($cnt)
    {
        $sql = "SELECT * FROM producto WHERE   producto.prod_id!={$this->getProdId()} AND producto.categoria = '{$this->getCategoria()}' ORDER BY RAND() LIMIT " . $cnt;
        //echo $sql;
        $respu = $this->conexion->query($sql);
        $listaArr = [];
        $codConsulta = "";
        foreach ($respu as $row) {
            $codConsulta = $codConsulta . $row['prod_cod'] . "-";
            $row['imagen1'] = '';
            $row['imagen2'] = '';
            $row['is_ofert'] = false;

            $sql = "SELECT * FROM ofertas_productos WHERE  fecha_termino >= NOW() AND  producto_id = " . $row['prod_id'];
            $respOfer = $this->getDataExeSQL($sql);
            if ($rowOffer = $respOfer->fetch_assoc()) {
                $row['is_ofert'] = true;
                $row['precio_ofer'] = $rowOffer['precio_oferta'];
            }

            $sql = "SELECT * FROM producto_foto WHERE prod_id = {$row['prod_id']} ORDER BY  orden ASC LIMIT 2";
            //echo $sql;
            $respImg = $this->conexion->query($sql);
            $cont = 1;
            foreach ($respImg as $rowImg) {
                if ($cont == 1) {
                    $row['imagen1'] = $rowImg['imagen_url'];
                } elseif ($cont == 2) {
                    $row['imagen2'] = $rowImg['imagen_url'];
                }
                $cont++;
            }
            $row['imagen1'] = strlen($row['imagen1']) > 0 ? $row['imagen1'] : 'sinimagen_mtr_20sba.jpg';
            $row['imagen2'] = strlen($row['imagen2']) > 0 ? $row['imagen2'] : 'sinimagen_mtr_20sba.jpg';

            $listaArr[] = $row;
        }

        $codConsulta = substr($codConsulta, 0, -1);



        $tempListData = $this->getinfoData($codConsulta);
        $reslFinalR = [];
        foreach ($listaArr as $rowP) {
            $key = array_search($rowP['prod_cod'], array_column($tempListData, 'cod_prod'));
            $tempD = $tempListData[$key];

            $rowP['cod_esp'] = $tempD['cod_espe'];
            $rowP['nom_prod'] = $tempD['nom_prod'];
            $rowP['unidad'] = $tempD['nom_unid'];
            $rowP['precio'] = $tempD['precio_venta'];
            $rowP['stock'] = $tempD['stock'];
            $rowP['marca'] = $tempD['nom_sub2'];
            $rowP['categoria'] = $tempD['nom_sub1'];
            $reslFinalR[] = $rowP;
        }

        return $reslFinalR;
    }

    public function getListRandonRelacionada($cnt)
    {

        /*$sql = "SELECT  pf.imagen_url,prod2.stock_act,prob1.prod_id,propre.precio_cuatro,SUM(prod2.stock_act) AS suma_stock,prob1.nombre,op.precio_oferta FROM producto AS prob1
        LEFT JOIN ofertas_productos AS op ON prob1.prod_id=op.producto_id
        INNER JOIN producto_foto AS pf ON prob1.prod_id=pf.prod_id
        INNER JOIN stocks AS prod2 ON prob1.prod_cod = prod2.cod_prod 
        INNER JOIN precios AS propre ON prod2.cod_prod=propre.cod_prod
        WHERE prob1.prod_id!={$this->getProdId()} AND prob1.categoria = '{$this->getCategoria()}' AND prod2.stock_act > 0 AND propre.cod_suc=1 AND prod2.cod_suc=1  AND pf.orden='1' GROUP BY prod2.cod_prod order by rand() LIMIT " . $cnt;
        */
        $sql = "SELECT tableTemp.* FROM (SELECT  pf.imagen_url,prod2.stock_act,prob1.prod_id,propre.precio_cuatro,
SUM(prod2.stock_act) AS suma_stock,prob1.nombre,op.precio_oferta, ROUND(RAND() * prob1.prod_id) 'rand_ind' FROM producto AS prob1 
        LEFT JOIN ofertas_productos AS op ON prob1.prod_id=op.producto_id
        INNER JOIN producto_foto AS pf ON prob1.prod_id=pf.prod_id
        INNER JOIN stocks AS prod2 ON prob1.prod_cod = prod2.cod_prod 
        INNER JOIN precios AS propre ON prod2.cod_prod=propre.cod_prod
        WHERE prob1.prod_id!={$this->getProdId()} AND prob1.categoria = '{$this->getCategoria()}' AND prod2.stock_act > 2 
        AND propre.cod_suc=1 AND prod2.cod_suc=1  AND pf.orden='1' GROUP BY prod2.cod_prod) tableTemp ORDER BY tableTemp.rand_ind LIMIT " . $cnt;

        //echo $sql;
        $respu = $this->conexion->query($sql);
        /* $result = $respu->fetch_assoc(); */
        return $respu;
        /*  $listaArr = [];
        $codConsulta = "";
        foreach ($respu as $row) {
            $codConsulta = $codConsulta . $row['prod_cod'] . "-";
            $row['imagen1'] = '';
            $row['imagen2'] = '';
            $row['is_ofert'] = false;

            $sql = "SELECT * FROM ofertas_productos WHERE  fecha_termino >= NOW() AND  producto_id = " . $row['prod_id'];
            $respOfer = $this->getDataExeSQL($sql);
            if ($rowOffer = $respOfer->fetch_assoc()) {
                $row['is_ofert'] = true;
                $row['precio_ofer'] = $rowOffer['precio_oferta'];
            }

            $sql = "SELECT * FROM producto_foto WHERE prod_id = {$row['prod_id']} ORDER BY  orden ASC LIMIT 2";
            //echo $sql;
            $respImg = $this->conexion->query($sql);
            $cont = 1;
            foreach ($respImg as $rowImg) {
                if ($cont == 1) {
                    $row['imagen1'] = $rowImg['imagen_url'];
                } elseif ($cont == 2) {
                    $row['imagen2'] = $rowImg['imagen_url'];
                }
                $cont++;
            }
            $row['imagen1'] = strlen($row['imagen1']) > 0 ? $row['imagen1'] : 'sinimagen_mtr_20sba.jpg';
            $row['imagen2'] = strlen($row['imagen2']) > 0 ? $row['imagen2'] : 'sinimagen_mtr_20sba.jpg';

            $listaArr[] = $row;
        }

        $codConsulta = substr($codConsulta, 0, -1);



        $tempListData = $this->getinfoData($codConsulta);
        $reslFinalR = [];
        foreach ($listaArr as $rowP) {
            $key = array_search($rowP['prod_cod'], array_column($tempListData, 'cod_prod'));
            $tempD = $tempListData[$key];

            $rowP['cod_esp'] = $tempD['cod_espe'];
            $rowP['nom_prod'] = $tempD['nom_prod'];
            $rowP['unidad'] = $tempD['nom_unid'];
            $rowP['precio'] = $tempD['precio_venta'];
            $rowP['stock'] = $tempD['stock'];
            $rowP['marca'] = $tempD['nom_sub2'];
            $rowP['categoria'] = $tempD['nom_sub1'];
            $reslFinalR[] = $rowP;
        }

        return $reslFinalR; */
    }

    public function getListRandonIndex($cnt)
    {

        $sql = "SELECT  pf.imagen_url,prod2.stock_act,prob1.prod_id,propre.precio_cuatro,SUM(prod2.stock_act) AS suma_stock,prob1.nombre,op.precio_oferta FROM $this->web.producto AS prob1 
        LEFT JOIN $this->web.ofertas_productos AS op ON prob1.prod_id=op.producto_id
        INNER JOIN $this->web.producto_foto AS pf ON prob1.prod_id=pf.prod_id
        INNER JOIN $this->compuvision.stocks AS prod2 ON prob1.prod_cod = prod2.cod_prod 
        INNER JOIN $this->compuvision.precios AS propre ON prod2.cod_prod=propre.cod_prod
        WHERE  prod2.stock_act > 0 AND propre.cod_suc=1 AND prod2.cod_suc=1  AND pf.orden='1' GROUP BY prod2.cod_prod order by rand() LIMIT " . $cnt;
        //echo $sql;
        $respu = $this->conexion->query($sql);
        /* $result = $respu->fetch_assoc(); */
        return $respu;
        /*  $listaArr = [];
        $codConsulta = "";
        foreach ($respu as $row) {
            $codConsulta = $codConsulta . $row['prod_cod'] . "-";
            $row['imagen1'] = '';
            $row['imagen2'] = '';
            $row['is_ofert'] = false;

            $sql = "SELECT * FROM ofertas_productos WHERE  fecha_termino >= NOW() AND  producto_id = " . $row['prod_id'];
            $respOfer = $this->getDataExeSQL($sql);
            if ($rowOffer = $respOfer->fetch_assoc()) {
                $row['is_ofert'] = true;
                $row['precio_ofer'] = $rowOffer['precio_oferta'];
            }

            $sql = "SELECT * FROM producto_foto WHERE prod_id = {$row['prod_id']} ORDER BY  orden ASC LIMIT 2";
            //echo $sql;
            $respImg = $this->conexion->query($sql);
            $cont = 1;
            foreach ($respImg as $rowImg) {
                if ($cont == 1) {
                    $row['imagen1'] = $rowImg['imagen_url'];
                } elseif ($cont == 2) {
                    $row['imagen2'] = $rowImg['imagen_url'];
                }
                $cont++;
            }
            $row['imagen1'] = strlen($row['imagen1']) > 0 ? $row['imagen1'] : 'sinimagen_mtr_20sba.jpg';
            $row['imagen2'] = strlen($row['imagen2']) > 0 ? $row['imagen2'] : 'sinimagen_mtr_20sba.jpg';

            $listaArr[] = $row;
        }

        $codConsulta = substr($codConsulta, 0, -1);



        $tempListData = $this->getinfoData($codConsulta);
        $reslFinalR = [];
        foreach ($listaArr as $rowP) {
            $key = array_search($rowP['prod_cod'], array_column($tempListData, 'cod_prod'));
            $tempD = $tempListData[$key];

            $rowP['cod_esp'] = $tempD['cod_espe'];
            $rowP['nom_prod'] = $tempD['nom_prod'];
            $rowP['unidad'] = $tempD['nom_unid'];
            $rowP['precio'] = $tempD['precio_venta'];
            $rowP['stock'] = $tempD['stock'];
            $rowP['marca'] = $tempD['nom_sub2'];
            $rowP['categoria'] = $tempD['nom_sub1'];
            $reslFinalR[] = $rowP;
        }

        return $reslFinalR; */
    }



    public function getRandomInfo($cnt)
    {
        $sql = "SELECT * FROM producto    ORDER BY RAND() LIMIT " . $cnt;
        $resl = $this->conexion->query($sql);
        $resul = [];
        foreach ($resl as $row) {

            $row['imagen1'] = '';

            $sql = "SELECT * FROM producto_foto WHERE prod_id = {$row['prod_id']} ORDER BY  orden ASC LIMIT 1";

            $respImg = $this->conexion->query($sql);
            $cont = 1;
            foreach ($respImg as $rowImg) {
                if ($cont == 1) {
                    $row['imagen1'] = $rowImg['imagen_url'];
                }
                $cont++;
            }
            $row['imagen1'] = strlen($row['imagen1']) > 0 ? $row['imagen1'] : 'sinimagen_mtr_20sba.jpg';
            $resul[] = $row;
        }
        return $resul;
    }
    public function getLastRegisterSilver($num)
    {
        $sql = "SELECT * FROM producto WHERE  producto.marca='071' ORDER BY  RAND()  DESC LIMIT $num";
        $resul = $this->conexion->query($sql);
        $respu = [];
        $codConsulta = "";
        foreach ($resul as $row) {
            $codConsulta = $codConsulta . $row['prod_cod'] . "-";

            $row['imagen1'] = '';
            $row['imagen2'] = '';

            $sql = "SELECT * FROM producto_foto WHERE prod_id = {$row['prod_id']} ORDER BY  orden ASC LIMIT 2";

            $respImg = $this->conexion->query($sql);
            $cont = 1;
            foreach ($respImg as $rowImg) {
                if ($cont == 1) {
                    $row['imagen1'] = $rowImg['imagen_url'];
                } elseif ($cont == 2) {
                    $row['imagen2'] = $rowImg['imagen_url'];
                }
                $cont++;
            }
            $row['imagen1'] = strlen($row['imagen1']) > 0 ? $row['imagen1'] : 'sinimagen_mtr_20sba.jpg';
            $row['imagen2'] = strlen($row['imagen2']) > 0 ? $row['imagen2'] : 'sinimagen_mtr_20sba.jpg';
            $respu[] = $row;
        }

        $codConsulta = substr($codConsulta, 0, -1);


        $tempListData = $this->getinfoData($codConsulta);
        $reslFinalR = [];
        foreach ($respu as $rowP) {
            $key = array_search($rowP['prod_cod'], array_column($tempListData, 'cod_prod'));
            $tempD = $tempListData[$key];

            $rowP['cod_esp'] = $tempD['cod_espe'];
            $rowP['nom_prod'] = $tempD['nom_prod'];
            $rowP['unidad'] = $tempD['nom_unid'];
            $rowP['precio'] = $tempD['precio_venta'];
            $rowP['stock'] = $tempD['stock'];
            $rowP['marca'] = $tempD['nom_sub2'];
            $rowP['categoria'] = $tempD['nom_sub1'];
            $reslFinalR[] = $rowP;
        }

        return $reslFinalR;
    }
    public function getLastRegisterRemaRema($num)
    {
        $sql = "SELECT producto.*,op.id_ofer AS id,op.precio_oferta AS precio_ofertaa FROM producto  
        LEFT JOIN ofertas_productos AS op ON producto.prod_id=op.producto_id AND  op.fecha_termino >= NOW() AND op.estado ='1'
WHERE producto.estado = '1' and producto.estado_prod='2' ORDER BY producto.prod_id DESC LIMIT $num";
        $resul = $this->conexion->query($sql);
        $respu = [];
        $codConsulta = "";
        $precioOferta = [];
        foreach ($resul as $row) {
            $codConsulta = $codConsulta . $row['prod_cod'] . "-";

            $row['imagen1'] = '';
            $row['imagen2'] = '';

            $sql = "SELECT * FROM producto_foto WHERE prod_id = {$row['prod_id']} ORDER BY  orden ASC LIMIT 2";

            $respImg = $this->conexion->query($sql);
            $cont = 1;
            foreach ($respImg as $rowImg) {
                if ($cont == 1) {
                    $row['imagen1'] = $rowImg['imagen_url'];
                } elseif ($cont == 2) {
                    $row['imagen2'] = $rowImg['imagen_url'];
                }
                $cont++;
            }
            $row['imagen1'] = strlen($row['imagen1']) > 0 ? $row['imagen1'] : 'sinimagen_mtr_20sba.jpg';
            $row['imagen2'] = strlen($row['imagen2']) > 0 ? $row['imagen2'] : 'sinimagen_mtr_20sba.jpg';
            $respu[] = $row;
        }
        /* echo "<pre>";
        var_dump($precioOferta); */
        /*  foreach ($precioOferta as $key => $val) {
            if ($val == '894') {
                $age1 = array("John" => "22");

            }
        }  */
        /* var_dump($precioOferta); */
        $codConsulta = substr($codConsulta, 0, -1);

        $tempListData = $this->getinfoData($codConsulta);
        $reslFinalR = [];

        foreach ($respu as $rowP) {
            $key = array_search($rowP['prod_cod'], array_column($tempListData, 'cod_prod'));

            $tempD = $tempListData[$key];
            /* echo "<pre>";
            var_dump( $tempD); */

            $rowP['stock'] = $tempD['stock'];

            $rowP['cod_esp'] = $tempD['cod_espe'];
            $rowP['nom_prod'] = $tempD['nom_prod'];
            $rowP['unidad'] = $tempD['nom_unid'];
            $rowP['precio'] = $tempD['precio_venta'];

            $rowP['marca'] = $tempD['nom_sub2'];
            $rowP['categoria'] = $tempD['nom_sub1'];
            $reslFinalR[] = $rowP;

            /*    echo "<pre>";
            var_dump($reslFinalR); */
        }
        /*   $key = array_search($reslFinalR['prod_id'], array_column($data, 'label')); */

        /* foreach ($reslFinalR as $key => $val) {


        } */
        /* echo array_search('894', $reslFinalR, true); */


        /*  var_dump($result); */
        /*
        $array = array(
            'zero'  => '0',
            'one'   => '1',
            'two'   => '2',
            'three' => '3',
        );
        $res = array_slice($array, 0, 3, true) +
            array("my_key" => "my_value") +
            array_slice($array, 3, count($array) - 1, true);
        print_r($res); */


        /*  var_dump($key); */
        /* return $reslFinalR;  */
        return $reslFinalR;
    }
    public function getLastRegister($num)
    {
        $sql = "SELECT producto.*,op.id_ofer AS id,op.precio_oferta AS precio_ofertaa FROM producto  
        LEFT JOIN ofertas_productos AS op ON producto.prod_id=op.producto_id AND  op.fecha_termino >= NOW() AND op.estado ='1'
WHERE producto.estado = '1' ORDER BY producto.prod_id DESC LIMIT $num";
        $resul = $this->conexion->query($sql);
        $respu = [];
        $codConsulta = "";
        $precioOferta = [];
        foreach ($resul as $row) {
            $codConsulta = $codConsulta . $row['prod_cod'] . "-";

            $row['imagen1'] = '';
            $row['imagen2'] = '';

            $sql = "SELECT * FROM producto_foto WHERE prod_id = {$row['prod_id']} ORDER BY  orden ASC LIMIT 2";

            $respImg = $this->conexion->query($sql);
            $cont = 1;
            foreach ($respImg as $rowImg) {
                if ($cont == 1) {
                    $row['imagen1'] = $rowImg['imagen_url'];
                } elseif ($cont == 2) {
                    $row['imagen2'] = $rowImg['imagen_url'];
                }
                $cont++;
            }
            $row['imagen1'] = strlen($row['imagen1']) > 0 ? $row['imagen1'] : 'sinimagen_mtr_20sba.jpg';
            $row['imagen2'] = strlen($row['imagen2']) > 0 ? $row['imagen2'] : 'sinimagen_mtr_20sba.jpg';
            $respu[] = $row;
        }
        /* echo "<pre>";
        var_dump($precioOferta); */
        /*  foreach ($precioOferta as $key => $val) {
            if ($val == '894') {
                $age1 = array("John" => "22");
              
            }
        }  */
        /* var_dump($precioOferta); */
        $codConsulta = substr($codConsulta, 0, -1);

        $tempListData = $this->getinfoData($codConsulta);
        $reslFinalR = [];

        foreach ($respu as $rowP) {
            $key = array_search($rowP['prod_cod'], array_column($tempListData, 'cod_prod'));

            $tempD = $tempListData[$key];
            /* echo "<pre>";
            var_dump( $tempD); */
         
                $rowP['stock'] = $tempD['stock'];

                $rowP['cod_esp'] = $tempD['cod_espe'];
                $rowP['nom_prod'] = $tempD['nom_prod'];
                $rowP['unidad'] = $tempD['nom_unid'];
                $rowP['precio'] = $tempD['precio_venta'];

                $rowP['marca'] = $tempD['nom_sub2'];
                $rowP['categoria'] = $tempD['nom_sub1'];
                $reslFinalR[] = $rowP;
            
            /*    echo "<pre>";
            var_dump($reslFinalR); */
        }
        /*   $key = array_search($reslFinalR['prod_id'], array_column($data, 'label')); */

        /* foreach ($reslFinalR as $key => $val) {

            
        } */
        /* echo array_search('894', $reslFinalR, true); */


        /*  var_dump($result); */
        /* 
        $array = array(
            'zero'  => '0',
            'one'   => '1',
            'two'   => '2',
            'three' => '3',
        );
        $res = array_slice($array, 0, 3, true) +
            array("my_key" => "my_value") +
            array_slice($array, 3, count($array) - 1, true);
        print_r($res); */


        /*  var_dump($key); */
        /* return $reslFinalR;  */
        return $reslFinalR;
    }
    public function getRandonRegister($num)
    {
        $sql = "SELECT producto.*,op.id_ofer AS id,op.precio_oferta AS precio_ofertaa FROM producto  
        LEFT JOIN ofertas_productos AS op ON producto.prod_id=op.producto_id AND  op.fecha_termino >= NOW() AND op.estado ='1'
        ORDER BY RAND() LIMIT $num";
        $resul = $this->conexion->query($sql);
        $respu = [];
        $codConsulta = "";
        $precioOferta = [];
        foreach ($resul as $row) {
            $codConsulta = $codConsulta . $row['prod_cod'] . "-";
            $row['imagen1'] = '';
            $row['imagen2'] = '';
            $sql = "SELECT * FROM producto_foto WHERE prod_id = {$row['prod_id']} ORDER BY  orden ASC LIMIT 2";
            $respImg = $this->conexion->query($sql);
            $cont = 1;
            foreach ($respImg as $rowImg) {
                if ($cont == 1) {
                    $row['imagen1'] = $rowImg['imagen_url'];
                } elseif ($cont == 2) {
                    $row['imagen2'] = $rowImg['imagen_url'];
                }
                $cont++;
            }
            $row['imagen1'] = strlen($row['imagen1']) > 0 ? $row['imagen1'] : 'sinimagen_mtr_20sba.jpg';
            $row['imagen2'] = strlen($row['imagen2']) > 0 ? $row['imagen2'] : 'sinimagen_mtr_20sba.jpg';
            /*  $sql3 = "SELECT * FROM ofertas_productos WHERE  fecha_termino >= NOW() AND estado ='1' AND producto_id = " . $row['prod_id'];
            $respOfer = $this->getDataExeSQL($sql3);
            $row['id'] = null;
            $row['oferta'] = null;
            if ($row2 = $respOfer->fetch_assoc()) {
                $row['id'] = $row2['producto_id'];
                $row['oferta'] = $row2['precio_ofertaa'];
            } */
            $respu[] = $row;
        }
        $codConsulta = substr($codConsulta, 0, -1);
        $tempListData = $this->getinfoData($codConsulta);
        $reslFinalR = [];
        foreach ($respu as $rowP) {
            $key = array_search($rowP['prod_cod'], array_column($tempListData, 'cod_prod'));
            $tempD = $tempListData[$key];
            $rowP['cod_esp'] = $tempD['cod_espe'];
           
                $rowP['nom_prod'] = $tempD['nom_prod'];
                $rowP['unidad'] = $tempD['nom_unid'];
                $rowP['precio'] = $tempD['precio_venta'];
                $rowP['stock'] = $tempD['stock'];
                $rowP['marca'] = $tempD['nom_sub2'];
                $rowP['categoria'] = $tempD['nom_sub1'];
                $reslFinalR[] = $rowP;
            
        }


        return $reslFinalR;
    }
    public function getDataRandonE()
    {
        /* $sql ="SELECT * FROM grupo_seleccion ORDER BY RAND() LIMIT 3";

        $resCap = $this->conexion->query($sql);*/
        $resCap = array(array("nombre" => 'Productos Destacados'), array("nombre" => 'Productos Mejor Valorados'));

        $respuestaArrr = [];
        $codConsulta = "";
        foreach ($resCap as $item) {

            $sql = "SELECT producto.*,op.id_ofer AS id,op.precio_oferta AS precio_ofertaa FROM producto  
            LEFT JOIN ofertas_productos AS op ON producto.prod_id=op.producto_id AND  op.fecha_termino >= NOW() AND op.estado ='1'
            ORDER BY RAND() LIMIT 15 ";
            $resPRod = $this->conexion->query($sql);
            $productRR = [];


            foreach ($resPRod as $rowPro) {
                $codConsulta = $codConsulta . $rowPro['prod_cod'] . "-";
                $rowPro['imagen1'] = '';
                $rowPro['imagen2'] = '';

                $sql = "SELECT * FROM producto_foto WHERE prod_id = {$rowPro['prod_id']} ORDER BY  orden ASC LIMIT 2";

                $respImg = $this->conexion->query($sql);
                $cont = 1;
                foreach ($respImg as $rowImg) {
                    if ($cont == 1) {
                        $rowPro['imagen1'] = $rowImg['imagen_url'];
                    } elseif ($cont == 2) {
                        $rowPro['imagen2'] = $rowImg['imagen_url'];
                    }
                    $cont++;
                }
                $rowPro['imagen1'] = strlen($rowPro['imagen1']) > 0 ? $rowPro['imagen1'] : 'sinimagen_mtr_20sba.jpg';
                $rowPro['imagen2'] = strlen($rowPro['imagen2']) > 0 ? $rowPro['imagen2'] : 'sinimagen_mtr_20sba.jpg';

                $productRR[] = $rowPro;
            }



            $item['productos'] = $productRR;
            $respuestaArrr[] = $item;
        }



        $codConsulta = substr($codConsulta, 0, -1);


        $tempListData = $this->getinfoData($codConsulta);
        $arrTMDRP = [];
        foreach ($respuestaArrr as $rowPI) {

            $reslFinalR = [];
            foreach ($rowPI['productos'] as $rowP) {
                $key = array_search($rowP['prod_cod'], array_column($tempListData, 'cod_prod'));
                $tempD = $tempListData[$key];

                
                    $rowP['cod_esp'] = $tempD['cod_espe'];
                    $rowP['nom_prod'] = $tempD['nom_prod'];
                    $rowP['unidad'] = $tempD['nom_unid'];
                    $rowP['precio'] = $tempD['precio_venta'];
                    $rowP['stock'] = $tempD['stock'];
                    $rowP['marca'] = $tempD['nom_sub2'];
                    $rowP['categoria'] = $tempD['nom_sub1'];
                    $reslFinalR[] = $rowP;
                
            }
            $rowPI['productos'] = $reslFinalR;

            $arrTMDRP[] = $rowPI;
        }

        return $arrTMDRP;
    }
    public function getDataRandonNovedad()
    {
        $sql = "SELECT * FROM grupo_seleccion ORDER BY RAND() LIMIT 4";
        $respuestaArrr = [];
        $resCap = $this->conexion->query($sql);
        $codConsulta = "";
        foreach ($resCap as $item) {
            $item['nombre'] = $item['nombre_cate'];
            $sql = "SELECT * FROM producto WHERE categoria='{$item['codi_categoria']}' ORDER BY prod_id DESC LIMIT 5";
            $resPRod = $this->conexion->query($sql);
            $productRR = [];


            foreach ($resPRod as $rowPro) {
                $codConsulta = $codConsulta . $rowPro['prod_cod'] . "-";
                $productRR[] = $rowPro;
            }



            $item['productos'] = $productRR;
            $respuestaArrr[] = $item;
        }

        return $respuestaArrr;
    }
    public function getListDataPR($cat, $cnt)
    {
        $sql = "SELECT 
  *
FROM
  producto 
  INNER JOIN grupo_seleccion AS catego 
    ON producto.categoria = catego.codi_categoria 
WHERE 
 
    catego.codi_categoria = '$cat'
   
   ORDER BY producto.prod_id DESC LIMIT $cnt";

        $resul = $this->conexion->query($sql);
        $arrRes = [];
        $codConsulta = "";
        foreach ($resul as $row) {

            $codConsulta = $codConsulta . $row['prod_cod'] . "-";
            $arrRes[] = $row;
        }

        return $arrRes;
    }
    public function getDataofertas()
    {
        $sql = "SELECT 
  prod.prod_id,
  prod.nombre,
   prod.prod_cod,
  cate.nombre_cate,
  ofer.* 
FROM
  ofertas_productos AS ofer 
  INNER JOIN producto AS prod 
    ON ofer.producto_id = prod.prod_id 
  INNER JOIN grupo_seleccion AS cate 
    ON prod.categoria = cate.codi_categoria 
WHERE NOW() <= ofer.fecha_termino order by rand()";
        $respuestaArrr = [];
        $resCap = $this->conexion->query($sql);
        $codConsulta = "";
        foreach ($resCap as $item) {


            $codConsulta = $codConsulta . $item['prod_cod'] . "-";
            $item['imagen1'] = '';
            $item['imagen2'] = '';

            $sql = "SELECT * FROM producto_foto WHERE prod_id = {$item['prod_id']} ORDER BY  orden ASC LIMIT 2";

            $respImg = $this->conexion->query($sql);
            $cont = 1;
            foreach ($respImg as $rowImg) {
                if ($cont == 1) {
                    $item['imagen1'] = $rowImg['imagen_url'];
                } elseif ($cont == 2) {
                    $item['imagen2'] = $rowImg['imagen_url'];
                }
                $cont++;
            }
            $item['imagen1'] = strlen($item['imagen1']) > 0 ? $item['imagen1'] : 'sinimagen_mtr_20sba.jpg';
            $item['imagen2'] = strlen($item['imagen2']) > 0 ? $item['imagen2'] : 'sinimagen_mtr_20sba.jpg';

            $respuestaArrr[] = $item;
        }

        $codConsulta = substr($codConsulta, 0, -1);


        $tempListData = $this->getinfoData($codConsulta);
        $arrTMDRP = [];
        foreach ($respuestaArrr as $rowPI) {
            $key = array_search($rowPI['prod_cod'], array_column($tempListData, 'cod_prod'));
            $tempD = $tempListData[$key];

            $rowPI['cod_esp'] = $tempD['cod_espe'];
            $rowPI['nom_prod'] = $tempD['nom_prod'];
            $rowPI['unidad'] = $tempD['nom_unid'];
            $rowPI['precio'] = $tempD['precio_venta'];
            $rowPI['stock'] = $tempD['stock'];
            $rowPI['marca'] = $tempD['nom_sub2'];
            $rowPI['categoria'] = $tempD['nom_sub1'];
            $arrTMDRP[] = $rowPI;
        }

        return $arrTMDRP;
    }
    public function exeSQL($sql)
    {
        return $this->conexion->query($sql);
    }
    public function getinfoData($prodCod)
    {

        $arr = explode("-", $prodCod);
        $respuesta = [];
        foreach ($arr as $roArr) {
            $condconsul = "  AND precios.cod_prod='" . $roArr . "' ";
            $sql = "SELECT 
              precios.cod_prod,
              precios.cod_suc,
              precios.precio_cuatro as precio_venta,
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



            $resss = $this->conexion->query($sql);
            if ($roww = $resss->fetch_assoc()) {
                $sql = "SELECT SUM(stock_act) AS 'stock' FROM stocks WHERE (cod_alma='109' OR cod_alma='105' OR cod_alma ='101' OR cod_alma = '301' ) AND cod_prod =  '{$roww['cod_prod']}'";
                $roww['stock'] = 0;
                $rsul = $this->conexion->query($sql);
                if ($row2 = $rsul->fetch_assoc()) {
                    $roww['stock'] = $row2['stock'];
                }
                $respuesta[] = $roww;
            }
        }
        return $respuesta;
    }
    public function getDataProd($cod_prod)
    {
        $respuesta = [];
        $sql = "SELECT 
                  precios.cod_prod,
                  precios.cod_suc,
                  precios.precio_cuatro as precio_venta,
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
        if ($row = $res->fetch_assoc()) {
            $sql = "SELECT SUM(stock_act) AS 'stock' FROM stocks WHERE (cod_alma='109' OR cod_alma='105' OR cod_alma ='101' OR cod_alma = '301' ) AND cod_prod =  '{$row['cod_prod']}'";
            $row['stock'] = 0;
            $rsul = $this->conexion->query($sql);
            if ($row2 = $rsul->fetch_assoc()) {
                $row['stock'] = $row2['stock'];
            }
            $respuesta = $row;
        }

        return $respuesta;
    }
    public function getListaProd22($codConsulta)
    {
        $sql = "SELECT * FROM producto  ";
        $dataR = [];
        $res =  $this->conexion->query($sql);
        $codConsulta = "";
        while ($row = $res->fetch_assoc()) {
            $codConsulta = $codConsulta . $row['prod_cod'] . "-";
            $row['imagen1'] = '';
            $row['imagen2'] = '';

            $sql = "SELECT * FROM producto_foto WHERE prod_id = {$row['prod_id']} ORDER BY  orden ASC LIMIT 2";

            $respImg = $this->conexion->query($sql);
            $cont = 1;
            foreach ($respImg as $rowImg) {
                if ($cont == 1) {
                    $row['imagen1'] = $rowImg['imagen_url'];
                } elseif ($cont == 2) {
                    $row['imagen2'] = $rowImg['imagen_url'];
                }
                $cont++;
            }
            $row['imagen1'] = strlen($row['imagen1']) > 0 ? $row['imagen1'] : 'sinimagen_mtr_20sba.jpg';
            $row['imagen2'] = strlen($row['imagen2']) > 0 ? $row['imagen2'] : 'sinimagen_mtr_20sba.jpg';

            $dataR[] = $row;
        }
        $codConsulta = substr($codConsulta, 0, -1);
        //echo $codConsulta;

        $tempListData = $this->getinfoData($codConsulta);
        // $key = array_search($dataR[3]['prod_cod'], array_column($tempListData, 'cod_prod'));
        //print_r($tempListData[$key]);
        $reslFinalR = [];
        foreach ($dataR as $rowP) {
            $key = array_search($rowP['prod_cod'], array_column($tempListData, 'cod_prod'));
            $tempD = $tempListData[$key];

            $rowP['cod_esp'] = $tempD['cod_espe'];
            $rowP['nom_prod'] = $tempD['nom_prod'];
            $rowP['unidad'] = $tempD['nom_unid'];
            $rowP['precio'] = $tempD['precio_venta'];
            $rowP['stock'] = $tempD['stock'];
            $rowP['marca'] = $tempD['nom_sub2'];
            $rowP['categoria'] = $tempD['nom_sub1'];
            $reslFinalR[] = $rowP;
        }
        return $reslFinalR;
    }
}



$productoDao = new ProductoDao();
$listaNue = $productoDao->getLastRegister(15);
 foreach ($listaNue as $proN) {
                                                //var_dump($proN);
                                                //die();
                                               /* if (!is_null($proN['precio_ofertaa'])) {
                                                    $ahorro = $proN['precio'] - $proN['precio_ofertaa'];
                                                    $precioProd =  number_format($proN['precio'], 2, '.', ',');
                                                    $ahorro = number_format($ahorro, 2, '.', ',');
                                                    $precioCambio = number_format($tc * $proN['precio_ofertaa'], 2, '.', ',');
                                                    $ahorroSol = $tc * $ahorro;
                                                    $precioProdSol =  number_format($tc * $precioProd, 2, '.', ',');
                                                    $ahorroSol = number_format($tc * $ahorro, 2, '.', ',');
                                                    $ahorroSol = number_format(floatval(0), 2);
                                                } else {*/
                                                    if($proN['tipo_pro']==2){
                                                        $precioProd =  number_format($proN['precio_prod'], 2, '.', ',');
                                                        $precioCambio = number_format($tc * $proN['precio_prod'], 2, '.', ',');
                                                    }else{
                                                        $precioProd =  number_format($proN['precio'], 2, '.', ',');
                                                        $precioCambio = number_format($tc * $proN['precio'], 2, '.', ',');
                                                    }


                                               /* } */
var_dump($proN);
  }

//var_dump($listaNue);

