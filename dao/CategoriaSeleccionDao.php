<?php
require_once "../utils/Conexion.php";
require "../model/CategoriaSeleccion.php";

class CategoriaSeleccionDao extends CategoriaSeleccion
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = (new Conexion())->getConexion();
    }

    public function insertIsNull(){
        $sql =" SELECT * FROM grupo_seleccion WHERE codi_categoria = '{$this->getCodiCategoria()}'";
        $val = true;
        $res = $this->conexion->query($sql);
        if ($row = $res->fetch_assoc()){
            $val = false;
        }
        if ($val){
            $sql ="INSERT INTO grupo_seleccion  VALUES (null,null,'{$this->getCodiCategoria()}','','1');";
            $this->conexion->query($sql);
        }
        return $val;
    }
}