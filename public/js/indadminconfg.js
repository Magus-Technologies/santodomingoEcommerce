const APP = new Vue({
    el:"#contenedor-principal",
    data:{
        itemselect:0,
        dataRTel:{
          numero:'',
          nombre:'',

        },
        dataRwhat:{
            numero:'',
            nombre:'',
            mensaje:'',
            dia1:'',
            dia2:'',
            hora1:'',
            modo1:'',
            hora2:'',
            modo2:'',
            estado:true
        },
        dataConf:{
            titulo:'',
            descripcion:'',
            direccion:'',
            email:'',
            numero_central:'',
            telefonos:[],
            redessociales:{
                id_facebook: "",
                facebook: "",
                twitter: "#",
                google_plus: "#",
                youtube: "#",
                instagram: "",
                whatsapp: []
            },
            suscripcion_titulo: '',
            suscripcion_parrafo: '',
            suscripcion_imagen: '',
            footer_tagline: '',
            footer_logo: '',
            footer_imagen: '',
            footer_productos: [
                {nombre:'Vino Tinto',  url:'shop-list-ctg.php?ctg=001'},
                {nombre:'Vino Blanco', url:'shop-list-ctg.php?ctg=001'},
                {nombre:'Vino Rosado', url:'shop-list-ctg.php?ctg=001'},
                {nombre:'Espumante',   url:'shop-list-ctg.php?ctg=001'},
                {nombre:'Pisco',       url:'shop-list-ctg.php?ctg=001'}
            ],
            footer_servicios: [
                {titulo:'Contamos con Delivery.',                       descripcion:'Consultar al Whatsapp 930 570 018'},
                {titulo:'Contamos con super descuentos y promociones.', descripcion:'Siempre Conserve su Boleta o Factura de Compra'},
                {titulo:'Contamos con Soporte Técnico',                 descripcion:'Especialistas en hardware y mantenimiento'}
            ],
            footer_empresa_links: [
                {nombre:'Nosotros', url:'about.php', target:'_self'},
                {nombre:'Contactanos', url:'contact.php', target:'_self'},
                {nombre:'Terminos y Condiciones', url:'term.php', target:'_self'}
            ],
            footer_libro_reclamaciones: true,
            footer_metodos_pago: [
                {nombre:'visa', imagen:'../public/assets/images/visa.png'},
                {nombre:'discover', imagen:'../public/assets/images/discover.png'},
                {nombre:'master_card', imagen:'../public/assets/images/master_card.png'}
            ],
            footer_copyright: {
                texto: 'Todos los derechos reservados por',
                empresa: 'MAGUS TECHNOLOGIES',
                url: 'https://magustechnologies.com/'
            }
        }
    },
    methods:{
        actualizarWatsapp(index){
            this.itemselect=index;
            $('#edtWhatsapp').modal('show');
        },

        dismi(index){
            if (index!=-1){
                const itemTmep= this.dataConf.redessociales.whatsapp[index]
                this.dataConf.redessociales.whatsapp.splice( index, 1 );
                if (index>0){
                    index--;
                }
                var arrTemp =[];
                for (var i=0; i<this.dataConf.redessociales.whatsapp.length;i++){
                    if (i==index){
                        arrTemp.push(itemTmep);
                    }
                    arrTemp.push(this.dataConf.redessociales.whatsapp[i]);
                }
            }
            this.dataConf.redessociales.whatsapp=arrTemp
        },
        aumen(index){
            if (index<this.dataConf.redessociales.whatsapp.length){
                const itemTmep= this.dataConf.redessociales.whatsapp[index]
                this.dataConf.redessociales.whatsapp.splice( index, 1 );
                if (index<this.dataConf.redessociales.whatsapp.length){
                    index++;
                }
                var arrTemp =[];

                for (var i=0; i<this.dataConf.redessociales.whatsapp.length;i++){
                    if (i==index){
                        arrTemp.push(itemTmep);
                    }
                    arrTemp.push(this.dataConf.redessociales.whatsapp[i]);
                }
                if (index==this.dataConf.redessociales.whatsapp.length){
                    arrTemp.push(itemTmep);
                }
                this.dataConf.redessociales.whatsapp=arrTemp
            }

        },


        moverItemWahsapp(){

        },
        visualisador(dia){
            const dias = ["DOMINGO","LUNES","MARTES","MIERCOLES","JUEVES","VIERNES","SABADO"];
            return dias[dia];
        },

        onlyNumber ($event) {
            //console.log($event.keyCode); //keyCodes value
            let keyCode = ($event.keyCode ? $event.keyCode : $event.which);
            if ((keyCode < 48 || keyCode > 57) && keyCode !== 46) { // 46 is dot
                $event.preventDefault();
            }
        },
        agregarNumero(){
            this.dataConf.telefonos.push(this.dataRTel);
            this.dataRTel={
                numero:'',
                nombre:''
            };
            $('#addTelefoo').modal('hide');
        },
        agregarwhat(){
            this.dataConf.redessociales.whatsapp.push(this.dataRwhat);
            this.dataRwhat={
                numero:'',
                nombre:'',
                mensaje:''
            };
            $('#addWhatsapp').modal('hide');
        },
        eliminarWhatsapp(index){
            this.dataConf.redessociales.whatsapp.splice(index,1);
        },
        eliminarTelefono(index){
            this.dataConf.telefonos.splice(index,1);
        },
        cargarData(){
            $.ajax({
                type: "POST",
                url: '../ajax/ajs_configuracione.php',
                data: {tipo:'info_princ'},
                success: function (resp) {
                    resp = JSON.parse(resp);
                    console.log(resp);
                    APP._data.dataConf = resp;
                }
            });

        },
        cargarGuardar(){
            const dataP={
                tipo:'save-info',
                info:JSON.stringify(this.dataConf)
            }
            $.ajax({
                type: "POST",
                url: '../ajax/ajs_configuracione.php',
                data: dataP,
                success: function (resp) {
                    console.log(resp);
                    swal("Cambios guardados","","success")
                }
            });

        }
    }
});



