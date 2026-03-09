$(document).ready(function () {


    $("body").on('click', '.as_btn_save', function () {

        var errors = 0;


        $('.custom-error').remove();

        /** VALIDAR REQUIRED **/

        $("#asForm" + " .as_required").each(function (i, v) {

            var el = $(this).attr('id');
            var tipo = $(this).attr('type');

            if ($(this).is('input')) {

                if ($("#" + el).val().trim() == ''  && tipo != "radio") {
                    errors++;
                    if (tipo == "text" || tipo == "password") {
                        $("#" + el).parent().append('<div class="custom-error"><div style="color: red; font-size: 11px">* Este campo es obligatorio</div></div>');
                    }

                    if (tipo == "file") {
                        $("#" + el).parent().append('<div class="custom-error"><div style="color: red; font-size: 11px">* Debe seleccionar un archivo</div></div>');
                    }

                }

            }

            if(tipo == "radio"){

                    var name = $("#" + el).attr('name');
                    var ubic = $("#" + el).attr('errorUbi');

                    if (!$("input[name='" + name + "']").is(':checked')) {
                        if(ubic == "top"){
                            $("#" + el).parent().parent().prepend('<div class="custom-error"><div style="color: red; font-size: 11px">* Debe seleccionar una opción</div></div>');
                        }else{
                            $("#" + el).parent().parent().append('<div class="custom-error"><div style="color: red; font-size: 11px">* Debe seleccionar una opción</div></div>');
                        }
                    }
                    
            }


            if(tipo == "checkbox"){

                    var name = $("#" + el).attr('name');
                    var ubic = $("#" + el).attr('errorUbi');
                    var req = $("#" + el).attr('req');
                    var total = $("#" + el).parent().parent().find('input[type="checkbox"]:checked').length;

                    if(req > 0){

                        if(total < req){
                            
                            if(ubic == "top"){
                                $("#" + el).parent().parent().prepend('<div class="custom-error"><div style="color: red; font-size: 11px">* Debe seleccionar al menos ' + req + ' opciones</div></div>');
                            }else{
                                $("#" + el).parent().parent().append('<div class="custom-error"><div style="color: red; font-size: 11px">* Debe seleccionar al menos ' + req + ' opciones</div></div>');
                            }
                            
                        }

                    }else if(req == 0){

                        if(total == 0){

                            if(ubic == "top"){
                                $("#" + el).parent().parent().prepend('<div class="custom-error"><div style="color: red; font-size: 11px">* Debe seleccionar al menos una opción</div></div>');
                            }else{
                                $("#" + el).parent().parent().append('<div class="custom-error"><div style="color: red; font-size: 11px">* Debe seleccionar al menos una opción</div></div>');
                            }

                        }

                    }
                    
            }


            if ($(this).is('select')) {

                if ($("#" + el).val() == '') {
                    errors++;
                    $("#" + el).parent().append('<div class="custom-error"><div style="color: red; font-size: 11px">* Debe seleccionar un elemento</div></div>');


                }

            }

            if ($(this).is('textarea')) {

                if ($("#" + el).val() == '') {
                    errors++;
                    $("#" + el).parent().append('<div class="custom-error"><div style="color: red; font-size: 11px">* Este campo es obligatorio</div></div>');


                }

            }

        });

        /** CHECK PASSWORD **/

        if ($("#password") != "" && $("#repassword") != "") {

            if ($("#password").val() != $("#repassword").val()) {
                errors++;
                $("#password").parent().append('<div class="custom-error"><div style="color: red; font-size: 11px">* Las contraseñas no coinciden</div></div>');
            }

        }

        /** CHECK BITRHDAY **/

        if($("#bday").val() == 0 || $("#byear").val() == 0 || $("#bmonth").val() == 0){

            errors++;
            $("#bpicker").parent().append('<div class="custom-error"><div style="color: red; font-size: 11px">* Debe completar su fecha de nacimiento</div></div>');
        }


        /** CHECK ERRORES **/

        if (errors > 0) {
            return false;
        } else {

            $("#asForm").submit();

        }


    });

    $("body").on('click', '.as_btn_print', function () {

        var errors = 0;


        $('.custom-error').remove();

        /** VALIDAR REQUIRED **/

        $("#asForm" + " .as_required").each(function (i, v) {

            var el = $(this).attr('id');
            var tipo = $(this).attr('type');

            if ($(this).is('input')) {

                if ($("#" + el).val().trim() == '') {
                    errors++;
                    if (tipo == "text" || tipo == "password") {
                        $("#" + el).parent().append('<div class="custom-error"><div style="color: red; font-size: 11px">* Este campo es obligatorio</div></div>');
                    }

                    if (tipo == "file") {
                        $("#" + el).parent().append('<div class="custom-error"><div style="color: red; font-size: 11px">* Debe seleccionar un archivo</div></div>');
                    }

                }

            }

            if ($(this).is('select')) {

                if ($("#" + el).val() == '') {
                    errors++;
                    $("#" + el).parent().append('<div class="custom-error"><div style="color: red; font-size: 11px">* Debe seleccionar un elemento</div></div>');


                }

            }

            if ($(this).is('textarea')) {

                if ($("#" + el).val() == '') {
                    errors++;
                    $("#" + el).parent().append('<div class="custom-error"><div style="color: red; font-size: 11px">* Este campo es obligatorio</div></div>');


                }

            }

        });

        /** CHECK PASSWORD **/

        if ($("#password") != "" && $("#repassword") != "") {

            if ($("#password").val() != $("#repassword").val()) {
                errors++;
                $("#password").parent().append('<div class="custom-error"><div style="color: red; font-size: 11px">* Las contraseñas no coinciden</div></div>');
            }

        }


        /** CHECK ERRORES **/

        if (errors > 0) {
            return false;
        } else {

            window.print();

        }


    });

    $("body").on('click', '.as_btn_modal', function () {

        var modal = $(this).attr('modal');

        $("#" + modal).find('input:text').val("");
        $("#" + modal).find('select').val("");
        $("#" + modal).find('input:checkbox').prop('checked', '');

        $("#" + modal).find('.modal-title').html("Nueva Dirección");


        $("#" + modal).modal('show');

    })

    $(".number").bind("keydown", function (event) {

        if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 ||
            // Allow: Ctrl+A
            (event.keyCode == 65 && event.ctrlKey === true) ||

            // Allow: Ctrl+C
            (event.keyCode == 67 && event.ctrlKey === true) ||

            // Allow: Ctrl+V
            (event.keyCode == 86 && event.ctrlKey === true) ||

            // Allow: home, end, left, right
            (event.keyCode >= 35 && event.keyCode <= 39)) {
            // let it happen, don't do anything
            return;
        } else {
            // Ensure that it is a number and stop the keypress
            if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 ) && ( event.keyCode != 110) && (event.keyCode != 190)) {
                event.preventDefault();
            }
        }


    });

});