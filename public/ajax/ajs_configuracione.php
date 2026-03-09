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
    $producto=$_POST['info'];
    $tools->guardarConfiguarion(json_decode($producto));
    echo "true";

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
    echo json_encode($configuracion['banner_pricipal']);
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

}elseif ($tipo=='banner_extra'){
    echo json_encode($configuracion['banner_extra']);
}
elseif ($tipo=='banner_extra_IN'){
    $banners=$_POST['data'];
    $configuracion['banner_extra']=json_decode($banners);
    $tools->guardarConfiguarion($configuracion);

}





