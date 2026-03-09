<?php

require_once "../utils/Conexion.php";

$conexion = (new Conexion())->getConexion();

/* var_dump($_POST);
die(); */
$sql = "SELECT * from tipo_pago WHERE id_tipo_pago= '{$_POST['id']}'";


$result = $conexion->query($sql)->fetch_assoc();
echo json_encode($result);

