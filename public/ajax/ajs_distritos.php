<?php

require_once "../utils/Conexion.php";
$conexion = (new Conexion())->getConexion();

/* $respuesta =array("res"=>false);
 *//* str_pad($numero, 2, "0", STR_PAD_LEFT) */

/* $valueDep = '';
$valueProv = '';
if (strlen($_POST['idDep']) == 1) {
    $valueDep = str_pad($_POST['idDep'], 2, "0", STR_PAD_LEFT);
} else {
    $valueDep = $_POST['idDep'];
}
if (strlen($_POST['idProv']) == 1) {
    $valueProv = str_pad($_POST['idProv'], 2, "0", STR_PAD_LEFT);
} else {
    $valueProv = $_POST['idProv'];
} */
$valueDep = $_POST['idDep'];
$valueProv = $_POST['idProv'];
/* $sql = "SELECT * FROM  sys_dir_distrito WHERE dep_codigo = '$valueDep' AND pro_codigo ='$valueProv'"; */
$result = $conexion->query("SELECT * FROM  sys_dir_distrito WHERE dep_codigo = '$valueDep' AND pro_codigo ='$valueProv'")->fetch_all(MYSQLI_ASSOC);
echo json_encode($result);
