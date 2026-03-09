<style>
    @media (max-width: 576px) {

        /* Estilos para m�vil */
        ifmobile {
            display: block;
        }
    }

    @media (min-width: 577px) {
        .ifmobile {
            display: none;
        }
    }
</style>

<div class="middle-header dark_skin" style="background-color: #c7161d;">
    <div class="custom-container">
        <div class="nav_block">
            <a class="navbar-brand" href="index.php">
                <img class="logo_light" src="../public/images/cym.png" alt="logo" />
                <img class="logo_dark" src="../public/images/cym.png" alt="logo" />
            </a>
            <?php
            if ($body_class == 'desktop') { ?>
                <div class="product_search_fcymounded_input nomobile" style="width: 50%;">
                    <form action="shop-list-prod.php" method="GET">
                        <div class="search-container">
                            <input class="rounded-left-input" name="search" placeholder="Buscar producto " required=""
                                type="text">
                            <button type="submit" class="search-btn"><i class="fa fa-search"></i></button>
                        </div>

                    </form>
                </div>
            <?php } ?>
            <ul class="navbar-nav attr-nav align-items-center">
                <li><a href="#" class="nav-link" style="color:#ece6a3;"><i class="linearicons-user"></i></a></li>
                <?php

                if ($isSesionUser) {
                    if ($perfilUser != 'usuario') {
                        if ($body_class == 'desktop') {
                            if ($perfilUser == 'vendedor') {
                                echo '<li><a style="color:#232323" href="../admin/pedidos.php"> <span>Administrar</span></a></li>';
                            }
                            if ($perfilUser == 'usuarios digital') {
                                echo '<li><a style="color:#232323" href="../admin/usuarios_digitales_cotizaciones.php"> <span>Administrar</span></a></li>';
                            } else {
                                echo '<li><a style="color:#232323" href="../admin/"> <span>Administrar</span></a></li>';
                            }
                            echo '<li><a href="../auth/logout.php" class="nav-link" style="color:#232323;"> Cerrar Sesi&oacute;n</a></li>';
                        } else {
                            if ($perfilUser == 'vendedor') {
                                echo '<li>
                                        <a style="padding-bottom: 5px;" href="../admin/pedidos.php" class="nav-link" style="color:#232323;"> Administrar</a>
                                        <a style="padding-top: 5px;" href="../auth/logout.php" class="nav-link" style="color:#232323;"> Cerrar Sesi&oacute;n</a>
                                    </li>';
                            } else {
                                echo '<li>
                                        <a style="padding-bottom: 5px;" href="../admin/" class="nav-link" style="color:#232323;"> Administrar</a>
                                        <a style="padding-top: 5px;" href="../auth/logout.php" class="nav-link" style="color:#232323;"> Cerrar Sesi&oacute;n</a>
                                    </li>';
                            }
                        }
                    } else {
                        if ($body_class == 'desktop') {
                            echo '<li><a href="./my-account.php"><span>Mi Cuenta</span></a></li>';
                            echo '<li><a href="../auth/logout.php" class="nav-link" style="color:#232323;"> Cerrar Sesi&oacute;n</a></li>';
                        } else {
                            echo '<li>
                                    <a style="padding-bottom: 5px; color:#232323;" href="./my-account.php"><span>Mi Cuenta</span></a>
                                    <a style="padding-top: 5px; color:#232323;" href="../auth/logout.php" class="nav-link" > Cerrar Sesi&oacute;n</a>
                                    </li>';
                        }
                    }
                } else {
                    echo '<li><a href="./login.php" class="nav-link nomobile" style="color:#ece6a3;"> Iniciar Sesi&oacute;n</a></li>';
                }
                ?>
                <li class="dropdown cart_dropdown" id="content-carrito"><a class="nav-link cart_trigger" href="#"
                        data-toggle="dropdown"><i class="linearicons-bag2" style="color:#ece6a3;"></i><span
                            v-if="listaCarrito.length>0" class="cart_count">{{listaCarrito.length}}</span><span
                            class="amount" style="color:#ece6a3;"><span class="currency_symbol"
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
                                    class="btn btn-fill-line view-cart">Ver
                                    carrito</a><a href="checkout.php" class="btn btn-fill-line view-cart">Pagar</a></p>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
<?php ///if ($body_class != '') { ?>
<!--
    <p style="    margin-bottom: 3px;
    text-align: center;
    font-family: movilfontlema;
    font-weight: bold;
    color: black;
    font-size: 31px;">"Superiores en Hardware"</p>
    -->
<div class="product_search_fcymounded_input ifmobile" style="padding: 5px 5px 7px;">
    <form action="shop-list-prod.php" method="GET">
        <div class="input-group">
            <input class="form-control rounded-left-input" name="search" placeholder="Buscar producto..." required=""
                style="" type="text">
            <button type="submit" class="search-btn" style="right: 1px;top: -1px;"><i class="fa fa-search"></i>
            </button>
        </div>
    </form>
</div>
<?php
//}
?>