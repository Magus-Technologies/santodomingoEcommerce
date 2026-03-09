<footer class="footer_dark">
    <div class="footer_top small_pt pb_20">
        <div class="custom-container">
            <div class="row">
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <div class="widget">
                        <div class="footer_logo">
                            <a href="./"><img src="../public/logo.svg" alt="logo" style="width: 280px;" /></a>
                        </div>
                        <p class="mb-3">Los mejores en HARDWARE para Gaming, Dise&ntilde;o e Ingenier&iacute;a</p>
                        <ul class="contact_info">
                            <li>
                                <i class="ti-location-pin"></i>
                                <p><?= $dataConf['direccion'] ?></p>
                            </li>
                            <li>
                                <i class="ti-email"></i>
                                <a href="<?= $dataConf['email'] ?>"><?= $dataConf['email'] ?></a>
                            </li>
                            <?php
                            foreach ($dataConf['telefonos'] as $telf) {
                                echo '<li>
                                <i class="ti-mobile"></i>
                                <p>' . $telf['numero'] . '</p>
                            </li>';
                            }
                            ?>

                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <div class="widget">
                        <h6 class="widget_title">Empresa</h6>
                        <ul class="widget_links">
                            <li><a href="about.php">Nosotros</a></li>
                            <li><a href="contact.php">Contactanos</a></li>
                            <li><a href="term.php">Terminos y Condiciones</a></li>
                            <li>
                                <a href="../public/librorec/libro.php" target="_blank">
                                    <img src="../public/librorec/libro2.png" style="filter: brightness(0) invert();"
                                        alt="libro reclamaciones"></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <div class="widget">
                        <h6 class="widget_title">Productos</h6>
                        <ul class="widget_links">
                            <li><a href="./shop-list-ctg.php?ctg=005">Vino Tinto</a></li>
                            <li><a href="./shop-list-ctg.php?ctg=001">Vino Blanco</a></li>
                            <li><a href="./shop-list-ctg.php?ctg=010">Vino Rosado</a></li>
                            <li><a href="./shop-list-ctg.php?ctg=002">Espumante</a></li>
                            <li><a href="./shop-list-ctg.php?ctg=012-014">Pisco</a></li>
                         
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="widget">

                        <img src="https://i0.wp.com/placeres.pe/wp-content/uploads/2025/01/vino.jpg?fit=1200%2C800&ssl=1"
                            class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="middle_footer">
        <div class="custom-container">
            <div class="row">
                <div class="col-12">
                    <div class="shopping_info">
                        <div class="row justify-content-center">
                            <div class="col-md-4">
                                <div class="icon_box icon_box_style2">
                                    <div class="icon">
                                        <i class="flaticon-shipped"></i>
                                    </div>
                                    <div class="icon_box_content">
                                        <h5>Contamos con Delivery.</h5>
                                        <p>Consultar al Whatsapp 930 570 018</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="icon_box icon_box_style2">
                                    <div class="icon">
                                        <i class="flaticon-money-back"></i>
                                    </div>
                                    <div class="icon_box_content">
                                        <h5>Contamos con super descuentos y promociones.</h5>
                                        <p>Siempre Conserve su Boleta o Factura de Compra</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="icon_box icon_box_style2">
                                    <div class="icon">
                                        <i class="flaticon-support"></i>
                                    </div>
                                    <div class="icon_box_content">
                                        <h5>Contamos con Soporte T&eacute;cnico</h5>
                                        <p>Especialistas en hardware y mantenimiento</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom_footer border-top-tran">
        <div class="custom-container">
            <div class="row">
                <div class="col-lg-4">
                    <p class="mb-lg-0 text-center">&copy; <?= date('Y') ?> Todos los derechos reservados por <a
                            target="_blank" href="https://magustechnologies.com/"><strong>MAGUS
                                TECHNOLOGIES</strong></a> </p>
                </div>
                <div class="col-lg-4 order-lg-first">
                    <div class="widget mb-lg-0">
                        <ul class="social_icons text-center text-lg-left">

                            <li><a href="<?= $dataConf['redessociales']['facebook'] ?>" class="sc_facebook"><i
                                        class="ion-social-facebook"></i></a></li>
                            <li><a href="<?= $dataConf['redessociales']['twitter'] ?>" class="sc_twitter"><i
                                        class="ion-social-twitter"></i></a></li>
                            <li><a href="<?= $dataConf['redessociales']['google_plus'] ?>" class="sc_google"><i
                                        class="ion-social-googleplus"></i></a></li>
                            <li><a href="<?= $dataConf['redessociales']['youtube'] ?>" class="sc_youtube"><i
                                        class="ion-social-youtube-outline"></i></a></li>
                            <li><a href="<?= $dataConf['redessociales']['instagram'] ?>" class="sc_instagram"><i
                                        class="ion-social-instagram-outline"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4">
                    <ul class="footer_payment text-center text-lg-right">
                        <li><a href="#"><img src="../public/assets/images/visa.png" alt="visa"></a></li>
                        <li><a href="#"><img src="../public/assets/images/discover.png" alt="discover"></a></li>
                        <li><a href="#"><img src="../public/assets/images/master_card.png" alt="master_card"></a>
                        </li>
                        <!--li><a href="#"><img src="../public/assets/images/paypal.png" alt="paypal"></a></li>
                        <li><a href="#"><img src="../public/assets/images/amarican_express.png" alt="amarican_express"></a></li-->
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
<style>
    .contenedor_telegram {
        width: 275px;
        height: 380px;
        background-color: #ffffff;
        padding-top: 7px;
        position: fixed;
        bottom: 83px;
        right: 307px;
        color: #FFF;
        border-radius: 5px;
        z-index: 100;
        border: 1px solid #264ecc;
        overflow: hidden;
        -webkit-box-shadow: 12px 13px 16px -8px rgba(0, 0, 0, 0.75);
        -moz-box-shadow: 12px 13px 16px -8px rgba(0, 0, 0, 0.75);
        box-shadow: 12px 13px 16px -8px rgba(0, 0, 0, 0.75);
    }

    .contenedor_wapsa {
        width: 275px;
        height: 380px;
        background-color: #ffffff;
        padding-top: 7px;
        position: fixed;
        bottom: 83px;
        right: 82px;
        color: #FFF;
        border-radius: 5px;
        z-index: 100;
        border: 1px solid green;
        overflow: hidden;
        -webkit-box-shadow: 12px 13px 16px -8px rgba(0, 0, 0, 0.75);
        -moz-box-shadow: 12px 13px 16px -8px rgba(0, 0, 0, 0.75);
        box-shadow: 12px 13px 16px -8px rgba(0, 0, 0, 0.75);
    }

    .apertura_what {
        animation-name: animacion_whapBox;
        animation-duration: 0.7s;
    }

    @keyframes animacion_whapBox {
        0% {
            width: 0px;
            height: 0px;
        }

        100% {
            width: 275px;
            height: 380px;
        }
    }

    .contenedor_inferior {
        padding: 15px;
        margin: 10px;
        background-color: #f3f3f3;
        height: 292px;
        border-radius: 5px;
        overflow: auto;
    }

    .float:hover {
        cursor: pointer;
    }

    .btn-icon2 {
        padding: 10px;
        background-color: #c7161d;
        color: white;
        border-radius: 50%;
    }

    .btn-icon {
        padding: 10px;
        background-color: #1bc159;
        color: white;
        border-radius: 50%;
    }

    .float2 {
        padding-top: 7px;
        position: fixed;
        width: 60px;
        height: 60px;
        bottom: 40px;
        right: 172px;
        background-color: #c7161d;
        color: #FFF;
        border-radius: 50px;
        text-align: center;
        font-size: 30px;
        box-shadow: 2px 2px 3px #999;
        z-index: 100;
    }

    .float3 {
        padding-top: 7px;
        position: fixed;
        width: 60px;
        height: 60px;
        bottom: 40px;
        right: 268px;
        background-color: #c7161d;
        color: #FFF;
        border-radius: 50px;
        text-align: center;
        font-size: 30px;
        box-shadow: 2px 2px 3px #999;
        z-index: 100;
    }

    .contenedor_telegramM {
        width: 275px;
        height: 380px;
        background-color: #ffffff;
        padding-top: 7px;
        position: fixed;
        bottom: 156px;
        right: 93px;
        color: #FFF;
        border-radius: 5px;
        z-index: 100;
        border: 1px solid #264ecc;
        overflow: hidden;
        -webkit-box-shadow: 12px 13px 16px -8px rgba(0, 0, 0, 0.75);
        -moz-box-shadow: 12px 13px 16px -8px rgba(0, 0, 0, 0.75);
        box-shadow: 12px 13px 16px -8px rgba(0, 0, 0, 0.75);
    }

    .floatm {
        padding-top: 7px;
        position: fixed;
        width: 60px;
        height: 60px;
        bottom: 40px;
        right: 70px;
        background-color: #25d366;
        color: #FFF;
        border-radius: 50px;
        text-align: center;
        font-size: 30px;
        box-shadow: 2px 2px 3px #999;
        z-index: 100;
    }

    .float2m {
        padding-top: 7px;
        position: fixed;
        width: 60px;
        height: 60px;
        bottom: 130px;
        right: 70px;
        background-color: #c7161d;
        color: #FFF;
        border-radius: 50px;
        text-align: center;
        font-size: 30px;
        box-shadow: 2px 2px 3px #999;
        z-index: 100;
    }

    .float3m {
        padding-top: 7px;
        position: fixed;
        width: 60px;
        height: 60px;
        bottom: 218px;
        right: 70px;
        background-color: #c7161d;
        color: #FFF;
        border-radius: 50px;
        text-align: center;
        font-size: 30px;
        box-shadow: 2px 2px 3px #999;
        z-index: 100;
    }
