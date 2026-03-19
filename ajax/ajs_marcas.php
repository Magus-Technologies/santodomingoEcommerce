<?php

require "../dao/MarcaSeleccionDao.php";

$conexion = (new Conexion())->getConexion();

$respuesta = array("res" => false);
$tipo = $_POST['tipo'];

if ($tipo == "s") {
    $sql = "SELECT marca_id, nombre_marca as 'nombre', cod_marca, imagen
            FROM marcra_productos WHERE estado ='1' ORDER BY nombre_marca";
    $res = $conexion->query($sql);
    $respuesta = [];
    foreach ($res as $re) {
        $re['imagen'] = strlen($re['imagen']) < 5 ? 'sin_imagen.png' : $re['imagen'];
        $respuesta[] = $re;
    }
} elseif ($tipo == 'all') {
    // Todas las marcas (activas e inactivas) para el admin
    $sql = "SELECT marca_id, nombre_marca as 'nombre', cod_marca, imagen, estado
            FROM marcra_productos ORDER BY nombre_marca";
    $res = $conexion->query($sql);
    $respuesta = [];
    foreach ($res as $re) {
        $re['imagen'] = strlen($re['imagen']) < 5 ? '' : $re['imagen'];
        $respuesta[] = $re;
    }
} elseif ($tipo == 'marcas_facturacion') {
    // Marcas del sistema de facturación (misma BD en el mismo servidor)
    $sql = "SELECT cod_marca, nombre_marca FROM factura_santod3.marcra_productos ORDER BY nombre_marca";
    $res = $conexion->query($sql);
    $respuesta = [];
    if ($res) {
        foreach ($res as $re) {
            $respuesta[] = $re;
        }
    }
} elseif ($tipo == 'show') {
    // Mostrar marca en ecommerce (reactivar)
    $sql = "UPDATE marcra_productos SET estado='1' WHERE marca_id='{$_POST['del_id']}'";
    if ($conexion->query($sql)) {
        $respuesta['res'] = true;
    }
} elseif ($tipo == 'delImg') {
    // Eliminar solo la imagen
    $sql = "UPDATE marcra_productos SET imagen='' WHERE marca_id='{$_POST['marc']}'";
    if ($conexion->query($sql)) {
        $respuesta['res'] = true;
    }
} elseif ($tipo == 'in') {
    $codMarca  = $conexion->real_escape_string($_POST['cod']);
    $nombre    = $conexion->real_escape_string($_POST['nom']);
    $imagen    = $conexion->real_escape_string($_POST['imagen']);
    $sql = "INSERT INTO marcra_productos (nombre_marca, cod_marca, imagen, estado)
            VALUES ('$nombre', '$codMarca', '$imagen', '1')";
    if ($conexion->query($sql)) {
        $respuesta['res'] = true;
    } else {
        $respuesta['error'] = $conexion->error;
    }
} elseif ($tipo == 'up') {
    $sql = "UPDATE marcra_productos SET imagen = '{$_POST['imagen']}' WHERE marca_id = '{$_POST['marc']}'";
    if ($conexion->query($sql)) {
        $respuesta['res'] = true;
    }
} elseif ($tipo == 'delM') {
    // Ocultar marca del ecommerce (soft delete)
    $idmarca = $_POST['del_id'];
    $sql = "UPDATE marcra_productos SET estado='0' WHERE marca_id='{$idmarca}'";
    if ($conexion->query($sql)) {
        $respuesta['res'] = true;
    }
}

echo json_encode($respuesta);
