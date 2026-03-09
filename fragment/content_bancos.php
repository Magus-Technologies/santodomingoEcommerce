<!-- START SECTION SHOP -->
<div class="section pt-5 pb-50">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class=" text-center">
                    <div class="heading_s2">
                        <h4 style="text-transform: uppercase;">VIÑA SANTO DOMINGO <span
                                style="text-transform: lowercase;">posee cuentas bancarias en los entidades mas
                                importantes del pa&iacute;s.</p>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
        <?php foreach ($RdeliveryP as $nuevoPop) { ?>

            <div class="row mt-2">
                <div class="col-md-12">
                    <div class="item">
                        <div class="deal_wrap">

                            <div class="deal_content" style="background-color:#c7161d;">
                                <h3 style="color:#fff; text-align:center;">&nbsp; Banco <?= $nuevoPop['det_banco']; ?>: </h3>
                                <ul style="color:#fff; margin:5px 5px 5px 100px; font-size: 20px;">
                                    <?php if ($nuevoPop['det_soles'] != '') { ?>
                                        <li>Soles: <?= $nuevoPop['det_soles'] ?></li>
                                    <?php } ?>
                                    <?php if ($nuevoPop['det_dolares'] != '') { ?>

                                        <li>Dolares: <?= $nuevoPop['det_dolares'] ?></li>
                                    <?php } ?>
                                </ul>



                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <div class="row mt-2">
            <div class="col-md-12">
                <div class="item">
                    <div class="deal_wrap">
                        <div class="deal_content" style="background-color:#1c15f7;">

                            <ul style="color:#fff; margin:5px 5px 5px 100px; font-size: 20px;">
                                <li>Nota: <span style="">Se recomienda verificar que su pago salga a nombre de </span>
                                    VIÑASANTODOMINGO</li>

                            </ul>


                        </div>
                    </div>
                </div>
            </div>
        </div>




    </div>
</div>
<!-- END SECTION SHOP -->