</style>

<a href="https://m.me/<?= $dataConf['redessociales']['id_facebook'] ?>" id="botn_facebook"
    class="<?= $body_class == 'desktop' ? 'float2' : 'float2m' ?>" target="_blank">
    <img style="max-width: 37px;" src="../public/facebook-messenger-brands.svg" class="my-float"></img>
</a>
<span href=" " id="botn_telegram" class="<?= $body_class == 'desktop' ? 'float3' : 'float3m' ?>" target="_blank">
    <img style="max-width: 37px;" src="../public/telegram_ico.png" class="my-float"></img>
</span>

<div style="display: none"
    class="<?= $body_class == 'desktop' ? 'contenedor_telegram' : 'contenedor_telegramM' ?> apertura_what">
    <div style="width: 100%;text-align: center">
        <h4 style="color: #009237">¿Con quien quieres hablar?</h4>
    </div>
    <div class="contenedor_inferior" style="">
        <?php

        $dia = date('w');
        $hora = date('g');
        $modo = date('A');
        //echo  $dia . "<>".$hora.'<>'.$modo;
        foreach ($dataConf['redessociales']['whatsapp'] as $whats) {
            if ($whats['estado']) {
                if (isset($whats['dia1']) && isset($whats['dia2']) && isset($whats['hora2']) && isset($whats['hora1']) && isset($whats['hora2']) && isset($whats['hora1'])) {
                    $val1 = $whats['dia1'] <= $dia || $whats['dia2'] >= $dia;
                    $val2 = false;

                    if ($whats['modo1'] == "AM" && $whats['modo2'] == "PM") {
                        // echo "modo1<br>";
                        if ($modo == $whats['modo1']) {
                            $val2 = $whats['hora1'] <= $hora;
                        } elseif ($modo == $whats['modo2']) {
                            $val2 = $whats['hora2'] > $hora;
                        }
                    } elseif ($whats['modo1'] == "PM" && $whats['modo2'] == "AM") {
                        if ($modo == $whats['modo1']) {
                            $val2 = $whats['hora1'] <= $hora;
                        } elseif ($modo == $whats['modo2']) {
                            $val2 = $whats['hora2'] > $hora;
                        }
                    }

                    if ($hora . ':' . $modo == '12:PM') {
                        $val2 = !$val2;
                    } elseif ($hora . ':' . $modo == '12:AM') {
                        $val2 = !$val2;
                    }

                    //echo ($val1?'a':'b')."<>". ($val2?'a':'b');
        

                    if ($val1 && $val2) {

                        echo '<div style="width: 100%;height: 50px;margin-bottom: 3px;">
                        <a target="_blank" href="https://t.me/' . str_replace(' ', '', $whats['nombre']) . '">
                            <i class="btn-icon2 " style="float: left; margin-right: 5px;" >  </i>
                            <div style="float: left">
                                 <strong>' . $whats['nombre'] . '</strong> 
                            </div>
                        </a>
                    </div>';
                    }
                } else {
                    echo '<div style="width: 100%;height: 50px;margin-bottom: 3px;">
            <a target="_blank" href="https://t.me/' . str_replace(' ', '', $whats['nombre']) . '">
                <i  class="btn-icon2 " style="float: left; margin-right: 5px;"> </i> 
                <div style="float: left">
                     <strong>' . $whats['nombre'] . '</strong><br>' . $whats['numero'] . '
                </div>
            </a>
        </div>';
                }
            }
        }
        ?>

    </div>
