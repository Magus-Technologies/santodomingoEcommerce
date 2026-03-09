<?php
    session_start();


    require "../dao/Session.php";
    require "../utils/Tools.php";
    require_once "../extra/TasaCambioApi.php";
    require_once "../utils/Conexion.php";

    $sessionModel = new Session;
    $validate = $sessionModel->validateSession();

    if ($validate['perfil'] == 'usuarios digital' or $validate['perfil'] == 'admin') {
        $conexion = (new Conexion())->getConexion();
        $objetoPost = new stdClass();


        foreach ($_POST as $clave => $valor) {
            $_POST[$clave] = str_replace(['S/. ', '$/. '], ['', ''], $valor);
        }


        foreach ($_POST as $clave => $valor) {
            $objetoPost->$clave = $valor;
        }

        $objetoPost->idusuario = $_SESSION['usuario'];

        $tasaCambioApi = new TasaCambioApi();
        $cambio = $tasaCambioApi->getTasaCambio();
        $objetoPost->tipo_cambio = $cambio['cambio'] ?? 0;
        $objetoPost->fecha_inicio = date('Y-m-d');
        $objetoPost->fecha_vencimiento = date('Y-m-d', strtotime(date('Y-m-d') . ' + 10 days'));
        $objetoPost->cantidad_total = array_sum($_POST['cantidad']);

        $objetoPost->igv = $objetoPost->aplica_igv == 1 ? ($objetoPost->total_pagar * 0.18) : 0;

        console($_POST);
        console($objetoPost);


        $sql = "INSERT INTO cotizaciones SET
                            tipo_cambio='$objetoPost->tipo_cambio',
                            idusuario='$objetoPost->idusuario',
                            dni_ruc='$objetoPost->dni_ruc',
                            nombres='$objetoPost->nombres',
                            direccion='$objetoPost->direccion',
                            telefono='$objetoPost->telefono',
                            email='$objetoPost->email',
                            idadmin='5',
                            notas='$objetoPost->notas',
                            total_items='$objetoPost->cantidad_total',
                            aplica_igv='$objetoPost->aplica_igv',
                            total_comisiones=$objetoPost->total_comisiones,
                            total_comisiones_extra=$objetoPost->total_comisiones_extra,
                            total_comisiones_ganancia=$objetoPost->total_comisiones_ganancia,
                            total_pagar=$objetoPost->total_pagar,
                            total_pagar_usd=$objetoPost->total_pagar_usd,
                            igv='$objetoPost->igv',
                            suma_pedido_soles=$objetoPost->suma_pedido_soles,
                            suma_pedido_usd=$objetoPost->suma_pedido_usd,
                            fecha_inicio='$objetoPost->fecha_inicio',
                            fecha_vencimiento='$objetoPost->fecha_vencimiento'
                            ";
        console($sql);
        $result = $conexion->query($sql);
        $id_insertado = $conexion->insert_id;

        #$id_insertado = 49;

        foreach ($_POST['ids'] as $clave => $valor) {
            $cantidad = $_POST['cantidad'][$clave];

            $mi_comision = $_POST['mi_comision'][$clave];
            $mi_comision_extra = $_POST['mi_comision_extra'][$clave];
            $mi_ganancia = $_POST['mi_ganancia'][$clave];


            $produc_precio = $_POST["produc_precio"][$clave];
            $produc_total_venta = $_POST["produc_total_venta"][$clave];

            $otro_produc_precio = $_POST["otro_produc_precio"][$clave];
            $otro_produc_total_venta = $_POST["otro_produc_total_venta"][$clave];


            $igv = $objetoPost->aplica_igv == 1 ? ($otro_produc_total_venta * 0.18) : 0;

            $sql = "INSERT INTO cotizaciones_items SET   
                                                    idcotizacion = '$id_insertado',
                                                    idproducto  = '$valor',
                                                    cantidad  = '$cantidad',
                                                    comicion  = '0.05',
                                                    
                                                    
                                                    mi_comision = '$mi_comision',
                                                    mi_comision_extra = '$mi_comision_extra',
                                                    mi_ganancia = '$mi_ganancia',
                                                    
                                                    
                                                    produc_precio=$produc_precio,
                                                    produc_total_venta=$produc_total_venta,
                                                    
                                                    igv = $igv,
                                                    otro_produc_precio = $otro_produc_precio,
                                                    otro_produc_total_venta = $otro_produc_total_venta
                                                                                ";
            #$sql = "INSERT INTO cotizaciones_items SET
            #                                        idcotizacion = '$id_insertado',
            #                                        idproducto  = '$valor',
            #                                        precio_prod = '$precio',
            #                                        cantidad  = '$cantidad',
            #                                        subtotal  = '$subtotal',
            #                                        comicion  = '0.2',
            #                                        mi_comision  = '$comicion',
            #                                        total  = '$total'";

            console($sql);

            $conexion->query($sql);
        }

        $sql = "SELECT * FROM cotizaciones_documento";
        $result = $conexion->query($sql);
        $cotizaciones_documento = $result->fetch_assoc();
        $serie = $cotizaciones_documento['prefijo'] . '-' . $cotizaciones_documento['serie'];
        $sql = "UPDATE cotizaciones SET serie_cotizacion = '$serie' WHERE id = '$id_insertado'";
        $conexion->query($sql);

        $sql = "UPDATE cotizaciones_documento SET serie = LPAD(serie+1, 7, '0')";
        $conexion->query($sql);

    } else {
        header("Location: ../CYM/");
    }
?>