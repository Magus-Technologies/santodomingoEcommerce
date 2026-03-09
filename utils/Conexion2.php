<?php


class Conexion2
{
    private $servername;
    private $username;
    private $password;
    private $bd;
    private $conn;

    function __construct()
    {
        require_once __DIR__ . '/../config/database.php';
        $this->servername = DB_HOST;
        $this->username = DB_USER;
        $this->password = DB_PASS;
        $this->bd = DB_NAME;
    }

    function getConexion()
    {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->bd);
        $this->conn->set_charset(DB_CHARSET);
        return $this->conn;
    }

    function closeConexion()
    {
        $this->conn->close();
    }

    function getBd()
    {
        return $this->bd;
    }
}
