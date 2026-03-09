<?php

require_once "../utils/Conexion.php";

$conexion = (new Conexion())->getConexion();

$sql = "insert into tipo_pago set nombre='{$_POST['nombre']}'";

$conexion->query($sql);

header("Location: formas_pago.php");






