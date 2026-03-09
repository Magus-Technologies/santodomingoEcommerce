<?php
require  "../dao/ProductoDao.php";

$productoDao = new ProductoDao();

$prod =   $_GET['prod'];

$productoDao->setProdId($prod);

$dataProd  = $productoDao->getData();
$precio = number_format($dataProd['precio'], 2, '.', ',');

$imagen = "sinimagen_mtr_20sba.jpg";
if (count($dataProd['imagenes'])>0){
    $imagen =  $dataProd['imagenes'][0]['imagen_url'];
}
$stock_html =  $dataProd['stock']>0?'<span class="in-stock">En Stock</span>':'<span class="out-stock">Sin Stock</span>';


//print_r($dataProd);

$productoDao->setCategoria($dataProd['categoria_cod']);
$productoDao->setMarca($dataProd['marca_cod']);
$listaProsSimilares = $productoDao->getDataCopare();

$isProd1 =false;
$prod1 =[];

$isProd2 =false;
$prod2 =[];

$conta = 0;
foreach ($listaProsSimilares as $roProdSim){
    if ($conta == 0){
        $isProd1 =true;
        $prod1 =$roProdSim;
    }elseif ($conta == 1){
        $isProd2 =true;
        $prod2 =$roProdSim;
    }
    $conta++;
}


//print_r($dataProd);
?>
<div class="compare_box">
	<div class="table-responsive">
    	<table class="table table-bordered text-center">
        <tbody>
            <tr class="pr_image">
                <td class="row_title">Imagen del producto</td>
                <td class="row_img"><img style="max-width: 416px;max-height: 499px;" src="../public/img/productos/<?=$imagen?>" alt="compare-img"></td>
                <?php
                if ($isProd1){
                    echo '<td class="row_img"><img style="max-width: 416px;max-height: 499px;" src="../public/img/productos/'.$prod1['imagen1'].'" alt="compare-img"></td>';
                }else{
                    echo '<td class="row_img"></td>';
                }
                if ($isProd2){
                    echo '<td class="row_img"><img style="max-width: 416px;max-height: 499px;" src="../public/img/productos/'.$prod2['imagen1'].'" alt="compare-img"></td>';
                }else{
                    echo '<td class="row_img"></td>';
                }
                ?>

            </tr>
            <tr class="pr_title">
                <td class="row_title">Nombre del producto</td>
                <td class="product_name"><a href="shop-product-detail.php?prod=<?=$prod?>"><?=$dataProd['nombre']?></a></td>
                <?php
                if ($isProd1){
                    echo '<td class="product_name"><a href="shop-product-detail.php?prod='.$prod1['prod_id'].'">'.$prod1['nombre'].'</a></td>';
                }else{
                    echo '<td class="product_name"><a href="#"></a></td>';
                }
                if ($isProd2){
                    echo '<td class="product_name"><a href="shop-product-detail.php?prod='.$prod2['prod_id'].'">'.$prod2['nombre'].'</a></td>';
                }else{
                    echo '<td class="product_name"><a href="#"></a></td>';
                }
                ?>
            </tr>
            <tr class="pr_price">
                <td class="row_title">Precio</td>
                <td class="product_price"><span class="price">$<?=$precio?></span></td>
                <?php
                if ($isProd1){
                    $precioPRO = $prod1['precio'];
                    $precioPRO =number_format($precioPRO, 2, '.', ',');
                    echo ' <td class="product_price"><span class="price">$'.$precioPRO.'</span></td>';
                }else{
                    echo '<td class="product_price"></td>';
                }
                if ($isProd2){
                    $precioPRO = $prod2['precio'];
                    $precioPRO =number_format($precioPRO, 2, '.', ',');
                    echo ' <td class="product_price"><span class="price">$'.$precioPRO.'</span></td>';
                }else{
                    echo '<td class="product_price"></td>';
                }
                ?>

            </tr>

            <tr class="pr_add_to_cart">
                <td class="row_title">Informacion</td>
                <td class="row_btn"><a href="shop-product-detail.php?prod=<?=$prod?>" class="btn btn-fill-out"> Ver Producto</a></td>
                <?php
                if ($isProd1){
                    echo '<td class="row_btn"><a  href="shop-product-detail.php?prod='.$prod1['prod_id'].'" class="btn btn-fill-out"> Ver Producto</a></td>';
                }else{
                    echo '<td class="row_btn"> </td>';
                }
                if ($isProd2){
                    echo '<td class="row_btn"><a  href="shop-product-detail.php?prod='.$prod2['prod_id'].'" class="btn btn-fill-out"> Ver Producto</a></td>';
                }else{
                    echo '<td class="row_btn"> </td>';
                }
                ?>
            </tr>
            <tr class="description">
                <td class="row_title">Descripción</td>
                <td style="max-height: 165px; overflow: hidden;text-overflow: ellipsis;" class="row_text"><div style="max-width: 350px;max-height: 165px; overflow: hidden;text-overflow: ellipsis;"><p><?=$dataProd['descripcion']?></p></div></td>
                <?php
                if ($isProd1){
                    echo '<td  class="row_text"> <div style="max-width: 350px;max-height: 165px; overflow: hidden;text-overflow: ellipsis;"><p>'.$prod1['descripcion'].'</p></div></td>';
                }else{
                    echo '<td class="row_text"> </td>';
                }
                if ($isProd2){
                    echo '<td  class="row_text">  <div style="max-width: 350px;max-height: 165px; overflow: hidden;text-overflow: ellipsis;"><p>'.$prod2['descripcion'].'</p></div></td>';
                }else{
                    echo '<td class="row_text"> </td>';
                }
                ?>
            </tr>

            <tr class="pr_stock">
                <td class="row_title">Disponibilidad del Producto</td>
                <td class="row_stock"><?=$stock_html?></td>
                <?php
                if ($isProd1){
                    $stock_html =  $prod1['stock']>0?'<span class="in-stock">En Stock</span>':'<span class="out-stock">Sin Stock</span>';
                    echo '<td class="row_stock">'.$stock_html.'</td>';
                }else{
                    echo '<td class="row_stock"> </td>';
                }
                if ($isProd2){
                    $stock_html =  $prod2['stock']>0?'<span class="in-stock">En Stock</span>':'<span class="out-stock">Sin Stock</span>';
                    echo '<td class="row_stock">'.$stock_html.'</td>';
                }else{
                    echo '<td class="row_stock"> </td>';
                }
                ?>
            </tr>
            <tr class="pr_weight">
                <td class="row_title">Contenido</td>
                <td class="row_weight"><?=$dataProd['content1']?><br><?=$dataProd['content2']?><br><?=$dataProd['content3']?></td>
                <?php
                if ($isProd1){
                    echo '<td class="row_weight">'.$prod1['content1'].'<br>'.$prod1['content2'].'<br>'.$prod1['content3'].'</td>';
                }else{
                    echo '<td class="row_weight"></td>';
                }
                if ($isProd2){
                    echo '<td class="row_weight">'.$prod2['content1'].'<br>'.$prod2['content2'].'<br>'.$prod2['content3'].'</td>';
                }else{
                    echo '<td class="row_weight"></td>';
                }
                ?>
            </tr>
        </tbody>
	</table>
    </div>
</div>

<script src="../public/assets/js/scripts.js"></script>