</div>

<div style="display: none" class="contenedor_wapsa apertura_what">
    <div style="width: 100%;text-align: center">
        <h4 style="color: #009237">¿Con quien quieres hablar?</h4>
    </div>
    <div class="contenedor_inferior" style="">
        <?php

        $dia = date('w');
        $hora = date('g');
        $modo = date('A');
        //echo  $dia . "<>".$hora.'<>'.$modo;
        foreach ($dataConf['redessociales']['whatsapp'] as $whats) {
            if ($whats['estado']) {
                if (isset($whats['dia1']) && isset($whats['dia2']) && isset($whats['hora2']) && isset($whats['hora1']) && isset($whats['hora2']) && isset($whats['hora1'])) {
                    $val1 = $whats['dia1'] <= $dia || $whats['dia2'] >= $dia;
                    $val2 = false;

                    if ($whats['modo1'] == "AM" && $whats['modo2'] == "PM") {
                        // echo "modo1<br>";
                        if ($modo == $whats['modo1']) {
                            $val2 = $whats['hora1'] <= $hora;
                        } elseif ($modo == $whats['modo2']) {
                            $val2 = $whats['hora2'] > $hora;
                        }
                    } elseif ($whats['modo1'] == "PM" && $whats['modo2'] == "AM") {
                        if ($modo == $whats['modo1']) {
                            $val2 = $whats['hora1'] <= $hora;
                        } elseif ($modo == $whats['modo2']) {
                            $val2 = $whats['hora2'] > $hora;
                        }
                    }

                    if ($hora . ':' . $modo == '12:PM') {
                        $val2 = !$val2;
                    } elseif ($hora . ':' . $modo == '12:AM') {
                        $val2 = !$val2;
                    }

                    //echo ($val1?'a':'b')."<>". ($val2?'a':'b');
        

                    if ($val1 && $val2) {

                        echo '<div style="width: 100%;height: 50px;margin-bottom: 3px;">
                        <a target="_blank" href="https://api.whatsapp.com/send?phone=' . $whats['numero'] . '&text=' . $whats['mensaje'] . '">
                            <i  class="btn-icon fa fa-whatsapp" style="float: left; margin-right: 5px;"> </i> 
                            <div style="float: left">
                                 <strong>' . $whats['nombre'] . '</strong><br>' . $whats['numero'] . '
                            </div>
                        </a>
                    </div>';
                    }
                } else {
                    echo '<div style="width: 100%;height: 50px;margin-bottom: 3px;">
            <a target="_blank" href="https://api.whatsapp.com/send?phone=' . $whats['numero'] . '&text=' . $whats['mensaje'] . '">
                <i  class="btn-icon fa fa-whatsapp" style="float: left; margin-right: 5px;"> </i> 
                <div style="float: left">
                     <strong>' . $whats['nombre'] . '</strong><br>' . $whats['numero'] . '
                </div>
            </a>
        </div>';
                }
            }
        }
        ?>

    </div>
