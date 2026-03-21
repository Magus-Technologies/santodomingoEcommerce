<?php
require "../utils/Tools.php";

$tools = new Tools();

$tipo = $_POST['tipo'];

$configuracion = $tools->getConfiguracion();

if ($tipo=='banner1'){
    $producto=$_POST['prod'];
    $img=$_POST['imagen'];
    $configuracion['banner1']['prod']=$producto;
    $configuracion['banner1']['image']=$img;

    $tools->guardarConfiguarion($configuracion);

}elseif ($tipo=='info_princ'){
    echo json_encode($configuracion);

}elseif ($tipo=='banner1_prod') {
    $producto = $_POST['prod'];
    $img = $_POST['imagen'];
    $configuracion['bannerprod1']['prod'] = $producto;
    $configuracion['bannerprod1']['image'] = $img;

    $tools->guardarConfiguarion($configuracion);


}elseif ($tipo=='banner2_prod') {
    $producto = $_POST['prod'];
    $img = $_POST['imagen'];
    $configuracion['bannerprod2']['prod'] = $producto;
    $configuracion['bannerprod2']['image'] = $img;

    $tools->guardarConfiguarion($configuracion);


}elseif ($tipo=='banner2') {
    $producto = $_POST['prod'];
    $img = $_POST['imagen'];
    $configuracion['banner2']['prod'] = $producto;
    $configuracion['banner2']['image'] = $img;

    $tools->guardarConfiguarion($configuracion);


}elseif ($tipo=='save-info'){
     try {
        $producto = $_POST['info'];
        $tools->guardarConfiguarion(json_decode($producto));
        echo "true";
    } catch (Exception $e) {
        // Esto obligará a que el error aparezca en la respuesta de red
        http_response_code(500);
        echo "ERROR CAPTURADO: " . $e->getMessage();
        exit;
    }

}elseif ($tipo=='banner1cen'){
    $producto=$_POST['prod'];
    $img=$_POST['imagen'];
    $configuracion['banercentarl1']['prod']=$producto;
    $configuracion['banercentarl1']['image']=$img;

    $tools->guardarConfiguarion($configuracion);

}elseif ($tipo=='banner2cen'){
    $producto=$_POST['prod'];
    $img=$_POST['imagen'];
    $configuracion['banercentarl2']['prod']=$producto;
    $configuracion['banercentarl2']['image']=$img;

    $tools->guardarConfiguarion($configuracion);


}elseif ($tipo=='banner3cen'){
    $producto=$_POST['prod'];
    $img=$_POST['imagen'];
    $configuracion['banercentarl3']['prod']=$producto;
    $configuracion['banercentarl3']['image']=$img;

    $tools->guardarConfiguarion($configuracion);

}elseif ($tipo=='bannerP_s'){
    echo json_encode($configuracion['banner_pricipal'] ?? []);
}elseif ($tipo=='bannerP_I'){
    $banners=$_POST['data'];
    $configuracion['banner_pricipal']=json_decode($banners);
    $tools->guardarConfiguarion($configuracion);

}elseif ($tipo=='whatsapp'){
    $link=$_POST['link'];
    $configuracion['whatsapp']=$link;
    $tools->guardarConfiguarion($configuracion);

}elseif ($tipo=='banner_lateral_6'){
    echo json_encode($configuracion['banner_menu_lateral_6']);
}
elseif ($tipo=='banner_lat_menu_6'){
    $banners=$_POST['data'];
    $configuracion['banner_menu_lateral_6']=json_decode($banners);
    $tools->guardarConfiguarion($configuracion);


}elseif ($tipo=='banner_inferior'){
    echo json_encode($configuracion['banner_inferior']);
}
elseif ($tipo=='banner_inferior_IN'){
    $banners=$_POST['data'];
    $configuracion['banner_inferior']=json_decode($banners);
    $tools->guardarConfiguarion($configuracion);

}elseif ($tipo=='banner_extra_remate'){
    if ($configuracion['banner_extra_remate']){
        echo json_encode($configuracion['banner_extra_remate']);
    }else{
        echo json_encode([]);
    }


}elseif ($tipo=='banner_extra'){
    echo json_encode($configuracion['banner_extra']);
}elseif ($tipo=='banner_extra_remate_IN'){
    $banners=$_POST['data'];
    $configuracion['banner_extra_remate']=json_decode($banners);
    $tools->guardarConfiguarion($configuracion);

}
elseif ($tipo=='banner_extra_IN'){
    $banners=$_POST['data'];
    $configuracion['banner_extra']=json_decode($banners);
    $tools->guardarConfiguarion($configuracion);

}elseif ($tipo=='seccion_tradicion'){
    $configuracion['seccion_tradicion']['titulo'] = $_POST['titulo'];
    $configuracion['seccion_tradicion']['color']  = $_POST['color'] ?? '#ffffff';
    if (!empty($_POST['imagen'])) {
        $configuracion['seccion_tradicion']['imagen'] = $_POST['imagen'];
    }
    $tools->guardarConfiguarion($configuracion);
    echo json_encode(['res' => true]);

}elseif ($tipo=='menu_nav_s'){
    if (!isset($configuracion['menu_nav'])) {
        $configuracion['menu_nav'] = [];
    }
    echo json_encode($configuracion['menu_nav']);

}elseif ($tipo=='menu_nav_IN'){
    try {
        $items = json_decode($_POST['data'], true);
        $configuracion['menu_nav'] = $items;
        $tools->guardarConfiguarion($configuracion);
        echo json_encode(['res' => true]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['res' => false, 'error' => $e->getMessage()]);
        exit;
    }

}elseif ($tipo=='seleccion_save'){
    $indice = (int)$_POST['indice'];
    if ($indice >= 0 && $indice <= 3) {
        if (!isset($configuracion['nuestra_seleccion'])) {
            $configuracion['nuestra_seleccion'] = [
                ["titulo" => "Vinos Tintos",  "imagen" => "", "url" => "shop-list-ctg.php?ctg=001"],
                ["titulo" => "Vinos Blancos", "imagen" => "", "url" => "shop-list-ctg.php?ctg=002"],
                ["titulo" => "Vinos Rosados", "imagen" => "", "url" => "shop-list-ctg.php?ctg=003"],
                ["titulo" => "Espumantes",    "imagen" => "", "url" => "shop-list-ctg.php?ctg=004"]
            ];
        }
        $configuracion['nuestra_seleccion'][$indice]['titulo'] = $_POST['titulo'];
        $configuracion['nuestra_seleccion'][$indice]['url']    = $_POST['url'];
        $configuracion['nuestra_seleccion'][$indice]['imagen'] = $_POST['imagen'];
        $tools->guardarConfiguarion($configuracion);
        echo 'ok';
    }
} elseif ($tipo === 'terminos_S') {
    echo json_encode($configuracion['terminos'] ?? []);
} elseif ($tipo === 'terminos_IN') {
    $data = json_decode($_POST['data'], true);
    if ($data) {
        $configuracion['terminos'] = $data;
        $tools->guardarConfiguarion($configuracion);
        echo json_encode(['res' => true]);
    } else {
        echo json_encode(['res' => false]);
    }
} elseif ($tipo === 'nosotros_S') {
    echo json_encode($configuracion['nosotros'] ?? []);
} elseif ($tipo === 'nosotros_IN') {
    $data = json_decode($_POST['data'], true);
    if ($data) {
        $configuracion['nosotros'] = $data;
        $tools->guardarConfiguarion($configuracion);
        echo json_encode(['res' => true]);
    } else {
        echo json_encode(['res' => false, 'msg' => 'Datos inválidos']);
    }
} elseif ($tipo === 'save_pdf_config') {
    $logoPath = $configuracion['pdf_empresa']['logo'] ?? '../public/images/cym.png';

    if (!empty($_FILES['logo']['tmp_name'])) {
        $ext = strtolower(pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
            $filename = 'logo_pdf_' . time() . '.' . $ext;
            $dest = __DIR__ . '/../public/img/pdf/' . $filename;
            if (!is_dir(dirname($dest))) mkdir(dirname($dest), 0775, true);
            if (move_uploaded_file($_FILES['logo']['tmp_name'], $dest)) {
                $logoPath = '../public/img/pdf/' . $filename;
            }
        }
    }

    $configuracion['pdf_empresa'] = [
        'empresa'   => trim($_POST['empresa'] ?? ''),
        'ruc'       => trim($_POST['ruc'] ?? ''),
        'direccion' => trim($_POST['direccion'] ?? ''),
        'garantia'  => trim($_POST['garantia'] ?? '12 meses'),
        'logo'      => $logoPath,
    ];
    $tools->guardarConfiguarion($configuracion);
    echo json_encode(['res' => true]);
}





