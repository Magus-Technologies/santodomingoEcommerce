<?php
require_once "../utils/Conexion.php";
require "../model/MarcaSeleccion.php";
require_once  "../extra/MarcaApi.php";


class MarcaSeleccionDao extends MarcaSeleccion
{
    private $conexion;
    private $marcaApi;

    public function __construct()
    {
        $this->conexion = (new Conexion())->getConexion();
        $this->marcaApi = new MarcaApi();

    }
    public function getDataImagen(){
        $sql="SELECT marca_id, cod_marca, imagen FROM marcra_productos WHERE cod_marca='{$this->getCodMarca()}'";
        return $this->conexion->query($sql);
    }

    public function insertIsNull(){
        $sql ="SELECT * FROM marcra_productos WHERE cod_marca ='{$this->getCodMarca()}'";
        $val = true;
        $res = $this->conexion->query($sql);
        if ($row = $res->fetch_assoc()){
            $val = false;
        }
        if ($val){
            $sql ="INSERT INTO marcra_productos VALUES (null,'{$this->getNombre()}','{$this->getCodMarca()}','');";
            //echo $sql;
            $this->conexion->query($sql);
        }
        return $val;
    }

    public function getDataOnli(){
        return $this->marcaApi->getLista();
    }
}