const CARRITO = new Vue({
    el: "#content-carrito",
    data: {
        fun: function () { },
        isLoger: false,
        listaCarrito: []
    },
    methods: {
        agregarCarritoByDetail(obj) {
            var temp_ind = -1
            for (var i = 0; i < this.listaCarrito.length; i++) {
                if (this.listaCarrito[i].prod + '' == obj.prod_id + '') {
                    temp_ind = i;
                    break;
                }
            }
            if (temp_ind != -1) {
                if (this.listaCarrito[temp_ind].cantidad+1 < obj.stock-3 && obj.stock > 3) {
                    this.listaCarrito[temp_ind].cantidad += 1;
                    this.guardar_local_data();
                     alertExito("Agregado", "Se agrego al carrito")
                    
                } else {
                     alertAdvertencia("Alerta", "Agregar productos con mas 2 de stock o preguntar en tienda") 
                }
            } else {
                this.listaCarrito.push({
                    prod: obj.prod_id,
                    stock:parseInt(obj.stock),
                    imagen: obj.imagen,
                    nombre_prod: obj.nombre_prod,
                    cantidad: obj.cantidad,
                    precio: parseFloat(obj.precio),
                })
            }

            console.log(obj);
            this.guardar_local_data();
        },
        eliminarProdCarrito(index) {
            this.listaCarrito.splice(index, 1);
            this.guardar_local_data();
        },
        espe_prod_carr(prod) {
            console.log(prod)
            var temp_ind = -1
            for (var i = 0; i < this.listaCarrito.length; i++) {
                if (this.listaCarrito[i].prod + '' == prod + '') {
                    temp_ind = i;
                    break;
                }
            }
            $.ajax({
                type: "POST",
                url: "../ajax/ajs_productos.php",
                data: { idProd: prod, tipo: 'prod-s-data' },
                success: function (resp) {
                    resp = JSON.parse(resp);
                    const stock = parseFloat(resp.stock);
                    if (stock > 2) {
                        if (temp_ind != -1) {
                            if (CARRITO._data.listaCarrito[temp_ind].cantidad+1 < stock-2 && stock > 2) {
                                CARRITO._data.listaCarrito[temp_ind].cantidad += 1;
                                CARRITO.guardar_local_data();
                                alertExito("Agregado", "Se agrego al carrito")
                            } else {
                                alertAdvertencia("Alerta", "Producto Sin Stock suficiente")
                            }

                        } else {
                            if (resp.precio_oferta !== null) {
                                CARRITO._data.listaCarrito.push({
                                    prod: resp.prod_id,
                                    stock:stock,
                                    imagen: resp.imagenes.length > 0 ? resp.imagenes[0].imagen_url : '',
                                    nombre_prod: resp.nom_prod,
                                    cantidad: 1,
                                    precio: parseFloat(resp.precio_oferta),
                                    precio_oferta: parseFloat(resp.precio_oferta),
                                })
                            } else {
                                CARRITO._data.listaCarrito.push({
                                    prod: resp.prod_id,
                                    stock:stock,
                                    imagen: resp.imagenes.length > 0 ? resp.imagenes[0].imagen_url : '',
                                    nombre_prod: resp.nom_prod,
                                    cantidad: 1,
                                    precio: parseFloat(resp.precio),
                                    precio_oferta: parseFloat(resp.precio),
                                })
                            }

                            CARRITO.guardar_local_data();
                            alertExito("Agregado", "Se agrego al carrito")
                        }

                    } else {
                        alertAdvertencia("Alerta", "Es posible que el producto no tenga Stock")
                    }
                }
            });



        },
        addProductCarr(obj) {
            console.log(obj)
            for (var i = 0; i < this.listaCarrito.length; i++) {
            }
        },
        setDataPass(list) {
            this.listaCarrito = list;
            this.guardar_local_data();
            /*if (!this.isLoger){
                const car_data = JSON.stringify(this.listaCarrito);
                localStorage.setItem('cmp-vsn-car',car_data);
            }else{

            }*/
        },
        setFuncionExe(f) {
            this.fun = f;
        },
        guardar_local_data() {
            if (IS_LOGIN) {
                this.guardarCarritousr();
                localStorage.setItem('cmp-vsn-car', '');
            } else {
                let carritoData = JSON.parse(JSON.stringify(this.listaCarrito))
                /* console.log(carritoData);
                console.log(carritoData.length); */
                  if (carritoData.length !== 0) {
                     let car_data = JSON.stringify(this.listaCarrito);
                     $.ajax({
                         type: "POST",
                         url: "../ajax/ajs_productos.php",
                         data: { tipo: 'actualizar_producto_oferta_nossession', data: car_data },
                         success: function (resp) {
                             console.log(resp);
                             car_data = JSON.parse(car_data)
                             var lastItem = car_data.pop();
                             let carrito_no_session = car_data
                             resp = JSON.parse(resp);
                             carrito_no_session.push(resp)
                             carrito_no_session = JSON.stringify(carrito_no_session)
                             localStorage.setItem('cmp-vsn-car', carrito_no_session);
                             console.log(carrito_no_session);
                         }
                     });
                 } else {
                     localStorage.setItem('cmp-vsn-car', '');
                 } 
                /*  $.ajax({
                     type: "POST",
                     url: "../ajax/ajs_productos.php",
                     data: { tipo: 'actualizar_producto_oferta_nossession', data: car_data },
                     success: function (resp) {
                         console.log(resp);
                         car_data = JSON.parse(car_data)
                         var lastItem = car_data.pop();
                         let carrito_no_session = car_data
                         resp = JSON.parse(resp);
                         carrito_no_session.push(resp)
                         carrito_no_session = JSON.stringify(carrito_no_session)
                         localStorage.setItem('cmp-vsn-car', carrito_no_session);
                         console.log(carrito_no_session); 
                     }
                 }); */

                //hacer ajax 

            }

        },
        setCarrito(jsn) {
            console.log(jsn);

            var temp_ind = -1
            for (var i = 0; i < this.listaCarrito.length; i++) {
                if (this.listaCarrito[i].prod + '' == jsn.prod_id + '') {
                    temp_ind = i;
                    break;
                }
            }
            console.log(parseFloat(jsn.stock) , 3)
            if (parseFloat(jsn.stock) > 3) {
                if (temp_ind != -1) {
                    if (CARRITO._data.listaCarrito[temp_ind].cantidad+1 < jsn.stock && jsn.stock > 2) {
                        CARRITO._data.listaCarrito[temp_ind].cantidad += 1;
                        CARRITO.guardar_local_data();
                        alertExito("Agregado", "Se agrego al carrito")
                    } else {
                        alertAdvertencia("Alerta", "Producto Sin Stock suficiente")
                    }
                } else {
                    CARRITO._data.listaCarrito.push({
                        prod: jsn.prod_id,
                        stock:parseInt(jsn.stock),
                        imagen: jsn.imagen1,
                        nombre_prod: jsn.nom_prod,
                        cantidad: 1,
                        precio: parseFloat(jsn.precio),
                    })
                    CARRITO.guardar_local_data();
                    alertExito("Agregado", "Se agrego al carrito")
                }

            } else {
                alertAdvertencia("Alerta", "Es posible que el producto no tenga Stock")
            }
        },
        getDataCarrito() {
            if (!IS_LOGIN) {
                const car = localStorage.getItem('cmp-vsn-car');
                if (car) {
                    this.listaCarrito = JSON.parse(car);

                    this.listaCarrito=this.listaCarrito.filter(itemm=>itemm.stock?true:false).filter(itemm=>itemm.cantidad<=itemm.stock-2)
                    //console.log(this.listaCarrito)
                } else {
                    this.listaCarrito = [];
                }
                this.fun();
            } else {
                this.getUsuarioCarrito();
                console.log('aqui');
            }
        },
        getUsuarioCarrito() {
            $.ajax({
                type: "POST",
                url: "../ajax/ajs_productos.php",
                data: { tipo: 'usr_crd_lts' },
                success: function (resp) {
                    resp = JSON.parse(resp);
                    for (var i = 0; i < resp.length; i++) {
                        CARRITO._data.listaCarrito.push({
                            prod: resp[i].prod_id,
                            imagen: resp[i].imagen,
                            nombre_prod: resp[i].nombre,
                            cantidad: resp[i].cantidad,
                            stock: parseFloat(resp[i].stock),
                            precio: parseFloat(resp[i].precio + ''),
                            /*  precio_oferta: parseFloat(resp[i].precio_oferta + '') */
                        })
                    }
                    const lisTemp = CARRITO._data.listaCarrito.filter(itemm=>itemm.stock?true:false).filter(itemm=>itemm.cantidad<=itemm.stock-2)
                    CARRITO._data.listaCarrito=lisTemp
                    CARRITO._data.fun(lisTemp);
                    console.log(resp);
                }
            });

        },
        eliminarLocal() {
            localStorage.removeItem('cmp-vsn-car');
        },
        guardarCarritousr() {
            $.ajax({
                type: "POST",
                url: '../ajax/ajs_productos.php',
                data: { tipo: 'usr_crd_svd', car: JSON.stringify(this.listaCarrito) },
                success: function (resp) {
                    console.log(resp);
                }
            });

        }
    },
    computed: {
        totalCar() {
            var total = 0.00;
            for (var i = this.listaCarrito.length - 1; i >= 0; i--) {
                total += parseInt(this.listaCarrito[i].cantidad + "") * parseFloat(this.listaCarrito[i].precio + "")
            }
            return total.toFixed(2)
        },
        dataCarrito() {
            var lista = [];
            var count = 0;
            for (var i = this.listaCarrito.length - 1; i >= 0; i--) {
                if (count < 3) {
                    lista.push(this.listaCarrito[i]);
                }
                count++;
            }
            return lista
        }
    }
});


