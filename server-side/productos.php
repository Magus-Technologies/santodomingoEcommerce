<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
error_reporting(E_ALL);
require_once "serverside.php";
require_once "../extra/ProductosApi.php";


$table_data->get(
    "view_lista_productos",
    "prod_id",
    [
        "nombre",
        "nombre_cate",
        "etiqueta",
        "estado",
        "prod_cod", // Índice 4: Código para buscar en la API
        "prod_cod", // Índice 5: Espacio para precio
        "prod_id",
        "prod_id",
    ], true,
    function($data, $inf) {
        $productosApi = new ProductosApi();

        $codConsulta = substr($inf, 0, -1);
        $tempListData = $productosApi->getinfoData($codConsulta);
        
        // Validamos que tempListData sea un array para evitar errores de tipo
        if (!is_array($tempListData)) {
            $tempListData = [];
        }

        $reslFinalR = [];
        foreach ($data['aaData'] as $rowP) {
            // Buscamos el código del producto en los datos de la API
            $key = array_search($rowP[4], array_column($tempListData, 'cod_prod'));

            // VALIDACIÓN: Solo asignamos si se encontró el código en la API
            if ($key !== false && isset($tempListData[$key])) {
                $tempD = $tempListData[$key];
                $rowP[5] = $tempD['precio_venta'] ?? '0.00';
                $rowP[4] = $tempD['stock'] ?? '0';
            } else {
                // Valores por defecto si la API no responde para ese producto
                $rowP[5] = "N/A";
                $rowP[4] = "0";
            }
            $reslFinalR[] = $rowP;
        }
        $data['aaData'] = $reslFinalR;
        return $data;
    }
);
