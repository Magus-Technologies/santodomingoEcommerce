const APP = new Vue({
    el: '#contenedor-vue',
    data: {
        dat: {
            nombre: '',
            apellido: '',
            num_doc: '',
            celular: '',
            email: '',
            notas: '',
            productos: []
        },
        npasword: '',
        lista_pedidos: [],
        lista_comras: [],
        lista_comras22: [],
    },
    methods: {
        importe_prodd(cnt, prec) {
            return (parseFloat(cnt) * parseFloat(prec)).toFixed(2);
        },
        formatNumeberDecimal(num) {
            return parseFloat(num + '').toFixed(2);
        },
        getPedidosData(pedido) {
            $.ajax({
                type: "POST",
                url: "../ajax/ajs_consulta.php",
                data: { tipo: 'data-pdds-user', pedido },
                success: function(resp) {
                    resp = JSON.parse(resp);
                    if (resp.res) {
                        APP._data.dat.apellido = resp.data.apellido;
                        APP._data.dat.celular  = resp.data.celular;
                        APP._data.dat.email    = resp.data.email;
                        APP._data.dat.nombre   = resp.data.nombre;
                        APP._data.dat.notas    = resp.data.notas;
                        APP._data.dat.num_doc  = resp.data.nun_doc;
                        APP._data.dat.productos = resp.data.productos;
                    }
                }
            });
        },
        getListaPedidos() {
            $.ajax({
                type: "POST",
                url: "../ajax/ajs_consulta.php",
                data: { tipo: 'lts-pdds-user' },
                success: function(resp) {
                    resp = JSON.parse(resp);
                    resp = resp.reverse();
                    APP._data.lista_comras22 = resp;
                    APP._data.lista_pedidos  = resp;
                }
            });
        },
        getListaCompras() {
            $.ajax({
                type: "POST",
                url: "../ajax/ajs_consulta.php",
                data: { tipo: 'lts-comp-user' },
                success: function(resp) {
                    resp = JSON.parse(resp);
                    APP._data.lista_comras = resp.reverse();
                }
            });
        },
        cambiar_pass() {
            $.ajax({
                type: "POST",
                url: "../ajax/ajs_consulta.php",
                data: { tipo: 'chg-pass-user', npss: this.npasword },
                success: function(resp) {
                    resp = JSON.parse(resp);
                    if (resp.res) {
                        APP._data.npasword = '';
                        alertExito("Contraseña cambiada", "");
                    } else {
                        alertAdvertencia("Alerta", "No se pudo cambiar la contraseña");
                    }
                }
            });
        },
        estador(est) {
            switch (est) {
                case "1": return 'Preparando';
                case "2": return 'Enviado';
                case "3": return 'Recibido';
                case "4": return 'Vendido';
            }
        },
    },
    computed: {
        total_productos() {
            return (0).toFixed(2);
        }
    }
});

$(document).ready(function() {
    APP.getListaPedidos();
    APP.getListaCompras();

    $('#solicitar_vip').submit(function(e) {
        e.preventDefault();
        if ($('#usupermi').val() !== '') {
            $.ajax({
                type: "POST",
                url: "../ajax/ajs_consulta.php",
                data: { tipo: 'chg-vip-user', name: $('#usupermi').val() },
                success: function(resp) {
                    resp = JSON.parse(resp);
                    if (resp.res) {
                        alertExito("Solicitud exitosa, este cambio se vera reflejado cuando el administrador acepte la solicitud", "");
                    } else {
                        alertAdvertencia("Alerta", "No se realizar la solicitud");
                    }
                }
            });
        } else {
            alertAdvertencia("Alerta", "No puede dejar el nombre en blanco");
        }
    });

    $('#cambiar_nombre').submit(function(e) {
        e.preventDefault();
        if ($('#cambiarName').val() !== '') {
            $.ajax({
                type: "POST",
                url: "../ajax/ajs_consulta.php",
                data: { tipo: 'chg-name-user', name: $('#cambiarName').val() },
                success: function(resp) {
                    resp = JSON.parse(resp);
                    if (resp.res) {
                        alertExito("Cambio exitoso, este cambio se verá reflejado cuando vuelva a iniciar sesion", "");
                    } else {
                        alertAdvertencia("Alerta", "No se pudo cambiar el nombre");
                    }
                }
            });
        } else {
            alertAdvertencia("Alerta", "No puede dejar el nombre en blanco");
        }
    });
});