</div>
<span id="botn_whapsa" class="<?= $body_class == 'desktop' ? 'float' : 'floatm' ?>" target="_blank">
    <i class="fa fa-whatsapp my-float"></i>
</span>






<!-- END FOOTER -->

<a href="#" class="scrollup" style="display: none;"><i class="ion-ios-arrow-up"></i></a>

<!-- Latest jQuery -->
<script src="../public/assets/js/jquery-1.12.4.min.js"></script>
<!-- popper min js -->
<script src="../public/assets/js/popper.min.js"></script>
<!-- Latest compiled and minified Bootstrap -->
<script src="../public/assets/bootstrap/js/bootstrap.min.js"></script>
<!-- owl-carousel min js  -->
<script src="../public/assets/owlcarousel/js/owl.carousel.min.js"></script>
<!-- magnific-popup min js  -->
<script src="../public/assets/js/magnific-popup.min.js"></script>
<!-- waypoints min js  -->
<script src="../public/assets/js/waypoints.min.js"></script>
<!-- parallax js  -->
<script src="../public/assets/js/parallax.js"></script>
<!-- countdown js  -->
<script src="../public/assets/js/jquery.countdown.min.js"></script>
<!-- imagesloaded js -->
<script src="../public/assets/js/imagesloaded.pkgd.min.js"></script>
<!-- isotope min js -->
<script src="../public/assets/js/isotope.min.js"></script>
<!-- jquery.dd.min js -->
<script src="../public/assets/js/jquery.dd.min.js"></script>
<!-- slick js -->
<script src="../public/assets/js/slick.min.js"></script>
<!-- elevatezoom js -->
<script src="../public/assets/js/jquery.elevatezoom.js"></script>
<!-- scripts js -->
<script src="../public/assets/js/scripts.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="../public/js/main.js?v=9"></script>
<script src="../public/js/tools.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    var loaDataP = true
    window.onload = function () {

        $('#btnRegistrar').click(function () {
            let data = $('#formPromociones').serializeArray()
            if ($('#emailRegistrar').val() !== '') {
                $.ajax({
                    url: "../ajax/ajs_registrardos_x_promocion.php",
                    data: data,
                    type: "post",
                    success: function (resp) {
                        let data = JSON.parse(resp)
                        if (data.res) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Bien',
                                text: data.msj,
                            })

                            $.ajax({
                                type: "POST",
                                url: '../auth/promociones.php',
                                data: {
                                    email: $('#emailRegistrar').val()
                                },
                                success: function (respuesta) {
                                    $(".preloader").hide()
                                    console.log(respuesta);
                                }
                            });
                            $.ajax({
                                type: "POST",
                                url: '../auth/avisar_suscripcion.php',
                                data: {
                                    email: $('#emailRegistrar').val()
                                },
                                success: function (respuesta) {
                                    $(".preloader").hide()
                                    console.log(respuesta);
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'info',
                                title: '!!',
                                text: data.msj,
                            })
                        }
                        $('#emailRegistrar').val('')
                    }
                })
            } else {
                Swal.fire({
                    icon: 'info',
                    title: '!!',
                    text: 'Ingrese un correo valido',
                })
            }

        })

        $("#botn_telegram").hover(
            function () {
                $(".contenedor_telegramM").attr("style", "display: block")
            },
            function () {
                setTimeout(function () {
                    if (!valConst) {
                        $(".contenedor_telegramM").attr("style", "display: none")
                    }
                }, 100)

            }
        );
        $(".contenedor_telegramM").hover(
            function () {
                valConst = true;
            },
            function () {
                valConst = false;
                $(".contenedor_telegramM").attr("style", "display: none")
            }
        );
    };
</script>
