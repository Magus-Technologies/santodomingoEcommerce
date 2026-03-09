<?php
require  "../dao/ProductoDao.php";

$productoDao = new ProductoDao();
$conexion = (new Conexion())->getConexion();
$prod =   $_GET['prod'];

$productoDao->setProdId($prod);

$data  = $productoDao->getData();
$precio = number_format($data['precio'], 2, '.', ',');

$dataExtraBann='';


$sql ="SELECT
                                          id_ofer,
                                          producto_id,
                                          precio_oferta,
                                          cantidad,
                                          cantidad_stock,
                                          fecha_termino
                                        FROM ofertas_productos WHERE producto_id = ".$prod;
if ($rowPRodBan = $conexion->query($sql)->fetch_assoc()){


    $dataExtraBann = '<span class="price">$'.number_format($rowPRodBan['precio_oferta'], 2, '.', ',').'</span>
                            <del>$'.$precio.'</del>';
}else{
    $dataExtraBann = '<span class="price">$'.$precio.'</span>';
}


?>
<div class="ajax_quick_view">
    <input type="hidden" id="stockprodc" value="<?=$_GET['stok']?>" >
    <input type="hidden" id="codrodc" value="<?=$prod?>" >
	<div class="row">
        <div class="col-lg-6 col-md-6 mb-4 mb-md-0">
            <div class="product-image">
                <?php

                if (count($data['imagenes'])>0){

                    $img = $data['imagenes'][0];

                    ?>

                    <div class="product_img_box">
                        <input id="image_pro" value="<?=$img['imagen_url']?>" type="hidden">
                        <img id="product_img" src='../public/img/productos/<?=$img['imagen_url']?>' data-zoom-image='../public/img/productos/<?=$img['imagen_url']?>' alt="<?=$img['imagen_url']?>" />
                        <a href="#" class="product_img_zoom" title="Zoom">
                            <span class="linearicons-zoom-in"></span>
                        </a>
                    </div>

                    <div id="pr_item_gallery" class="product_gallery_item slick_slider" data-slides-to-show="4" data-slides-to-scroll="1" data-infinite="false">

                        <?php
                        $contadorImg =1;
                        foreach ($data['imagenes'] as $ima){
                            if ($contadorImg==1){ ?>
                                <div class="item">
                                    <a href="#" class="product_gallery_item active" data-image='../public/img/productos/<?=$ima['imagen_url']?>' data-zoom-image='../public/img/productos/<?=$ima['imagen_url']?>'>
                                        <img src='../public/img/productos/<?=$ima['imagen_url']?>' alt="<?=$img['imagen_url']?>" />
                                    </a>
                                </div>
                            <?php   }else{?>
                                <div class="item">
                                    <a href="#" class="product_gallery_item" data-image='../public/img/productos/<?=$ima['imagen_url']?>' data-zoom-image='../public/img/productos/<?=$ima['imagen_url']?>'>
                                        <img src='../public/img/productos/<?=$ima['imagen_url']?>' alt="<?=$img['imagen_url']?>" />
                                    </a>
                                </div>
                            <?php    }

                            $contadorImg++;
                        }
                        ?>



                    </div>



                    <?php


                }
                ?>

            </div>
        </div>
        <div class="col-lg-6 col-md-6">
            <div class="pr_detail">
                <div class="product_description">
                    <h4 class="product_title"><a href="shop-product-detail.php?prod=<?=$prod?>"><?=$data['nombre']?></a></h4>
                    <div class="product_price">
                        <?=$dataExtraBann?>
                        <div class="on_sale">
                            <span>Impuestos Incluidos</span>
                        </div>
                    </div>
                    <div class="rating_wrap">
                            <div class="rating">
                                <div class="product_rate" style="width:80%"></div>
                            </div>
                            <span class="rating_num">(21)</span>
                        </div>
                    <div class="pr_desc" style="overflow: hidden; max-height: 150px; width: 100%">
                        <?=$data['descripcion']?>
                    </div>
                    <div class="product_sort_info">
                        <ul>
                            <li><i class="linearicons-shield-check"></i> 1 Año de Garantía</li>
                            <li><i class="linearicons-sync"></i>Preguntar por Delivery</li>
                            <li><i class="linearicons-bag-dollar"></i>Compra en Linea o Tienda (Efectivo o Tarjeta de Credito)</li>
                        </ul>
                    </div>


                </div>
                <hr />
                <div class="cart_extra">
                    <div class="cart-product-quantity">
                        <div class="quantity">
                            <input type="button" value="-" class="minus">
                            <input type="text" name="quantity" value="1" title="Qty" class="qty" size="4">
                            <input type="button" value="+" class="plus">
                        </div>
                    </div>
                    <div class="cart_btn">
                        <button onclick="CARRITO.espe_prod_carr(<?= $prod ?>);$('.mfp-close').click()"  <?=$_GET['stok']<=3?'disabled':''?> class="btn btn-fill-out btn-addtocart" type="button"><i class="icon-basket-loaded"></i> Añadir al carrito</button>

                    </div>
                </div>
                <hr />
                <ul class="product-meta">
                    <li> <strong>Stock: <a href="javascript:void(0)"><?php
                                if ($_GET['stok']==0){
                                    echo "Sin Stock";
                                }elseif($_GET['stok']>10){
                                    echo "+ de 10 en Stock";
                                }else{
                                    echo  number_format($_GET['stok'], 0, '.', ',') . " en Stock";
                                }
                                ?></a></strong></li>
                    <li>Categoria: <a href="javascript:void(0)"><?=$data['categoria']?></a></li>
                    <li>Marca: <a href="javascript:void(0)" rel="tag"><?=$data['marca']?></a></li>
                </ul>
                

            </div>
        </div>
    </div>
</div>

<script src="../public/assets/js/scripts.js?v=2"></script>
<script>

</script>