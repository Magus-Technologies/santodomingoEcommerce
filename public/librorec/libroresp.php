<?php
session_start();


    if ($_SESSION['usuario'] >0) { 

    $hoy = date("Y-m-d");
    //$anual = date("Y");
    include "BD.php";
    $idlib = $_GET['id'];
    $sql0 = "SELECT * FROM libro_reclamacion WHERE lib_id='$idlib'";
    $res0 = mysqli_query($con,$sql0);
    $arr0 = mysqli_fetch_array($res0,MYSQLI_ASSOC);
    $codigorec = $arr0['lib_code'];
    $hoy = $arr0['lib_date'];
    $nombrec = $arr0['lib_cliente'];
    $domicic = $arr0['lib_domicilio'];
    $dniclie = $arr0['lib_DNI'];
    $telfcli = $arr0['lib_telecli'];
    $emailcl = $arr0['lib_emailcli'];
    $tiposer = $arr0['lib_tiposer'];
        if ($tiposer=="producto") {
            $produ = "checked=checked";
            $servi = "";
        } else {
            $produ = "";
            $servi = "checked=checked";
        }
    $descric = $arr0['lib_serdesc'];
    $montocl = $arr0['lib_montorec'];
    $tiporec = $arr0['lib_tiporec'];
    if ($tiporec=="reclamo") {
        $recla = "checked=checked";
        $queja = "";
    } else {
        $recla = "";
        $queja = "checked=checked";
    }
    $detallc = $arr0['lib_detalle'];
    $pedidoc = $arr0['lib_pedido'];
    $fecres = $arr0['lib_fecres'];
    if ($fecres !='0000-00-00') {
        $fecresc = $fecres;
    } else {
        $fecresc = $hoy;
    }
    $resplib = $arr0['lib_respuesta'];
    $menorc = $arr0['lib_menor'];
    if ($menorc =='1') {
        $mecli = "checked=checked";
    } else {
        $mecli = "";
    }
    $apoder = $arr0['lib_apoderado'];
    $dpoder = $arr0['lib_domiapo'];
    $dnpode = $arr0['lib_DNIapo'];
    $tpoder = $arr0['lib_teleapo'];
    $epoder = $arr0['lib_emailapo'];

   $uidb = $_SESSION['usuario'];
   $filbutton = "SELECT (CASE WHEN perfil = 'admin' THEN '1' ELSE 0 END) AS filper FROM usuarios WHERE use_id='$uidb'";	
   $resfill = mysqli_query($con,$filbutton);
   $arrfill = mysqli_fetch_array($resfill,MYSQLI_ASSOC);
   $utipo = $arrfill['filper'];



    
?>
<html>
<head>
    <title>ACEADVANCE - Libro de Reclamaciones Virtual</title>
    <link type="text/css" media="all" href="bootstrap_libro.css" rel="stylesheet">
    <link type="text/css" media="all" href="custom_lib.css" rel="stylesheet">
    <link type="text/css" media="all" href="print_lib.css" rel="stylesheet">
    
</head>

<script type="text/javascript" src="jquery-1.12.3.min.js"></script>
<body>
<div class="container" style="margin-top: 10px; margin-bottom: 20px">
    <div class="row">
        <div class="col-md-12 text-center" style="margin-bottom: 20px">
            <h3>Ace Advance Group S.a.C. RUC N°: 20613235168</h3>
        </div>
                    

            <div class="col-md-12" style="border: 2px solid black">
                <form id="asForm" class="form-horizontal">
                    <input type="hidden" id="idre" value="<?=$idlib;?>">
                <div class="form-group form-libro">
                    <div class="col-md-8" style="background-color: #bebebe; border: 1px solid #bebebe;">
                       <h4 class="text-center">LIBRO DE RECLAMACIONES </h4> 
                    </div>
                    <div class="col-md-4" style="border: 1px solid #bebebe;">
                       <h4 class="text-center">HOJA DE RECLAMACI&Oacute;N </h4> 
                    </div>
                    <div class="col-md-8" style="border: 1px solid #bebebe;">
                    <label for="fechaemi" class="col-sm-3 control-label" style="text-align: left; margin-left:-10px;">FECHA:</label>
                    <div class="col-sm-3">
                        <input type="date" id="fecharec" class="form-control input-sm" value="<?=$hoy;?>" placeholder="" disabled>
                    </div>
                    </div>
                    <div class="col-md-4" style="border: 1px solid #bebebe;">
                        <label for="numrecla" class="col-sm-2 control-label" style="text-align: left;">N°: </label>
                        <div class="col-sm-10">
                        <input type="text" class="form-control input-sm" id="numrecla" name="numrecla"
                               placeholder="" value="<?=$codigorec;?>" disabled>
                        </div>
                    </div>
                     <!--
                    -->
                    <div class="clearfix"></div><div class="clearfix"></div>


                    <label for="negocio" class="col-sm-2 control-label" style="text-align: left">NEGOCIO:</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control input-sm as_required" id="negocio" 
                        name="negocio" placeholder="" value="ACEADVANCE" disabled>
                    </div>
                    <label for="tienda" class="col-sm-2 control-label" style="text-align: left">TIENDA:</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control input-sm as_required text-uppercase" id="tienda" 
                        name="tienda" placeholder="" value="Av. Garcilazo de la Vega 1251, Tienda #123, Lima, Lima" disabled>
                    </div>
                    
                    <div class="clearfix"></div>
                    <div class="col-md-12" style="background-color: #bebebe">
                        1. IDENTIFICACIÓN DEL CONSUMIDOR RECLAMANTE
                    </div>
                    <label for="nombre" class="col-sm-2 control-label" style="text-align: left">NOMBRE:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control input-sm" id="nombre" name="nombre"
                               value="<?=$nombrec;?>" disabled>
                    </div>
                    <label for="domicilio" class="col-sm-2 control-label" style="text-align: left">DOMICILIO:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control input-sm" id="domicilio" name="domicilio"
                        value="<?=$domicic;?>" disabled>
                    </div>
                    <label for="dni" class="col-sm-2 control-label" style="text-align: left">DNI / CE:</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control input-sm number" id="dni" name="dni"
                        value="<?=$dniclie;?>" disabled>
                    </div>
                    <label for="telefono" class="col-sm-1 control-label" style="text-align: left">TELEF:</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control input-sm number" id="telefono"
                               name="telefono" value="<?=$telfcli;?>" disabled>
                    </div>
                    <label for="email" class="col-sm-1 control-label" style="text-align: left">EMAIL:</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control input-sm" id="email" name="email"
                        value="<?=$emailcl;?>" disabled>
                    </div>
                    <label for="menor" class="col-sm-2 control-label" style="text-align: left">MENOR DE EDAD:</label>
                    <div class="col-sm-10">
                    <input type="checkbox"
                               class=""
                               id="menor"
                               name="menor"
                               value="1"  <?=$mecli;?> disabled>
                        <span style="font-size: 12px;clear: both;"> <small> [LLENAR INFORMACIÓN DEL APODERADO]</small></span>
                    </div>
               
                    
                    <div class="clearfix"></div>
                    <div class="col-sm-12">
                    <label for="menor" class="col-sm-4 control-label" style="text-align: left">
                       
                        
                    </div>
                    <label for="nombre_padre" class="col-sm-2 control-label" style="text-align: left">NOMBRE:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control input-sm" id="nombre_padre" name="nombre_padre"
                        value="<?=$apoder;?>" disabled>
                    </div>
                    <label for="domicilio_padre" class="col-sm-2 control-label"
                           style="text-align: left">DOMICILIO:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control input-sm" id="domicilio_padre" name="domicilio_padre"
                        value="<?=$dpoder;?>" disabled>
                    </div>
                    <label for="dni_padre" class="col-sm-2 control-label" style="text-align: left">DNI / CE:</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control input-sm number" id="dni_padre" name="dni_padre"
                        value="<?=$dnpode;?>" disabled>
                    </div>
                    <label for="telefono_padre" class="col-sm-1 control-label" style="text-align: left">TELEF:</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control input-sm number" id="telefono_padre"
                               name="telefono_padre"
                               value="<?=$tpoder;?>" disabled>
                    </div>
                    <label for="email_padre" class="col-sm-1 control-label" style="text-align: left">EMAIL:</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control input-sm" id="email_padre" name="email_padre"
                               plvalue="<?=$epoder;?>" disabled>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-12" style="background-color: #bebebe">
                        2. IDENTIFICACIÓN DEL BIEN CONTRATADO
                    </div>
                    <label for="producto" class="col-sm-2 control-label" style="text-align: left">
                        <input type="radio" class="as_required" id="producto" name="tipo_bien" value="producto" <?=$produ;?>> PRODUCTO
                    </label>
                    <label for="monto" class="col-sm-3 control-label" style="text-align: left">MONTO RECLAMADO:</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control input-sm as_required number" id="monto" name="monto"
                        value="<?=$montocl;?>" disabled>
                    </div>
                    <div class="clearfix"></div>
                    <label for="servicio" class="col-sm-2 control-label" style="text-align: left">
                        <input type="radio" class="as_required" id="servicio" name="tipo_bien" value="servicio" <?=$servi;?>> SERVICIO
                    </label>
                    <label for="descripcion" class="col-sm-3 control-label"
                           style="text-align: left">DESCRIPCIÓN:</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control input-sm as_required" id="descripcion" name="descripcion"
                        value="<?=$descric;?>" disabled>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-8" style="background-color: #bebebe">
                        3. DETALLE DE LA RECLAMACIÓN Y PEDIDO DEL CONSUMIDOR
                    </div>
                    <label for="reclamo" class="col-sm-2 control-label" style="text-align: left">
                        <input type="radio" class="as_required" id="reclamo" name="tipo_reclamo" value="reclamo" <?=$recla;?>>
                        RECLAMO
                    </label>
                    <label for="queja" class="col-sm-2 control-label" style="text-align: left">
                        <input type="radio" class="as_required" id="queja" name="tipo_reclamo" value="queja" <?=$queja;?>> QUEJA
                    </label>

                    <div class="col-sm-12">
                        <textarea class="form-control input-sm as_required" id="detalle" name="detalle" rows="10"
                                  placeholder="DETALLE.." disabled><?=$detallc;?></textarea>
                    </div>
                    <div class="col-sm-12">
                        <textarea class="form-control input-sm as_required" id="pedido" name="pedido" rows="8"
                                  placeholder="PEDIDO.." disabled><?=$descric;?></textarea>
                    </div>
                
                    <!-- READONLY -->
                    <div class="col-md-12" style="background-color: #bebebe">
                        4. OBSERVACIONES Y ACCIONES ADOPTADAS POR EL PROVEEDOR
                    </div>
                    <label for="fecha" class="col-sm-5 control-label" style="text-align: left">FECHA DE COMUNICACIÓN DE
                        LA RESPUESTA:</label>
                    <div class="col-sm-3">
                        <input type="date" id="fecres" class="form-control input-sm" readonly
                               value="<?=$fecresc;?>">
                    </div>
                    <div class="col-sm-12">
                        <textarea class="form-control input-sm" rows="5" id="resppo"
                                  placeholder="" pattern="^[a-z0-9A-Z_ ]*$" title="Ingrese solo numeros u letras" required><?=$resplib;?></textarea>
                    </div>
                    <div class="col-sm-4 text-center" style="font-size: 12px">
                        <strong>RECLAMO:</strong> Disconformidad relacionada a los productos o servicios.
                    </div>
                    <div class="col-sm-8 text-center" style="font-size: 12px">
                        <strong>QUEJA:</strong> Disconformidad no relacionada a los productos o servicios, o, malestar o
                        descontento respecto
                        a la atención al público.
                    </div>
                    <div class="clearfix"></div>
	        
                    <div class="form-group col-md-12">
                        <div class="text-right">
		<?php 		
		if ($utipo==1): ?>
                            <button type="button" type="submit" class="btn btn-coolbox btn-sm as_btn_save">Enviar</button>
		<?php endif ?>
                        </div>
                    </div>
	         
                    </form>

                    
                </div>
            </div>
            <div class="col-md-12" style="margin-bottom: 20px">
                
                <p style="font-size: 11px">* La formulación del reclamo no impide acudir a otras vias de solución de
                    controversias ni es requisito
                    previo para interponer una denuncia ante el INDECOPI.<br/>
                    * El proveedor deberá dar respuesta a los reclamos y las quejas que se consignen en un plazo no mayor a quince (30) días calendario, improrrogables.</p>

            </div>

            </div>
   
 
    <script>
        setTimeout(function () {
            $("#msg").fadeOut(3000, function () {
                $(this).remove();
            });
        }, 5000);      

        $('#asForm').submit(function(e){
            opcion =3;
            fecres = $.trim($('#fecres').val());
            resppo = $.trim($('#resppo').val());
	resppo = resppo.replace(/[^\w\s]/gi, '');
            idre = $.trim($('#idre').val());
            e.preventDefault();
            nresp = resppo.length;
	if (nresp >0) {
            $.ajax({    
                    url:  "libroreclama.php",
                    type: "POST",
                    datatype:"json",
                    data:  {opcion:opcion,idre:idre,resppo:resppo,fecres:fecres},
                    success: function(data)
                    {
                    alert('Solo datos han sido guardados correctamente')
                    
                    }
                });
              } else {
                    alert('Datos Vacios !!'); 
                    }
            });

    </script>
       <script src="bootstrap.js"></script>
    <script src="as_form.js"></script>
    
</div>
</body>

</html>
<?php } else {
    header("Location: ../../CYM/");
}
?>
