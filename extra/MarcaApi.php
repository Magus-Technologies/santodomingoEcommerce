<?php
require_once "../utils/Conexion.php";

class MarcaApi
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = (new Conexion())->getConexion();
    }
    public function getLista(){
        $sql ="SELECT * FROM sopsub2 WHERE cod_sub2 != '000'";
        $resul = $this->conexion->query($sql);
        $respuesta=[];
        foreach ($resul as $row){
            $respuesta[]=$row;
        }
        return $respuesta;
    }
    public function getData($codigo){
        $sql ="SELECT
  cod_sub2,
  nom_sub2
FROM sopsub2 WHERE cod_sub2 = '$codigo'";

        $resul = $this->conexion->query($sql);
        if ( $rowCat = $resul->fetch_assoc() ){

            $respuesta= $rowCat;
        }
        return $respuesta;
    }
}