$( document ).ready(function() {
    APP.cargarData();
});

function previewFooterLogo(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) { $('#preview_footer_logo').attr('src', e.target.result); };
        reader.readAsDataURL(input.files[0]);
    }
}

function previewFooterImg(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) { $('#preview_footer_img').attr('src', e.target.result); };
        reader.readAsDataURL(input.files[0]);
    }
}

function guardarFooterLogo() {
    var file = $('#fill_footer_logo')[0];
    if (!file.files.length) { swal('Selecciona una imagen primero','','warning'); return; }
    var fd = new FormData();
    fd.append('file', file.files[0]);
    $.ajax({
        type:'POST', url:'../ajax/upload_img_banner.php', data:fd,
        contentType:false, cache:false, processData:false,
        success: function(resp) {
            resp = JSON.parse(resp);
            APP._data.dataConf.footer_logo = resp.dstos;
            APP.cargarGuardar();
        }
    });
}

function previewSuscImg(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) { $('#preview_suscripcion_img').attr('src', e.target.result); };
        reader.readAsDataURL(input.files[0]);
    }
}

function guardarSuscImg() {
    var file = $('#fill_suscripcion_img')[0];
    if (!file.files.length) { swal('Selecciona una imagen primero','','warning'); return; }
    var fd = new FormData();
    fd.append('file', file.files[0]);
    $.ajax({
        type:'POST', url:'../ajax/upload_img_banner.php', data:fd,
        contentType:false, cache:false, processData:false,
        success: function(resp) {
            resp = JSON.parse(resp);
            APP._data.dataConf.suscripcion_imagen = resp.dstos;
            APP.cargarGuardar();
        }
    });
}

function guardarFooterImagen() {
    var file = $('#fill_footer_imagen')[0];
    if (!file.files.length) { swal('Selecciona una imagen primero','','warning'); return; }
    var fd = new FormData();
    fd.append('file', file.files[0]);
    $.ajax({
        type:'POST', url:'../ajax/upload_img_banner.php', data:fd,
        contentType:false, cache:false, processData:false,
        success: function(resp) {
            resp = JSON.parse(resp);
            APP._data.dataConf.footer_imagen = resp.dstos;
            APP.cargarGuardar();
        }
    });
}