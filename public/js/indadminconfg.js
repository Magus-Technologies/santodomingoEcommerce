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