<?php
require_once "../utils/Conexion.php";
require "../model/NuevoImgreso.php";
require_once  "../extra/CategoriaApi.php";
require_once  "../extra/MarcaApi.php";
require_once "../extra/ProductosApi.php";

class NuevoImgresoDao extends NuevoImgreso
{
    private $conexion;
    private $categoriaApi;
    private $marcaApi;
    private $productosApi;

    public function __construct()
    {
        $this->conexion = (new Conexion())->getConexion();
        $this->categoriaApi = new CategoriaApi();
        $this->marcaApi = new MarcaApi();
        $this->productosApi = new ProductosApi();

    }

    public function getLista(){
        $sql="SELECT 
  nuevo_imgreso.id,
  nuevo_imgreso.prod_id,
  nuevo_imgreso.nuevo,
  nuevo_imgreso.orden,
  producto.prod_cod
FROM
  nuevo_imgreso 
  INNER JOIN producto ON nuevo_imgreso.prod_id = producto.prod_id
ORDER BY nuevo_imgreso.orden ASC ";
        $res = $this->conexion->query($sql);
        $respuesta = [];
        foreach ($res as $row){

            $conRay = $this->productosApi->getDataProd($row['prod_cod']);

            $row['cod_esp'] = $conRay['cod_espe'];
            $row['nom_prod'] = $conRay['nom_prod'];
            $row['unidad'] = $conRay['nom_unid'];
            $row['precio'] = $conRay['precio_venta'];
            $row['stock'] = $conRay['stock'];
            $row['imagen1'] = '';
            $row['imagen2'] = '';

            $sql ="SELECT * FROM producto_foto WHERE prod_id = {$row['prod_id']} ORDER BY  orden ASC LIMIT 2";

            $respImg = $this->conexion->query($sql);
            $cont = 1;
            foreach ($respImg as $rowImg){
                if ($cont == 1){
                    $row['imagen1'] = $rowImg['imagen_url'];
                }elseif ($cont == 2){
                    $row['imagen2'] = $rowImg['imagen_url'];
                }
                $cont++;
            }
            $row['imagen1'] =strlen($row['imagen1'] )>0?$row['imagen1']: 'sinimagen_mtr_20sba.jpg';
            $row['imagen2'] = strlen($row['imagen2'] )>0?$row['imagen2']: 'sinimagen_mtr_20sba.jpg';
            $respuesta[]=$row;
        }

        return $respuesta;
    }
}