var valConst = false;
$(document).ready(function () {
    CARRITO.getDataCarrito();
    $("#botn_whapsa").hover(
        function () {
            $(".contenedor_wapsa").attr("style", "display: block")
        }, function () {
            setTimeout(function () {
                if (!valConst) {
                    $(".contenedor_wapsa").attr("style", "display: none")
                }
            }, 100)

        }
    );
    $(".contenedor_wapsa").hover(
        function () {
            valConst = true;
        }, function () {
            valConst = false;
            $(".contenedor_wapsa").attr("style", "display: none")
        }
    );
    $("#botn_telegram").hover(
        function () {
            $(".contenedor_telegram").attr("style", "display: block")
        }, function () {
            setTimeout(function () {
                if (!valConst) {
                    $(".contenedor_telegram").attr("style", "display: none")
                }
            }, 100)

        }
    );
    $(".contenedor_telegram").hover(
        function () {
            valConst = true;
        }, function () {
            valConst = false;
            $(".contenedor_telegram").attr("style", "display: none")
        }
    );

});






function alertError(title, msg) {

    return Swal.fire({
        icon: 'error',
        title: title,
        text: msg,
    })
}
function alertExito(title, msg) {
    return Swal.fire({
        icon: 'success',
        title: title,
        text: msg,
    })
}
function alertAdvertencia(title, msg) {
    return Swal.fire({
        icon: 'warning',
        title: title,
        text: msg,
    })
}
function alertInfo(title, msg) {
    return Swal.fire({
        icon: 'info',
        title: title,
        text: msg,
    })
}
