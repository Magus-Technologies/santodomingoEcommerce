<?php
require_once "../utils/Conexion.php";
require "../model/GrupoCategoria.php";
require_once  "../extra/CategoriaApi.php";
require_once  "../extra/MarcaApi.php";

class GrupoCategoriaDao extends GrupoCategoria
{
    private $conexion;
    private $categoriaApi;
    private $marcaApi;

    public function __construct()
    {
        $this->conexion = (new Conexion())->getConexion();
        $this->categoriaApi = new CategoriaApi();
        $this->marcaApi = new MarcaApi();
    }
    function getGategoliaOnli2(){

        $sql = "SELECT * FROM grupo_seleccion";
        return $this->conexion->query($sql);
    }

    function getGategoliaOnli(){
        $lista =  $this->categoriaApi->getLista();
        return $lista;
      //return $this->conexion->query($sql);
    }

    public function getSubCat($cate){
        $sql= " SELECT
  sub_id,
  id_catego,
  nombre
FROM sub_categoria WHERE id_catego=".$cate;
        return $this->conexion->query($sql);
    }
    public function getGrupos(){
        $sql ="SELECT * FROM grupo_categorias";
        $arrRes = [];
        $res =  $this->conexion->query($sql);
        foreach ($res as  $row){
            $row['imagen']= strlen($row['imagen'])>0?$row['imagen']:'sinimagen_menu_20sba.jpg';
            $sql ="SELECT
                      id_seleccion,
                      id_grupo,
                      codi_categoria,
                      imagen,
                      estado
                    FROM grupo_seleccion WHERE id_grupo = ".$row['grupo_id'];
            $resCate =  $this->conexion->query($sql);
            $arrCat = [];
            foreach ($resCate as $rowCat){

                $arr = json_decode($this->categoriaApi->getData($rowCat['codi_categoria']));
                $rowCat['nombre']=$arr['nom_sub1'];
                $arrCat[]=$rowCat;
            }
            $row['categorias']=$arrCat;
            $sql ="SELECT 
                      prod.marca
                    FROM
                      producto AS prod 
                      INNER JOIN grupo_seleccion AS catego 
                        ON prod.categoria = catego.codi_categoria 
                      WHERE catego.id_grupo ={$row['grupo_id']} 
                        GROUP BY prod.marca";

            //echo $sql;
            $resMar =  $this->conexion->query($sql);
            $arrMarc = [];
            foreach ($resMar as $rowMar){

                $arr = json_decode($this->marcaApi->getData($rowMar['marca']));
                $rowMar['nombre']=$arr['nom_sub2'];
                $arrMarc[]=$rowMar;
            }
            $row['marcas']=$arrMarc;
            $arrRes[]=$row;
        }
        return $arrRes;
    }

    public function getListaCate(){
        $arrT = array();
        $sql ="SELECT * FROM grupo_seleccion WHERE nombre_cate!='SIN CATEGORIA' ORDER BY orden ASC";
        $res = $this->conexion->query($sql);

        foreach ($res as $row){

            $row['nombre']=$row['nombre_cate'];

            $sql ="SELECT 
                  prod.marca,
                  marca.nombre_marca AS 'nombre'
                FROM
                  producto AS prod 
                  INNER JOIN grupo_seleccion AS catego 
                    ON prod.categoria = catego.codi_categoria 
                  INNER JOIN marcra_productos AS marca 
                    ON prod.marca = marca.cod_marca 
                    WHERE catego.id_seleccion ={$row['id_seleccion']} 
                    GROUP BY prod.marca";
            $resMar = $this->conexion->query($sql);
            $arrMarc = [];
            foreach ($resMar as $rowMar){
                $arrMarc[]=$rowMar;
            }
            $row['marcas'] = $arrMarc;
            $row['imagen'] = strlen($row['imagen'])>0?$row['imagen']:"sinimagen_menu_20sba.jpg";
            $arrT[]=$row;
        }
        return $arrT;
    }
}