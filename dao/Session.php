<?php
require_once "../utils/Conexion.php";

class Session
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = (new Conexion())->getConexion();
    }
    public function validateSession()
    {
        $idUsuario = $_SESSION['usuario'];
        $sql = "SELECT perfil FROM usuarios WHERE use_id = '$idUsuario'";
        $result = $this->conexion->query($sql);
        return $result->fetch_assoc();
    }
}
