<?php
session_start();
require "../dao/ProductoDao.php";
require "../dao/MarcaSeleccionDao.php";
require "../dao/CategoriaSeleccionDao.php";

$productoDao = new ProductoDao();
$marcaSeleccionDao = new MarcaSeleccionDao();
$categoriaSeleccionDao = new CategoriaSeleccionDao();

$tipo = $_POST['tipo'];

$respuesta = array("res" => false);

if ($tipo == 'count_prod') {
    $res = $productoDao->getCountProd();
    if ($row = $res->fetch_assoc()) {
        $respuesta['res'] = true;
        $respuesta['cnt'] = $row['count_prod'];
    }
} elseif ($tipo == 'usr_crd_svd') {
    $listaCrrito = json_decode($_POST['car'], true);
    $sql = "DELETE FROM carrito_compra WHERE usuario_id = '{$_SESSION['usuario']}';";
    $productoDao->exeSQL($sql);
    foreach ($listaCrrito as $car) {
        $sql = "INSERT INTO carrito_compra SET usuario_id='{$_SESSION['usuario']}',prod_id='{$car['prod']}',cantidad='{$car['cantidad']}'";
        $productoDao->exeSQL($sql);
    }
} elseif ($tipo == 'usr_crd_lts') {
    $productosApi = new ProductosApi();
    $sql = "select p.prod_cod,cr.cantidad,cr.carrito_id,cr.prod_id,p.nombre from carrito_compra as cr 
    join producto p on p.prod_id = cr.prod_id where usuario_id='{$_SESSION['usuario']}'";
    $result = $productoDao->exeSQL($sql);
    $respuesta = [];
    $precioDescuento = 0;
    foreach ($result as $row) {
        $conRay = $productosApi->getDataProd($row['prod_cod']);
        $row['precio'] = $conRay['precio_venta'];
        $row['stock'] = $conRay['stock'];
        
        $sql2 = "SELECT * FROM ofertas_productos WHERE fecha_termino >= NOW() and producto_id = " . $row['prod_id'];
        $result3 = $productoDao->exeSQL($sql2);
        if ($result3->num_rows > 0) {
            foreach ($result3 as $nuevoPrecioOferta) {
                $respuesta['precio'] = $nuevoPrecioOferta['precio_oferta'];
            }
        }
        $sql = "select * from producto_foto where prod_id = '{$row['prod_id']}' limit 1";
        $result2 = $productoDao->exeSQL($sql);
        $row['imagen'] = '';

        if ($img = $result2->fetch_assoc()) {
            $row['imagen'] = $img['imagen_url'];
        }

        $respuesta[] = $row;
    }
} elseif ($tipo == 'pag-search2') {

    $prod = $_POST['pal'];

    $resp = $productoDao->getListaProd2Search($prod);

    $respuest = [];

    $contador = 0;
    foreach ($resp as $rowE) {

        if (strlen($prod) > 0) {
            $pos = strpos(strtoupper($rowE['nom_prod'] . ' ' . $rowE['sub_cat'] . ' ' . $rowE['nombre_cate'] . ' ' . $rowE['nombre_marca']), strtoupper($prod));
            if ($pos !== false) {
                $respuest[] = $rowE;
            }
        } else {
            $respuest[] = $rowE;
        }
    }

    $respuesta = $respuest;
} elseif ($tipo == 'pag-search-mar') {

    $prod = $_POST['marca'];

    $resp = $productoDao->getListaProdmarc($prod);

    $respuesta = $resp;
} elseif ($tipo == 'pag-search-exclu') {


    $resp = $productoDao->getListaProdExclu();

    $respuesta = $resp;
} elseif ($tipo == 'pag-search-remate') {


    $resp = $productoDao->getListaProdRemate2();

    $respuesta = $resp;
} elseif ($tipo == 'pag-search-ofert') {


    $resp = $productoDao->getListaProdOfert();

    $respuesta = $resp;
} elseif ($tipo == 'del_prod_admin') {
    $prod = $_POST['prod'];

    /*  echo json_encode($prod);
    die(); */
    $sql = "SELECT
  foto_id,
  prod_id,
  imagen_url,
  orden
FROM producto_foto WHERE  prod_id= '$prod'";

    foreach ($productoDao->exeSQL($sql) as $rowImg) {
        if (unlink('../public/img/productos/' . $rowImg['imagen_url'])) {
        }
    }

    $sql = "DELETE
FROM producto_foto
WHERE producto_foto.prod_id = '$prod';";
    $productoDao->exeSQL($sql);

    $sql = "DELETE
FROM productos_exclusivos
WHERE productos_exclusivos.prod_id = '$prod';";
    $productoDao->exeSQL($sql);

    $sql = "DELETE
FROM ofertas_productos
WHERE ofertas_productos.producto_id = '$prod';";
    $productoDao->exeSQL($sql);

    $sql = "DELETE
FROM pedido_detalles
WHERE id_producto  = '$prod';";
    $productoDao->exeSQL($sql);

    $sql = "DELETE
FROM carrito_compra
WHERE prod_id  = '$prod';";
    $productoDao->exeSQL($sql);


    $sql = "DELETE
FROM producto
WHERE prod_id = '$prod';";
    $productoDao->exeSQL($sql);

    $respuesta['res'] = true;
} elseif ($tipo == 'pag-search') {
    $cnt = $_POST['cnt'];
    $minId = $_POST['min'];
    $prod = $_POST['pal'];

    $resp = $productoDao->getListaProd();

    $respuest = [];

    $contador = 0;
    foreach ($resp as $rowE) {

        if ($minId < $rowE['prod_id']) {
            if (strlen($prod) > 0) {
                $pos = strpos(strtoupper($rowE['nom_prod']), strtoupper($prod));
                if ($pos !== false) {
                    if ($contador < $cnt) {
                        $respuest[] = $rowE;
                        $contador++;
                    }
                    if ($contador >= $cnt) {
                        break;
                    }
                }
            } else {
                if ($contador < $cnt) {
                    $respuest[] = $rowE;

                    $contador++;
                }
                if ($contador >= $cnt) {
                    break;
                }
            }
        }
    }

    $respuesta = $respuest;
} elseif ($tipo == 'pag-search-count') {
    $prod = $_POST['pal'];
    $resp = $productoDao->getListaProd();

    $respuest = [];

    foreach ($resp as $rowE) {
        if (strlen($prod) > 0) {
            $pos = strpos(strtoupper($rowE['nom_prod']), strtoupper($prod));
            if ($pos !== false) {
                $respuest[] = $rowE;
            }
        } else {
            $respuest[] = $rowE;
        }
    }

    $respuesta['res'] = true;
    $respuesta['cnt'] = count($respuest);
} elseif ($tipo == 'prod-s-data') {
    $prod = $_POST['idProd'];
    $productoDao->setProdId($prod);
    $respuesta = $productoDao->getData();
} elseif ($tipo == 'prod-s-data2') {
    $prod = $_POST['idProd'];
    $productoDao->setProdId($prod);
    $respuesta = $productoDao->getData22();
} elseif ($tipo == 'prod-u') {
    $productoDao->setProdId($_POST['id_prod']);
    $productoDao->setNombre($_POST['nom_pro']);
    $productoDao->setContent1($_POST['conten1']);
    $productoDao->setContent2($_POST['conten2']);
    $productoDao->setContent3($_POST['conten3']);
    $productoDao->setSubCate($_POST['subCat']);
    $productoDao->setGarantia($_POST['garantia']);
    $productoDao->setDescripcion($_POST['descripcion']);
    $productoDao->setCaracteristicas($_POST['especificaciones']);
    $productoDao->setEstado($_POST['estado']);

    if ($productoDao->update()) {
        $respuesta['res'] = true;
        $respuesta['prod_ID'] = $_POST;
    }
} elseif ($tipo == 'prod-u2') {
    $cod_mar = $_POST['cod_marca'];
    $nom_mar = $_POST['marc'];
    $marcaSeleccionDao->setCodMarca($cod_mar);
    $marcaSeleccionDao->setNombre($nom_mar);

    $marcaSeleccionDao->insertIsNull();


    $productoDao->setProdId($_POST['id_prod']);
    $productoDao->setNombre($_POST['nom_pro']);
    $productoDao->setContent1($_POST['conten1']);
    $productoDao->setContent2($_POST['conten2']);
    $productoDao->setContent3($_POST['conten3']);

    $productoDao->setDescripcion($_POST['descripcion']);
    $productoDao->setCaracteristicas($_POST['especificaciones']);
    $productoDao->setPrecioProd($_POST['precio_prod']);
    $productoDao->setStockProd($_POST['stock_prod']);
    $productoDao->setMarca($cod_mar);

    if ($productoDao->update2()) {
        $respuesta['res'] = true;
        $respuesta['prod_ID'] = $productoDao->getProdId();
    }
} elseif ($tipo == 'prod-i') {
    $cod_mar = $_POST['cod_mar'];
    $cod_cat = $_POST['cod_cat'];
    $nom_mar = $_POST['marc'];
    $marcaSeleccionDao->setCodMarca($cod_mar);
    $marcaSeleccionDao->setNombre($nom_mar);
    $categoriaSeleccionDao->setCodiCategoria($cod_cat);
    $marcaSeleccionDao->insertIsNull();
    $categoriaSeleccionDao->insertIsNull();

    $productoDao->setDescripcion($_POST['descripcion']);
    $productoDao->setEstado('1');
    $productoDao->setCaracteristicas($_POST['especificaciones']);
    $productoDao->setProdCod($_POST['cod_prod']);
    $productoDao->setNombre($_POST['nom_pro']);
    $productoDao->setCategoria($cod_cat);
    $productoDao->setMarca($cod_mar);
    $productoDao->setSubCate($_POST['subCat']);
    $productoDao->setContent1($_POST['conten1']);
    $productoDao->setContent2($_POST['conten2']);
    $productoDao->setContent3($_POST['conten3']);
    $productoDao->setPrecioProd(0);
    $productoDao->setStockProd(0);
    $productoDao->setGarantia($_POST['garantia']);
    $productoDao->setTipoPro('1');

    if ($productoDao->insertar()) {
        $respuesta['res'] = true;
        $respuesta['prod_ID'] = $productoDao->getProdId();
    }
} elseif ($tipo == 'prod-i2') {
    $cod_mar = $_POST['cod_marca'];
    $cod_cat = $_POST['cod_marca'];
    $nom_mar = $_POST['marc'];
    $marcaSeleccionDao->setCodMarca($cod_mar);
    $marcaSeleccionDao->setNombre($nom_mar);

    $marcaSeleccionDao->insertIsNull();

    $productoDao->setDescripcion($_POST['descripcion']);
    $productoDao->setEstado('1');
    $productoDao->setCaracteristicas($_POST['especificaciones']);
    $productoDao->setProdCod('');
    $productoDao->setNombre($_POST['nom_pro']);
    $productoDao->setCategoria(null);
    $productoDao->setMarca($cod_mar);
    $productoDao->setSubCate(null);
    $productoDao->setContent1($_POST['conten1']);
    $productoDao->setContent2($_POST['conten2']);
    $productoDao->setContent3($_POST['conten3']);
    $productoDao->setPrecioProd($_POST['precio_prod']);
    $productoDao->setStockProd($_POST['stock_prod']);
    $productoDao->setTipoPro('2');


    if ($productoDao->insertar()) {
        $respuesta['res'] = true;
        $respuesta['prod_ID'] = $productoDao->getProdId();
    }
} elseif ($tipo == 'prod-cat-all') {


    $productosApi = new ProductosApi();

    $cate = $_POST['ctg'];

    $temResp = $productosApi->getDataCatego($cate);
    $newLista = [];
    foreach ($temResp as $row) {
        $respupu =  $productoDao->getDataExeSQL("SELECT * FROM producto WHERE prod_cod = '{$row['cod_prod']}'");
        if ($rorro = $respupu->fetch_assoc()) {
        } else {
            $newLista[] = $row;
        }
    }
    $respuesta = $newLista;
} elseif ($tipo == 'prod-cat-marc') {
    $productosApi = new ProductosApi();

    $cate = $_POST['ctg'];
    $marc = $_POST['mrc'];

    $temResp = $productosApi->getProdCateMarc($cate, $marc);
    $newLista = [];
    foreach ($temResp as $row) {
        $respupu =  $productoDao->getDataExeSQL("SELECT * FROM producto WHERE prod_cod = '{$row['cod_prod']}'");
        if ($rorro = $respupu->fetch_assoc()) {
        } else {
            $newLista[] = $row;
        }
    }
    $respuesta = $newLista;
} elseif ($tipo == 'pag-ctg-count') {


    $cate = $_POST['ctg'];

    $res = $productoDao->getProdPagGruCatCount($cate);
    if ($row = $res->fetch_assoc()) {
        $respuesta['res'] = true;
        $respuesta['cnt'] = $row['count_prod'];
    }
} elseif ($tipo == 'pag-gtp-mrc-count') {

    $grupo = $_POST['gtp'];
    $marca = $_POST['mrc'];
    $res = $productoDao->getProdPagGruMarCount($grupo, $marca);
    if ($row = $res->fetch_assoc()) {
        $respuesta['res'] = true;
        $respuesta['cnt'] = $row['count_prod'];
    }
} elseif ($tipo == 'pag') {

    $productosApi = new ProductosApi();

    $respuesta = [];
    $cnt = $_POST['cnt'];
    $minId = $_POST['min'];
    $res = $productoDao->getProdPag($minId, $cnt);
    foreach ($res as $row) {

        $conRay = $productosApi->getDataProd($row['prod_cod']);

        $row['cate_cod'] = $conRay['cod_cate'];
        $row['cod_marca'] = $conRay['cod_subc'];
        $row['cod_esp'] = $conRay['cod_espe'];
        $row['nom_prod'] = $conRay['nom_prod'];
        $row['unidad'] = $conRay['nom_unid'];
        $row['precio'] = $conRay['precio_venta'];
        $row['stock'] = $conRay['stock'];
        $row['imagen1'] = '';
        $row['imagen2'] = '';

        $sql = "SELECT * FROM producto_foto WHERE prod_id = {$row['prod_id']} ORDER BY  orden ASC LIMIT 2";

        $respImg = $this->conexion->query($sql);
        $cont = 1;
        foreach ($respImg as $rowImg) {
            if ($cont == 1) {
                $row['imagen1'] = $rowImg['imagen_url'];
            } elseif ($cont == 2) {
                $row['imagen2'] = $rowImg['imagen_url'];
            }
            $cont++;
        }
        $row['imagen1'] = strlen($row['imagen1']) > 0 ? $row['imagen1'] : 'sinimagen_mtr_20sba.jpg';
        $row['imagen2'] = strlen($row['imagen2']) > 0 ? $row['imagen2'] : 'sinimagen_mtr_20sba.jpg';

        $respuesta[] = $row;
    }
} elseif ($tipo == 'pag-ctg') {
    $productosApi = new ProductosApi();
    $respuesta = [];
    /*$cnt = $_POST['cnt'];
    $minId = $_POST['min'];*/
    $cate = $_POST['ctg'];
    $res = $productoDao->getProdPagGate($cate);
    foreach ($res as $row) {

        $conRay = $productosApi->getDataProd($row['prod_cod']);
        $row['cate_cod'] = $conRay['cod_cate'];
        $row['cod_marca'] = $conRay['cod_subc'];
        $row['cod_esp'] = $conRay['cod_espe'];
        $row['marca'] = $conRay['nom_sub2'];
        $row['categoria'] = $conRay['nom_sub1'];
        $row['nom_prod'] = $conRay['nom_prod'];
        $row['unidad'] = $conRay['nom_unid'];
        $row['precio'] = $conRay['precio_venta'];
        $row['stock'] = $conRay['stock'];
        $row['imagen1'] = '';
        $row['imagen2'] = '';
        $row['is_ofert'] = false;

        $sql = "SELECT * FROM ofertas_productos WHERE fecha_termino >= NOW() and producto_id = " . $row['prod_id'];
        $respOfer = $productoDao->getDataExeSQL($sql);
        if ($rowOffer = $respOfer->fetch_assoc()) {
            $row['is_ofert'] = true;
            $row['precio_ofer'] = $rowOffer['precio_oferta'];
        }

        $sql = "SELECT * FROM producto_foto WHERE prod_id = {$row['prod_id']} ORDER BY  orden ASC LIMIT 2";
        //echo $sql;
        $respImg = $productoDao->getDataExeSQL($sql);
        $cont = 1;
        foreach ($respImg as $rowImg) {
            if ($cont == 1) {
                $row['imagen1'] = $rowImg['imagen_url'];
            } elseif ($cont == 2) {
                $row['imagen2'] = $rowImg['imagen_url'];
            }
            $cont++;
        }
        $row['imagen1'] = strlen($row['imagen1']) > 0 ? $row['imagen1'] : 'sinimagen_mtr_20sba.jpg';
        $row['imagen2'] = strlen($row['imagen2']) > 0 ? $row['imagen2'] : 'sinimagen_mtr_20sba.jpg';

        $respuesta[] = $row;
    }
} elseif ($tipo == 'pag-gtp-mrc') {
    $productosApi = new ProductosApi();

    $respuesta = [];
    $cnt = $_POST['cnt'];
    $minId = $_POST['min'];
    $grupo = $_POST['gtp'];
    $marca = $_POST['mrc'];
    $res = $productoDao->getProdPagGruMar($minId, $cnt, $grupo, $marca);
    foreach ($res as $row) {

        $conRay = $productosApi->getDataProd($row['prod_cod']);
        $row['cate_cod'] = $conRay['cod_cate'];
        $row['cod_marca'] = $conRay['cod_subc'];
        $row['cod_esp'] = $conRay['cod_espe'];
        $row['nom_prod'] = $conRay['nom_prod'];
        $row['unidad'] = $conRay['nom_unid'];
        $row['precio'] = $conRay['precio_venta'];
        $row['stock'] = $conRay['stock'];
        $row['imagen1'] = '';
        $row['imagen2'] = '';
        $row['is_ofert'] = false;

        $sql = "SELECT * FROM ofertas_productos WHERE fecha_termino >= NOW() and producto_id = " . $row['prod_id'];
        $respOfer = $productoDao->getDataExeSQL($sql);
        if ($rowOffer = $respOfer->fetch_assoc()) {
            $row['is_ofert'] = true;
            $row['precio_ofer'] = $rowOffer['precio_oferta'];
        }

        $sql = "SELECT * FROM producto_foto WHERE prod_id = {$row['prod_id']} ORDER BY  orden ASC LIMIT 2";
        //echo $sql;
        $respImg = $productoDao->getDataExeSQL($sql);
        $cont = 1;
        foreach ($respImg as $rowImg) {
            if ($cont == 1) {
                $row['imagen1'] = $rowImg['imagen_url'];
            } elseif ($cont == 2) {
                $row['imagen2'] = $rowImg['imagen_url'];
            }
            $cont++;
        }
        $row['imagen1'] = strlen($row['imagen1']) > 0 ? $row['imagen1'] : 'sinimagen_mtr_20sba.jpg';
        $row['imagen2'] = strlen($row['imagen2']) > 0 ? $row['imagen2'] : 'sinimagen_mtr_20sba.jpg';

        $respuesta[] = $row;
    }
} elseif ($tipo == 'producto') {
    $productosApi = new ProductosApi();
    $id_prod = $_POST['prod'];
    $productoDao->setProdId($id_prod);
    $result = $productoDao->getData();
    if ($row = $result->fetch_assoc()) {

        $conRay = $productosApi->getDataProd($row['prod_cod']);
        $row['cate_cod'] = $conRay['cod_cate'];
        $row['cod_marca'] = $conRay['cod_subc'];
        $row['cod_esp'] = $conRay['cod_espe'];
        $row['nom_prod'] = $conRay['nom_prod'];
        $row['unidad'] = $conRay['nom_unid'];
        $row['precio'] = $conRay['precio_venta'];
        $row['stock'] = $conRay['stock'];

        $respuesta = $row;
    }
} elseif ($tipo == 'producto-onli') {
    $productosApi = new ProductosApi();
    $cod_prod = $_POST['cod'];
    $conRay = $productosApi->getDataProd($cod_prod);
    $respuesta = $conRay;
} elseif ($tipo == 'actualizar_producto_oferta_nossession') {
    $data = json_decode($_POST['data'], true);
    $ultimo = end($data);
    $idProd = $ultimo['prod'];
    $sql = "SELECT * FROM ofertas_productos WHERE  fecha_termino >= NOW() AND estado ='1' AND producto_id =  '$idProd'";
    $respForEach = $productoDao->getDataExeSQL($sql);
    if ($respForEach->num_rows > 0) {
        foreach ($respForEach as  $value) {
            $ultimo['precio'] = $value['precio_oferta'];
            $respuesta = $ultimo;
        }
    } else {
        $respuesta = $ultimo;
    }
    /* $respuesta = $idProd;  */
}

echo json_encode($respuesta);
