<?php
require_once "../utils/Conexion.php";

class TasaCambioApi
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = (new Conexion())->getConexion();
    }

    public function getTasaCambio(){
        $sql = "SELECT * FROM tcambio ORDER BY dfecha DESC LIMIT 1";
        $resp = $this->conexion->query($sql);
        $arr = [];
        if ($r = $resp->fetch_assoc()){
            $arr = $r;
        }
        return $arr;
    }

    public function getTasaCambioFecha($fecha){
        $sql = "SELECT * FROM tcambio where dfecha<='$fecha' ORDER BY dfecha DESC LIMIT 1";
        $resp = $this->conexion->query($sql);
        $arr = [];
        if ($r = $resp->fetch_assoc()){
            $arr = $r;
        }
        return $arr;
    }

}