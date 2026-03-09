const APP = new Vue({
    el:"#contenedorPrimario",
    data:{
        listaSubCat:[],
        listaCategoria:[],
        listaMarcas:[],
        categori:'000',
        marca:'000',
        imagenSelect:0,
        listaProductos:[],
        listaImagens:[],
        dataReProd:{
            marcaprod:'',
            subCat:'',
            conten1:'',
            conten2:'',
            conten3:'',
            id_prod:'',
            cod_prod:'',
            cod_cat:'',
            cod_mar:'',
            nom_pro:'Nombre del producto seleccionado',
            precio:'0.00',
            catego:'',
            marc:'',
        },
        imagenSelectLista:-1,
        imagenGuardadas:0,
        imagenRecorrida:0,
        listaImgEliminar:[],
    },
    methods:{
        onlyNumber ($event) {
            //console.log($event.keyCode); //keyCodes value
            let keyCode = ($event.keyCode ? $event.keyCode : $event.which);
            if ((keyCode < 48 || keyCode > 57) && keyCode !== 46) { // 46 is dot
                $event.preventDefault();
            }
        },
        cargarDataProd(){
            const idProd = $("#producto_c").val()
            $.ajax({
                type: "POST",
                url: "../ajax/ajs_productos.php",
                data: {idProd,tipo:'prod-s-data2'},
                success: function (res) {
                    console.log(res)
                    res= JSON.parse(res);
                    APP._data.dataReProd={
                        id_prod:res.prod_id,
                        cod_prod:'',
                        cod_cat:'',
                        cod_mar:'',
                        subCat:res.sub_cat,
                        conten1:res.content1,
                        conten2:res.content2,
                        conten3:res.content3,
                        nom_pro:res.nombre,
                        precio:APP.formatNumerPrecio(res.precio),
                        catego:res.categoria,
                        marc:res.marca,
                        marcaprod:res.marca_cod

                    };
                    $("#stock_prod").val(res.stock_prod);
                    $("#precioprod").val(res.precio_prod);

                    APP._data.listaImagens = res.imagenes;

                    $('#summernote-des').summernote('code',res.descripcion)
                    $('#summernote-esp').summernote('code',res.caracteristicas)
                    console.log(res);
                }
            });

        },
        resetImagenSele(){
            this.imagenSelectLista=-1;
        },
        eliminarFoto(){
            const itemTemp = this.listaImagens[this.imagenSelectLista]
            if(itemTemp.foto_id!=-1){
                this.listaImgEliminar.push(itemTemp)
            }
            this.listaImagens.splice( this.imagenSelectLista, 1 );
            this.imagenSelectLista=-1;
        },
        dismi(){
            if (this.imagenSelectLista!=-1){
                const itemTmep= this.listaImagens[this.imagenSelectLista]
                this.listaImagens.splice( this.imagenSelectLista, 1 );
                if (this.imagenSelectLista>0){
                    this.imagenSelectLista--;
                }
                var arrTemp =[];
                for (var i=0; i<this.listaImagens.length;i++){
                    if (i==this.imagenSelectLista){
                        arrTemp.push(itemTmep);
                    }
                    arrTemp.push(this.listaImagens[i]);
                }
            }
            this.listaImagens=arrTemp
            this.reorganisarNumeros();
        },
        aumen(){
            if (this.imagenSelectLista<this.listaImagens.length){
                const itemTmep= this.listaImagens[this.imagenSelectLista]
                this.listaImagens.splice( this.imagenSelectLista, 1 );
                if (this.imagenSelectLista<this.listaImagens.length){
                    this.imagenSelectLista++;
                }
                var arrTemp =[];

                for (var i=0; i<this.listaImagens.length;i++){
                    if (i==this.imagenSelectLista){
                        arrTemp.push(itemTmep);
                    }
                    arrTemp.push(this.listaImagens[i]);
                }
                if (this.imagenSelectLista==this.listaImagens.length){
                    arrTemp.push(itemTmep);
                }
                this.listaImagens=arrTemp
                this.reorganisarNumeros();
            }

        },
        reorganisarNumeros(){
            for (var i =0; i<this.listaImagens.length;i++){
                this.listaImagens[i].orden = i+1;
            }
        },
        selectImagenLista(index){
            this.imagenSelectLista=index
        },
        cambiarImagen(urlv){
            console.log(urlv);
            //this.listaProductos=index;
            $("#product_img").attr("src",urlv);
        },
        getURLImagen(imga){
            return  URL.createObjectURL(imga);
        },
        addImagenLista(imagen){
            this.listaImagens.push(imagen)
        },
        formatNumerPrecio(num){
            return parseFloat(num+"").toFixed(2)
        },
        getDataCategorias(){

        },
        onCategoria(event) {
            console.log(event.target.value)
            this.cargarData()
        },
        onMarca(event) {
            console.log(event.target.value)
            this.cargarData()
        },
        productoSeleccionado(prod_cod){
            console.log(prod_cod)
            $.ajax({
                type: "POST",
                url: "../ajax/ajs_productos.php",
                data: {tipo:'producto-onli',cod:prod_cod},
                success: function (resp) {
                    resp = JSON.parse(resp);
                    console.log(resp);
                    APP._data.dataReProd={
                        cod_prod:prod_cod,
                        cod_cat:resp.cod_cate,
                        cod_mar:resp.cod_subc,
                        nom_pro:resp.nombre,
                        precio:resp.precio_venta,
                        catego:resp.nom_sub1,
                        marc:resp.nom_sub2,
                    }

                    $("#buscar-productos").modal('hide');
                }
            });

        },
        recargarDatatable(){
            table.clear().draw(true);
            for (var i = 0; i<this.listaProductos.length;i++){
                table.row.add( [this.listaProductos[i].nom_prod,this.listaProductos[i].nom_sub1,this.listaProductos[i].nom_sub2,"<button onclick=\"APP.productoSeleccionado('"+this.listaProductos[i].cod_prod+"')\" class='btn btn-success' style='padding: 10px;padding-top: 5px;padding-bottom: 5px;'><i class='fa fa-check'></i></button>"] ).draw( false );
            }

        },
        cargarData(){
            this.listaProductos=[];

            if(this.categori!='000'){
                const codCar = this.categori;
                if(this.marca=='000'){
                    $.ajax({
                        type: "POST",
                        url: "../ajax/ajs_productos.php",
                        data: {tipo:'prod-cat-all',ctg:codCar},
                        success: function (resp) {
                            console.log(resp)
                            resp =  JSON.parse(resp)

                            APP._data.listaProductos = resp
                            setTimeout(function () {
                                APP.recargarDatatable()
                            },100)
                        }
                    });

                }else{
                    const codMarca =  this.marca;
                    $.ajax({
                        type: "POST",
                        url: "../ajax/ajs_productos.php",
                        data: {tipo:'prod-cat-marc',ctg:codCar,mrc:codMarca},
                        success: function (resp) {
                            resp =  JSON.parse(resp)
                            //console.log(resp)
                            APP._data.listaProductos = resp
                            setTimeout(function () {
                                APP.recargarDatatable()
                            },100)
                        }
                    });
                }
            }
        },
        refrescarimagenes(){
            this.listaImagens.forEach(function (element, index) {
                seImgFil(element,index)
            });
        },
        verificadorGuardado(){
            if (this.imagenRecorrida == this.listaImagens.length){
                swal("Guardado","","success").then(function () {

                    window.location.href = "./productos_remate.php";
                })
            }
        },
        guardarImagenProd(prod_id){
            if (this.listaImagens.length>0){
                this.listaImagens.forEach(function (element, index) {
                    if (element.foto_id == -1 ){
                        var fd = new FormData();
                        fd.append('file',element.imagen_url);
                        fd.append('posicion',element.orden);
                        fd.append('produc',APP._data.dataReProd.id_prod);
                        $.ajax({
                            xhr: function() {
                                var xhr = new window.XMLHttpRequest();
                                xhr.upload.addEventListener("progress", function(evt) {
                                    if (evt.lengthComputable) {
                                        //var percentComplete = ((evt.loaded / evt.total) * 100);
                                        //APP._data.progreso=percentComplete;
                                    }
                                }, false);
                                return xhr;
                            },
                            type: 'POST',
                            url: '../ajax/upload_img_prod.php',
                            data: fd,
                            contentType: false,
                            cache: false,
                            processData:false,
                            beforeSend: function(){
                                console.log('inicio');
                            },
                            error:function(err){
                                APP._data.imagenRecorrida++;
                                console.log(err);
                                APP.verificadorGuardado()
                            },
                            success: function(resp){
                                APP._data.imagenRecorrida++;
                                console.log(resp);
                                APP._data.imagenGuardadas++
                                APP.verificadorGuardado()

                            }
                        });
                    }else{
                        element.tipo='u'

                        $.ajax({
                            type: "POST",
                            url: '../ajax/ajs_imagen.php',
                            data: element,
                            success: function (resp) {
                                APP._data.imagenRecorrida++;
                                APP.verificadorGuardado()
                                console.log(resp)
                            }
                        });

                    }


                });
            }else{
                swal("Guardado","","success").then(function () {

                    window.location.href = "./productos.php";
                })
            }
        },
        guardarProducto(){

            var dataR = {...this.dataReProd}
            dataR.descripcion =$('#summernote-des').summernote('code');
            dataR.especificaciones =$('#summernote-esp').summernote('code');
            dataR.tipo ="prod-u2";
            dataR.cod_marca = $("#marcaproducto").val();
            dataR.stock_prod = $("#stock_prod").val();
            dataR.precio_prod = $("#precioprod").val();
            dataR.marc = $("#marcaproducto option:selected").text();

            console.log(dataR)
            $.ajax({
                type: "POST",
                url: "../ajax/ajs_productos.php",
                data: dataR,
                success: function (resp) {
                    console.log(resp)
                    if (isJson(resp)){
                        resp = JSON.parse(resp);
                        var datosElimiar = {
                            tipo:'del',
                            imasgg:JSON.stringify(APP._data.listaImgEliminar)
                        }
                        $.ajax({
                            type: "POST",
                            url: "../ajax/ajs_imagen.php",
                            data: datosElimiar,
                            success: function (resp) {
                                console.log(resp)
                            }
                        });

                        APP.guardarImagenProd(dataR.id_prod)

                    }else{
                        swal("Error en el Servidor","","error");
                    }
                }
            });



        }
    },
    computed:{
        imagenSelectIMG(){
            const item = this.listaImagens[this.imagenSelect]
            return item.foto_id == -1? this.getURLImagen(item.imagen_url):'../public/img/productos/'+item.imagen_url;
        },
        primeraImg(){
            return this.listaImagens[0];
        }
    }
});
function isJson(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}
function seImgFil(fil,id) {
    var reader = new FileReader();
    reader.onload = function (e) {
        $('#imgPr_'+id).attr('src', e.target.result);
    };
    //console.log(fil)
    reader.readAsDataURL(fil.img);
}

var table;
$( document ).ready(function() {
    APP.cargarDataProd();

    $("#fil-imagen").change(function(){
        if (this.files && this.files[0]){
            APP._data.listaImagens.push({
                foto_id:-1,
                imagen_url:this.files[0],
                orden:APP._data.listaImagens.length+1
            });
            //APP.refrescarimagenes()
            $("#fil-imagen").val("");
        }

    });

    //APP_PROD.getInfoProduc()
    table =  $('#example').DataTable({
        language: {
            url: '../utils/Spanish.json'
        }
    });
    $('#summernote-esp').summernote({
        height:'400px',
        lang: 'es-ES',
        codemirror: { // codemirror options
            theme: 'monokai'
        }
    });
    $('#summernote-des').summernote({
        height:'400px',
        lang: 'es-ES',
        codemirror: { // codemirror options
            theme: 'monokai'
        }
    });
    setTimeout(function () {
        $("#example_wrapper").attr("style","width: 100%;")
    },300)

})