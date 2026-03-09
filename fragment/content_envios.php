<!-- START SECTION SHOP -->
<div class="section pt-5 pb-50">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="heading_tab_header">
                    <div class="heading_s2">
                        <h4>PASOS PARA REALIZAR ENVIOS</h4>
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

                                <h4 style="color:#fff; margin:5px 1px 1px 50px;">&nbsp; PASO #<?= $nuevoPop['num_paso']; ?>:
                                    <?= $nuevoPop['detalle_paso']; ?></h4>


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
                                <li>Hacemos envios diarios a todos los departamentos de PERU.</li>
                                <li>Horarios de envios de lunes a sabado, los domingos y feriados no laboramos</li>
                            </ul>


                        </div>
                    </div>
                </div>
            </div>
        </div>






    </div>
</div>
<!-- END SECTION SHOP -->