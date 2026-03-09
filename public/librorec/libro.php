<?php
    $hoy = date("Y-m-d");
    $anual = date("Y");
    include "BD.php";
    $sql0 = "SELECT (CASE  WHEN COUNT(lib_id) = 0 THEN 1 ELSE COUNT(lib_id)+1  END) as codirec
    FROM libro_reclamacion";
    $res0 = mysqli_query($con,$sql0);
    $arr0 = mysqli_fetch_array($res0,MYSQLI_ASSOC);
    $numerec = $arr0['codirec'];
    $codigorec = '00000000'.$numerec.'-'.$anual;
?>
<html>
<head>
    <title>Ace Advance Group S.a.C. - Libro de Reclamaciones Virtual</title>
    <link type="text/css" media="all" href="bootstrap_libro.css" rel="stylesheet">
    <link type="text/css" media="all" href="custom_lib.css" rel="stylesheet">
    <link type="text/css" media="all" href="print_lib.css" rel="stylesheet">
    
</head>

<script type="text/javascript" src="jquery-1.12.3.min.js"></script>
<body>
<div class="container" style="margin-top: 10px; margin-bottom: 20px">
    <div class="row">
        <div class="col-md-12 text-center" style="margin-bottom: 0px">
            <h3>Ace Advance Group S.a.C. RUC N°: 20613235168</h3>
	<br>
            <div class="row">
              <div class="col-sm-2">&nbsp;</div>
             <div class="col-sm-4">Por favor ingrese sus DNI / CE:</div>
             <div class="input-group col-sm-4">
              <input type="text" class="form-control" id="numfil">
                <span class="input-group-btn">
                <button class="btn btn-primary" id="btnFiltro" type="button"> Buscar</button>
                </span>
             </div>          
             <div class="col-sm-2">&nbsp;</div>
           </div>
        </div>
                    

            <div class="col-md-12" style="border: 2px solid black">
                <form id="asForm" class="form-horizontal">
                <div class="form-group form-libro">
           
                    <!--<span style="font-size: 0.85em">Av. Garcilazo de la Vega 1251, Tienda #123, Lima, Lima</span> <label for="fecha" class="col-sm-1 control-label" style="text-align: left">FECHA:</label>
                    
                        <input type="text" class="form-control input-sm as_required" id="fecha" name="fecha"
                               placeholder="">
                    </div> -->
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
                        name="negocio" placeholder="" value="Ace Advance Group S.A.C." disabled>
                    </div>
                    <label for="tienda" class="col-sm-2 control-label" style="text-align: left">TIENDA:</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control input-sm as_required text-uppercase" id="tienda" 
                        name="tienda" placeholder="" value="CAL. OCTAVIO MU&Ntilde;OZ NAJAR NRO 223 INT. 103 URB. CERCADO" disabled>
                    </div>
                    
                    <div class="clearfix"></div>
                    <div class="col-md-12" style="background-color: #bebebe">
                        1. IDENTIFICACIÓN DEL CONSUMIDOR RECLAMANTE
                    </div>
                    <label for="nombre" class="col-sm-2 control-label" style="text-align: left">NOMBRE:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control input-sm as_required" id="nombre" name="nombre"
                               placeholder="" disabled>
                    </div>
                    <label for="domicilio" class="col-sm-2 control-label" style="text-align: left">DOMICILIO:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control input-sm as_required" id="domicilio" name="domicilio"
                               placeholder="" disabled>
                    </div>
                    <label for="dni" class="col-sm-2 control-label" style="text-align: left">DNI / CE:</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control input-sm as_required number" id="dni" name="dni"
                               placeholder="" maxlength="11" disabled>
                    </div>
                    <div class="col-sm-2">
                        <input type="text" class="form-control input-sm as_required number" id="telefono"
                               name="telefono"
                               placeholder="" maxlength="9">
                    </div>
                    <label for="email" class="col-sm-1 control-label" style="text-align: left">EMAIL:</label>
                    <div class="col-sm-4">
                        <input type="email" class="form-control input-sm as_required" id="email" name="email"
                               placeholder="">
                    </div>
                    <label for="menor" class="col-sm-2 control-label" style="text-align: left">MENOR DE EDAD:</label>
                    <div class="col-sm-10">
                    <input type="checkbox"
                               class=""
                               id="menor"
                               name="menor"
                               value="1">
                        <span style="font-size: 12px;clear: both;"> <small> [LLENAR INFORMACIÓN DEL APODERADO]</small></span>
                    </div>
               
                    
                    <div class="clearfix"></div>
                    <div class="col-sm-12">
                    <label for="menor" class="col-sm-4 control-label" style="text-align: left">
                       
                        
                    </div>
                    <label for="nombre_padre" class="col-sm-2 control-label" style="text-align: left">NOMBRE:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control input-sm" id="nombre_padre" name="nombre_padre"
                               placeholder="" disabled="disabled">
                    </div>
                    <label for="domicilio_padre" class="col-sm-2 control-label"
                           style="text-align: left">DOMICILIO:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control input-sm" id="domicilio_padre" name="domicilio_padre"
                               placeholder="" disabled="disabled">
                    </div>
                    <label for="dni_padre" class="col-sm-2 control-label" style="text-align: left">DNI / CE:</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control input-sm number" id="dni_padre" name="dni_padre"
                               placeholder="" maxlength="11" disabled="disabled">
                    </div>
                    <label for="telefono_padre" class="col-sm-1 control-label" style="text-align: left">TELEF:</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control input-sm number" id="telefono_padre"
                               name="telefono_padre" maxlength="9"
                               placeholder="" disabled="disabled">
                    </div>
                    <label for="email_padre" class="col-sm-1 control-label" style="text-align: left">EMAIL:</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control input-sm" id="email_padre" name="email_padre"
                               placeholder="" disabled="disabled">
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-12" style="background-color: #bebebe">
                        2. IDENTIFICACIÓN DEL BIEN CONTRATADO
                    </div>
                    <label for="producto" class="col-sm-2 control-label" style="text-align: left">
                        <input type="radio" class="as_required" id="producto" name="tipo_bien" value="producto"> PRODUCTO
                    </label>
                    <label for="monto" class="col-sm-3 control-label" style="text-align: left">MONTO RECLAMADO:</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control input-sm as_required number" id="monto" name="monto"
                               placeholder="">
                    </div>
                    <div class="clearfix"></div>
                    <label for="servicio" class="col-sm-2 control-label" style="text-align: left">
                        <input type="radio" class="as_required" id="servicio" name="tipo_bien" value="servicio"> SERVICIO
                    </label>
                    <label for="descripcion" class="col-sm-3 control-label"
                           style="text-align: left">DESCRIPCIÓN:</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control input-sm as_required" id="descripcion" name="descripcion"
                               placeholder="">
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-8" style="background-color: #bebebe">
                        3. DETALLE DE LA RECLAMACIÓN Y PEDIDO DEL CONSUMIDOR
                    </div>
                    <label for="reclamo" class="col-sm-2 control-label" style="text-align: left">
                        <input type="radio" class="as_required" id="reclamo" name="tipo_reclamo" value="reclamo">
                        RECLAMO
                    </label>
                    <label for="queja" class="col-sm-2 control-label" style="text-align: left">
                        <input type="radio" class="as_required" id="queja" name="tipo_reclamo" value="queja"> QUEJA
                    </label>

                    <div class="col-sm-12">
                        <textarea class="form-control input-sm as_required" id="detalle" name="detalle" rows="10"
                                  placeholder="DETALLE.."></textarea>
                    </div>
                    <div class="col-sm-12">
                        <textarea class="form-control input-sm as_required" id="pedido" name="pedido" rows="8"
                                  placeholder="PEDIDO.."></textarea>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group col-md-12">
                        <div class="text-right">
                            <button type="button" class="btn btn-primary btn-sm as_btn_print"><i
                                        class="fa fa-print"></i> Imprimir
                            </button>
                            <button type="button" type="submit" class="btn btn-coolbox btn-sm as_btn_save">Enviar</button>
                        </div>
                    </div>
                    <!-- READONLY -->
                    <div class="col-md-12" style="background-color: #bebebe">
                        4. OBSERVACIONES Y ACCIONES ADOPTADAS POR EL PROVEEDOR
                    </div>
                    <label for="fecha" class="col-sm-5 control-label" style="text-align: left">FECHA DE COMUNICACIÓN DE
                        LA RESPUESTA:</label>
                    <div class="col-sm-3">
                        <input type="date" id="fecres" class="form-control input-sm" readonly
                               placeholder="">
                    </div>
                    <div class="col-sm-12">
                        <textarea readonly class="form-control input-sm" rows="5" id="respuesta"
                                  placeholder=""></textarea>
                    </div>
                    <div class="col-sm-4 text-center" style="font-size: 12px">
                        <strong>RECLAMO:</strong> Disconformidad relacionada a los productos o servicios.
                    </div>
                    <div class="col-sm-8 text-center" style="font-size: 12px">
                        <strong>QUEJA:</strong> Disconformidad no relacionada a los productos o servicios, o, malestar o
                        descontento respecto
                        a la atención al público.
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
      $("#btnFiltro").click(function(e){
      opcion = 9;  
      numfil = $.trim($('#numfil').val());
      let ncarc = numfil.length;
      if (ncarc == 8) { tipo ='dni'; }
      if (ncarc == 11) { tipo ='ruc'; }
      e.preventDefault();
      if (ncarc == 8 || ncarc == 11) {
      $.ajax({    
          url:  "libroreclama.php",
          type: "POST",
          datatype:"json",
          data:  {opcion:opcion,numfil:numfil,tipo:tipo},
          success: function(resp)
          {
            resp = JSON.parse(resp);
            let data = JSON.parse(resp)
            console.log(data);
            //
            if (data.res) {
                if (ncarc == 11) {
                if (data.data.direccion.length=11) {
                    $("#domicilio").val(data.data.direccion);  
                    $("#domicilio").prop('disabled',true);      
                } else {
                    $("#domicilio").val("");      
                    $("#domicilio").prop('disabled',false);      
                }
                    $("#nombre").val(data.data.razon_social);  
                }
                if (ncarc == 8) {
                    let nombres = data.data.nombres + ' ' + data.data.apellido_paterno + ' ' + data.data.apellido_materno;
                    $("#nombre").val(nombres);  
                    $("#domicilio").val("");      
                    $("#domicilio").prop('disabled',false);
                }
                 
                $("#dni").val(numfil);               
            } else {
                $("#domicilio").val("");      
                $("#nombre").val("");               
                $("#dni").val("");
            }
          }
        });
      } else { alert('numero correcto de caracteres.');}  
    });

        setTimeout(function () {
            $("#msg").fadeOut(3000, function () {
                $(this).remove();
            });
        }, 5000);


       
        $('#numrecla').keypress(function(event){
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if(keycode == '13'){
                var numrecla = $(this).val();
            CargaDatos(numrecla);
             }
            });

        function CargaDatos(numerorec){
            opcion = 2;
            //e.preventDefault();
            $.ajax({    
                    url:  "libroreclama.php",
                    type: "POST",
                    datatype:"json",
                    data:  {opcion:opcion,numerorec:numerorec},
                    success: function(data)
                    {
                    ///alert('Solo datos encontrados');
                    var cadena = data;
                    let ObjetoJS = JSON.parse(cadena);
                    //RECORRER OBJETO
                    for (let item of ObjetoJS){
                        var fecharec  = item.lib_date;
                        var nombre =  item.lib_cliente;
                        var domicilio =  item.lib_domicilio;
                        var dni = item.lib_DNI;
                        var telefono =  item.lib_telecli;
                        var email =  item.lib_emailcli;
                        var monto =   item.lib_montorec;
                        var descripcion =  item.lib_serdesc;
                        var detalle =  item.lib_detalle;
                        var pedido =  item.lib_pedido;
                        var respuesta = item.lib_respuesta;
                        var fecres = item.lib_fecres;
                    }
                    $("#fecharec").val(fecharec);
                    $("#nombre").val(nombre);
                    $("#domicilio").val(domicilio);
                    $("#dni").val(dni);
                    $("#telefono").val(telefono);
                    $("#email").val(email);
                    $("#monto").val(monto);
                    $("#descripcion").val(descripcion);
                    $("#detalle").val(detalle);
                    $("#pedido").val(pedido);
                    $("#respuesta").val(respuesta);
                    $("#fecres").val(fecres);

                    }
                });


        }


        $("body").on("change", "#menor", function () {

            if ($(this).prop("checked")) {

                $("#nombre_padre").removeAttr('disabled');
                $("#domicilio_padre").removeAttr('disabled');
                $("#dni_padre").removeAttr('disabled');
                $("#telefono_padre").removeAttr('disabled');
                $("#email_padre").removeAttr('disabled');

                $("#nombre_padre").addClass('as_required');
                $("#domicilio_padre").addClass('as_required');
                $("#dni_padre").addClass('as_required');
                $("#telefono_padre").addClass('as_required');
                $("#email_padre").addClass('as_required');

            } else {

                $("#nombre_padre").attr('disabled', 'disabled');
                $("#domicilio_padre").attr('disabled', 'disabled');
                $("#dni_padre").attr('disabled', 'disabled');
                $("#telefono_padre").attr('disabled', 'disabled');
                $("#email_padre").attr('disabled', 'disabled');

                $("#nombre_padre").removeClass('as_required');
                $("#domicilio_padre").removeClass('as_required');
                $("#dni_padre").removeClass('as_required');
                $("#telefono_padre").removeClass('as_required');
                $("#email_padre").removeClass('as_required');
            }

        });

        $('#asForm').submit(function(e){
            opcion =11;
            fecharec  = $.trim($('#fecharec').val());
            numrecla = $.trim($('#numrecla').val());  
            negocio = $.trim($('#negocio').val());
            tienda =  $.trim($('#tienda').val()); 
            
	nombre = $.trim($('#nombre').val()); 
            	nombre = nombre.replace(/[^\w\s]/gi, '');
            domicilio = $.trim($('#domicilio').val());
	            domicilio = domicilio.replace(/[^\w\s]/gi, '');
            dni = $.trim($('#dni').val());
            	dni = dni.replace(/[^\w\s]/gi, '');

            telefono = $.trim($('#telefono').val());
		telefono = telefono.replace(/[^\w\s]/gi, '');

            email = $.trim($('#email').val());
            menor = $('input:checkbox[name=menor]:checked').val();

            nombre_padre = $.trim($('#nombre_padre').val());
	  	nombre_padre = nombre_padre.replace(/[^\w\s]/gi, '');
            domicilio_padre = $.trim($('#domicilio_padre').val());
		domicilio_padre = domicilio_padre.replace(/[^\w\s]/gi, '');
            dni_padre =  $.trim($('#dni_padre').val());
		 dni_padre = dni_padre.replace(/[^\w\s]/gi, '');
            telefono_padre = $.trim($('#telefono_padre').val()); 
		telefono_padre = telefono_padre.replace(/[^\w\s]/gi, '');
            email_padre = $.trim($('#email_padre').val());
            producto = $('input:radio[name=tipo_bien]:checked').val();
            monto =  $.trim($('#monto').val());
            descripcion = $.trim($('#descripcion').val());
		descripcion = descripcion.replace(/[^\w\s]/gi, '');
            reclamo =  $('input:radio[name=tipo_reclamo]:checked').val();

            detalle = $.trim($('#detalle').val());
		detalle = detalle.replace(/[^\w\s]/gi, '');
            pedido = $.trim($('#pedido').val());
		pedido = pedido.replace(/[^\w\s]/gi, '');
            e.preventDefault();

            $.ajax({    
                    url:  "libroreclama.php",
                    type: "POST",
                    datatype:"json",
                    data:  {opcion:opcion,fecharec:fecharec,numrecla:numrecla,negocio:negocio,tienda:tienda,
                        nombre:nombre,domicilio:domicilio,dni:dni,telefono:telefono,email:email,menor:menor,
                        nombre_padre:nombre_padre,domicilio_padre:domicilio_padre,dni_padre:dni_padre,
                        telefono_padre:telefono_padre,email_padre:email_padre,producto:producto,
                        monto:monto,descripcion:descripcion,reclamo:reclamo,detalle:detalle,pedido:pedido},
                    success: function(data)
                    {
                    alert('Solo datos han sido guardados correctamente')
                    $("#asForm").trigger("reset");
                    refresh();
                    }
                });
            });

            
        function refresh() {
            setTimeout(function () {
                location.reload()
            }, 1500);
        }
    </script>
    
    <script src="bootstrap.js"></script>
    <script src="as_form.js"></script>
</div>
</body>

</html>
