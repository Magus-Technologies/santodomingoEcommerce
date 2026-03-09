<?php

require_once "../../utils/Conexion.php";


$conexion = (new Conexion())->getConexion();

$tipo = $_POST['tipo'];

switch ($tipo) {
    case 'cn':

        $sql = "SELECT * FROM tcambio ORDER BY dfecha DESC LIMIT 1";
        $resp = $conexion->query($sql);
        $arr = [];
        if ($r = $resp->fetch_assoc()) {
            $arr = $r;
        }
        $tc = (float)$arr['cambio'];

        $category = isset($_POST['category']) ? $_POST['category'] : '001';
        $cpuCategory = isset($_POST['cpuCategory']) ? intval($_POST['cpuCategory']) : null;
        $table = "";
        if (isset($category) && $category > 0) {
            if ($category == 002 && $cpuCategory !== null) { // Placa madre category
                $query_data = "SELECT
                                    p.*,
                                    imagen_url,
                                    e.precio_venta 
                                FROM
                                    producto p
                                    INNER JOIN sopprod s ON s.cod_prod = p.prod_cod
                                    LEFT JOIN precios e ON e.cod_prod = s.cod_prod
                                    LEFT JOIN producto_foto pf ON pf.prod_id = p.prod_id 
                                WHERE
                                    p.categoria = '$category' and p.estado = 1 and p.stock_prod > 0
                                ORDER BY
                                    e.precio_venta DESC";
            } else {
                $query_data = "SELECT
                                    p.*,
                                    imagen_url,
                                    e.precio_venta 
                                FROM
                                    producto p
                                    INNER JOIN sopprod s ON s.cod_prod = p.prod_cod
                                    LEFT JOIN precios e ON e.cod_prod = s.cod_prod
                                    LEFT JOIN producto_foto pf ON pf.prod_id = p.prod_id 
                                WHERE
                                    p.categoria = '$category' 
                                    AND p.estado = 1 
                                    AND p.stock_prod > 0 
                                ORDER BY
                                    e.precio_venta DESC";
            }
        } else {
            $query_data = "SELECT
                                p.*,
                                imagen_url,
                                e.precio_venta 
                            FROM
                                producto p
                                INNER JOIN sopprod s ON s.cod_prod = p.prod_cod
                                LEFT JOIN precios e ON e.cod_prod = s.cod_prod
                                LEFT JOIN producto_foto pf ON pf.prod_id = p.prod_id 
                            WHERE
                                p.categoria = '001' 
                                AND p.estado = 1 
                                AND p.stock_prod > 0 
                            ORDER BY
                                e.precio_venta DESC ";
        }

        $data = $conexion->query($query_data);
        foreach ($data as $product) {
            $productName = isset($product['nombre']) ? $product['nombre'] : 'Producto sin nombre';
            $productPrice = isset($product['precio_venta']) ? number_format($product['precio_venta'] * $tc, 2) : 0.00;
            $productId = isset($product['prod_cod']) ? $product['prod_cod'] : 0;

            $table .= '<div class="product-item">';
            $table .= '<input type="checkbox" class="checkbox" data-product-id="' . $productId . '" data-category-cpu="' . $product['categoria'] . '" data-price="' . $productPrice . '">';
            $table .= '<img src="../public/img/productos/' . $product['imagen_url'] . '" alt="' . $productName . '">';
            $table .= '<div class="product-info">';
            $table .= '<div>' . $productName . '</div>';
            $table .= '<div class="price">S/ ' . $productPrice . '</div>';
            $table .= '</div>';
            $table .= '<div>S/ ' . $productPrice . '</div>';
            $table .= '</div>';
        }
        $html = $table;
        echo json_encode(['html' => $html]);
        break;
}
