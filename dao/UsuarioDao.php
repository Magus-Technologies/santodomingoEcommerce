<?php
require_once "../utils/Conexion.php";
require "../model/Usuario.php";

class UsuarioDao extends Usuario
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = (new Conexion())->getConexion();
    }

    public function exeSQL($sql){
        return $this->conexion->query($sql);
    }

    public function validar(){
        $sql="SELECT * FROM usuarios WHERE email = '{$this->getEmail()}'";
        return $this->conexion->query($sql);
    }

    public function insertar(){
        $sql ="INSERT INTO usuarios VALUES (NULL,?,?,?,'usuario','');";

        $stmt = $this->conexion->prepare($sql);

        $nombres=$this->getNombres();
        $email=$this->getEmail();
        $clave=$this->getClave();

        $stmt->bind_param("sss",  $nombres, $email, $clave);

        $res = $stmt->execute();
        $this->setUseId($stmt->insert_id);
        $stmt->close();
        return $res;
    }

}