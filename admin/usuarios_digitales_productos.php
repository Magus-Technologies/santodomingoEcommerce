<?php
    session_start();


    require "../dao/Session.php";
    $sessionModel = new Session;
    $validate = $sessionModel->validateSession();

    if ($validate['perfil'] == 'usuarios digital' or $validate['perfil'] == 'admin') {


        require "../utils/Tools.php";
        require "../dao/ProductoDao.php";
        require_once "../utils/Conexion.php";
        require_once "../extra/TasaCambioApi.php";

        $tasaCambioApi = new TasaCambioApi();
        $cambio = $tasaCambioApi->getTasaCambio();
        $tc = $cambio['cambio'] ?? 0;

        $conexion = (new Conexion())->getConexion();
        $q = $_GET['term'] ?? '';
        $q = onlyTrim(strtolower($q));

        $sql = "SELECT
                    CONCAT('Codigo : ', a.prod_cod,' | Nombre : ', a.nombre,' | Marca : ', a.marca,' | Precio : ', a.precio_prod) AS 'value',
                    a.prod_id,
                    (SELECT imagen_url FROM producto_foto WHERE prod_id = a.prod_id LIMIT 1) AS imagen1,
                    (SELECT CONCAT('../public/img/productos/',imagen_url) FROM producto_foto WHERE prod_id = a.prod_id LIMIT 1) AS imagen,
                    a.categoria,
                    a.sub_cat,
                    a.nombre,
                    a.content1,
                    a.content2,
                    a.content3,
                    a.marca,
                    a.prod_cod,
                    a.descripcion,
                    a.caracteristicas,
                    a.precio_prod,
                    ROUND((a.precio_prod*$tc),2) AS precio_prod_soles,
                    a.stock_prod,
                    a.tipo_pro,
                    a.estado,
                    a.garantia,
                    a.precio_oferta,
                    a.estado_prod
                FROM producto a
                WHERE (
                    LOWER(REPLACE(a.nombre,' ','')) LIKE '%$q%' OR 
                    LOWER(REPLACE(a.marca,' ','')) LIKE '%$q%' OR
                    LOWER(REPLACE(a.prod_cod,' ','')) LIKE '%$q%'
                 )
                LIMIT 10";

        $result = $conexion->query($sql);
        $result = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($result);
    } else {
        header("Location: ../CYM/");
    }
?>