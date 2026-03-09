<?php

require_once "../utils/Conexion.php";
$conexion = (new Conexion())->getConexion();

/* $respuesta =array("res"=>false);
 *//* str_pad($numero, 2, "0", STR_PAD_LEFT) */

/* $value = '';
if (strlen($_POST['value']) == 1) {
    $value = str_pad($_POST['value'], 2, "0", STR_PAD_LEFT);
} else {
   
} */
$value = $_POST['value'];
$result = $conexion->query("SELECT * FROM  sys_dir_provincia WHERE dep_codigo = '$value'")->fetch_all(MYSQLI_ASSOC);
echo json_encode($result);
