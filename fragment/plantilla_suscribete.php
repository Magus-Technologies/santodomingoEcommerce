<!-- START SECTION SUBSCRIBE NEWSLETTER -->
<div class="section bg_default small_pt small_pb" style="background-color:#880107 !important;">
    <img class="d-none d-lg-block" src="../public/images/wine.png" alt="bg_newsletter" style="position: absolute;
  width: 276px;
  top: -110px;
  left: 25px;">
    <div class="custom-container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="newsletter_text text_white">
                    <h3>Somos VIÑASANTODOMINGO los mejores en VINOS Y PISCO</h3>
                    <p>Recibe las mejores Ofertas en Vino y Pisco SUSCRÍBETE</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="newsletter_form2 rounded_input">
                    <form id="formPromociones">
                        <input type="email" required="" name="emailRegistrar" id="emailRegistrar" class="form-control"
                            placeholder="Ingresa tu Email">
                        <button type="button" class="btn btn-dark btn-radius"
                            style="background-color:#232323!important;" id="btnRegistrar">Suscríbete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- START SECTION SUBSCRIBE NEWSLETTER -->

<script>
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
</script>
