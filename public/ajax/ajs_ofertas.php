<?php
require_once "../utils/Conexion.php";

$conexion = (new Conexion())->getConexion();
$tipo = $_POST['tipo'];


$respuesta = array("res" => false);

if ($tipo == 'in') {

    $sqlVerificar = "SELECT * FROM ofertas_productos WHERE producto_id = '{$_POST['prod']}'";
    $result = $conexion->query($sqlVerificar)->fetch_all(MYSQLI_ASSOC);
    if (empty($result)) {
        $sql = "INSERT INTO ofertas_productos
VALUES (NULL,
        '{$_POST['prod']}',
        '{$_POST['precio']}',
        '{$_POST['cantidad']}',
        '{$_POST['stocA']}',
        '{$_POST['termino']}',
        '1')";
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
    $sql = "SELECT 
  prod.prod_id,
  prod.nombre,
   prod.prod_cod,
  cate.nombre_cate,
  ofer.* 
FROM
  ofertas_productos AS ofer 
  INNER JOIN producto AS prod 
    ON ofer.producto_id = prod.prod_id 
  INNER JOIN grupo_seleccion AS cate 
    ON prod.categoria = cate.codi_categoria 
WHERE ofer.id_ofer=" . $_POST['ofer'];
    $respuesta = [];

    if ($row = $conexion->query($sql)->fetch_assoc()) {
        $respuesta = $row;
    }
} elseif ($tipo == 'up') {
    $sql = "UPDATE ofertas_productos
SET 
  precio_oferta = '{$_POST['precio']}',
  cantidad = '{$_POST['cantidad']}', 
  fecha_termino = '{$_POST['termino']}'
WHERE id_ofer = '{$_POST['oferId']}';";

    if ($conexion->query($sql)) {
        $respuesta['res'] = true;
    }
} elseif ($tipo == 'del') {
    $sql = "DELETE
FROM ofertas_productos
WHERE id_ofer = '{$_POST['ofer']}';";

    if ($conexion->query($sql)) {
        $respuesta['res'] = true;
    }
}


echo json_encode($respuesta);
