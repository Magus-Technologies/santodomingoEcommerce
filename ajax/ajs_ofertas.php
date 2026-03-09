<?php
require_once "../utils/Conexion.php";

$conexion = (new Conexion())->getConexion();
$tipo = $_POST['tipo'];


$respuesta = array("res" => false);

if ($tipo == 'in') {

    $sqlVerificar = "SELECT * FROM ofertas_productos_api WHERE producto_id = '{$_POST['prod']}'";
    $result = $conexion->query($sqlVerificar)->fetch_all(MYSQLI_ASSOC);
    if (empty($result)) {
        $sql = "INSERT INTO ofertas_productos_api
VALUES (NULL,
        '{$_POST['prod']}',
        '{$_POST['precio']}',
        '{$_POST['cantidad']}',
        '{$_POST['stocA']}',
        '{$_POST['termino']}',
        '1',
        NOW(),
        NOW())";
        if ($conexion->query($sql)) {
            $respuesta['res'] = true;
        }
    } else {
        $respuesta['res'] = false;
    }

    /* $sql="INSERT INTO ofertas_productos
VALUES (NULL,
        '{$_POST['prod']}',
        '{$_POST['precio']}',
        '{$_POST['cantidad']}',
        '{$_POST['stocA']}',
        '{$_POST['termino']}');";

    if ($conexion->query($sql)){
        $respuesta['res']=true;
    } */
} elseif ($tipo == 'se') {
    $sql = "SELECT * FROM ofertas_productos_api WHERE id_ofer=" . $_POST['ofer'];
    $respuesta = [];

    if ($row = $conexion->query($sql)->fetch_assoc()) {
        $respuesta = $row;
    }
} elseif ($tipo == 'up') {
    $sql = "UPDATE ofertas_productos_api
SET 
  precio_oferta = '{$_POST['precio']}',
  cantidad_stock = '{$_POST['cantidad']}', 
  fecha_termino = '{$_POST['termino']}'
WHERE id_ofer = '{$_POST['oferId']}';";

    if ($conexion->query($sql)) {
        $respuesta['res'] = true;
    }
} elseif ($tipo == 'del') {
    $sql = "DELETE
FROM ofertas_productos_api
WHERE id_ofer = '{$_POST['ofer']}';";

    if ($conexion->query($sql)) {
        $respuesta['res'] = true;
    }
}


echo json_encode($respuesta);
