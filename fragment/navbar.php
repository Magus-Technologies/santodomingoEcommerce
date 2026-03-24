<?php
date_default_timezone_set('America/Lima');

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

$isSesionUser = isset($_SESSION['usuario']);
$perfilUser = '';

if ($isSesionUser) {
    $perfilUser = $_SESSION['perfil'];
}

require_once "../extra/TasaCambioApi.php";

$tasaCambioApi = new TasaCambioApi();
$cambio = $tasaCambioApi->getTasaCambio();
$tc = $cambio['cambio'];

$vusu = $_SESSION['usuario'] ?? null;
$vip = 'NO';

if ($vusu) {
    $sqlf = "SELECT (CASE WHEN vip_estado = '1' THEN 'SI' ELSE 'NO' END) AS vip FROM usuarios_vip WHERE use_id='$vusu'";
    $resulta = $productoDao->exeSQL($sqlf);
    foreach ($resulta as $rowpd) {
        $vip = $rowpd['vip'];
    }
}

$vip_status = empty($rowpd['vip']) ? 'NO' : ($rowpd['vip'] === 'SI' ? 'SI' : 'NO');
?>

<input type="hidden" value="<?= $tc ?>" id="tasa_cambio">
<div>
    <!-- SECCIÓN ROJA CON LOGO, BUSCADOR Y CARRITO -->
    <div class="middle-header dark_skin" style="background-color: #c7161d; padding: 20px 0;">
        <div class="container">
            <div class="row align-items-center">
                <!-- LOGO A LA IZQUIERDA -->
                <div class="col-md-2" style="display: flex; align-items: center; justify-content: flex-start;">
                    <a class="navbar-brand" href="index.php" style="margin: 0; padding: 0;">
                        <img src="../public/images/cym.png" alt="logo" style="max-width: 140px; height: auto;" />
                    </a>
                </div>

                <!-- BUSCADOR EN EL CENTRO-DERECHA (MÁS GRANDE) -->
                <div class="col-md-7" style="display: flex; justify-content: flex-start; padding: 0 15px;">
                    <div class="product_search_fcymounded_input" style="width: 100%; max-width: 100%;">
                        <form action="shop-list-prod.php" method="GET">
                            <div class="search-container">
                                <input class="rounded-left-input" name="search" placeholder="Buscar producto" required=""
                                    type="text" style="padding: 12px 15px; font-size: 14px;">
                                <button type="submit" class="search-btn" style="padding: 12px 15px;"><i class="fa fa-search"></i></button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- CARRITO A LA DERECHA -->
                <div class="col-md-3">
                    <ul class="navbar-nav attr-nav align-items-center" style="justify-content: flex-end; margin: 0;">
                        <li><a href="#" class="nav-link" style="color:#ece6a3;"><i class="linearicons-user"></i></a></li>
                        <?php
                        if ($isSesionUser) {
                            if ($perfilUser != 'usuario') {
                                if ($perfilUser == 'vendedor') {
                                    echo '<li><a style="color:#fff; font-size: 12px;" href="../admin/pedidos.php"> <span>Administrar</span></a></li>';
                                } else {
                                    echo '<li><a style="color:#fff; font-size: 12px;" href="../admin/"> <span>Administrar</span></a></li>';
                                }
                                echo '<li><a href="../auth/logout.php" class="nav-link" style="color:#fff; font-size: 12px;"> Cerrar Sesi&oacute;n</a></li>';
                            } else {
                                echo '<li><a href="./my-account.php"><span style="color:#fff; font-size: 12px;">Mi Cuenta</span></a></li>';
                                echo '<li><a href="../auth/logout.php" class="nav-link" style="color:#fff; font-size: 12px;"> Cerrar Sesi&oacute;n</a></li>';
                            }
                        } else {
                            echo '<li><a href="./login.php" class="nav-link nomobile" style="color:#fff; font-size: 12px;"> Iniciar Sesi&oacute;n</a></li>';
                        }
                        ?>
                        <li class="dropdown cart_dropdown" id="content-carrito"><a class="nav-link cart_trigger" href="#"
                                data-toggle="dropdown"><i class="linearicons-bag2" style="color:#ece6a3;"></i><span
                                    v-if="listaCarrito.length>0" class="cart_count">{{listaCarrito.length}}</span><span
                                    class="amount" style="color:#ece6a3; font-size: 12px;"><span class="currency_symbol"
                                        style="color: #ece6a3;">S/</span>{{totalCar}}</span></a>
                            <div class="cart_box cart_right dropdown-menu dropdown-menu-right">
                                <ul class="cart_list">
                                    <li v-for="(item, index) in listaCarrito">
                                        <a href="#" @click="eliminarProdCarrito(index)" class="item_remove"><i
                                                class="ion-close"></i></a>
                                        <a href="#"><img style="max-width: 80px;max-height: 80px"
                                                :src="'../public/img/productos/'+item.imagen" alt="cart_thumb1">
                                            <p style="color:#232323;">{{item.nombre_prod}}</p>
                                        </a>
                                        <span class="cart_quantity" style="color:#232323;"> {{item.cantidad}} x <span
                                                class="cart_amount" style="color:#232323;"> <span class="price_symbole"
                                                    style="color:#232323;">S/</span></span>{{item.precio}}</span>
                                    </li>
                                </ul>
                                <div class="cart_footer">
                                    <p class="cart_total" style="color:#232323;"><strong>Subtotal:</strong> <span
                                            class="cart_price"> <span class="price_symbole"
                                                style="color:#232323;">S/</span></span>{{totalCar}}</p>
                                    <p class="cart_buttons" style="color:#232323;"><a href="shop-cart.php"
                                            class="btn btn-fill-line view-cart">Ver carrito</a><a href="checkout.php"
                                            class="btn btn-fill-line view-cart">Pagar</a></p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
