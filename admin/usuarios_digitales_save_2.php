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
            $objetoPost->$clave = $valor;
        }

        $objetoPost->idusuario = $_SESSION['usuario'];

        $tasaCambioApi = new TasaCambioApi();
        $cambio = $tasaCambioApi->getTasaCambio();
        $objetoPost->tipo_cambio = $cambio['cambio'] ?? 0;
        $objetoPost->fecha_inicio = date('Y-m-d');
        $objetoPost->fecha_vencimiento = date('Y-m-d', strtotime(date('Y-m-d') . ' + 10 days'));


        $cantidad_total = 0;
        $subtotal = 0;

        $comision_subtotal = 0;


        foreach ($_POST['ids'] as $clave => $valor) {
            $cantidad = $_POST['cantidad'][$clave];
            $cantidad_total = $cantidad_total + $cantidad;

            $sql = "SELECT * FROM producto WHERE prod_id = $valor ";
            $result = $conexion->query($sql);
            $registro = $result->fetch_assoc();
            $subtotal = $subtotal + ($cantidad * $registro['precio_prod']);
            $comision_subtotal = $comision_subtotal + (($cantidad * $registro['precio_prod']) * 1.2);
        }

        $igv = 0;
        $comision_igv = 0;
        $total = $subtotal;
        $comision_total = $comision_subtotal;

        if ($objetoPost->aplica_igv == 1):
            $igv = $subtotal * 0.18;
            $total = $subtotal * 1.18;

            $comision_igv = $comision_subtotal * 0.18;
            $comision_total = $comision_subtotal * 1.18;
        endif;


        $sql = "INSERT INTO cotizaciones SET
                            tipo_cambio='$objetoPost->tipo_cambio',
                            idusuario='$objetoPost->idusuario',
                            dni_ruc='$objetoPost->dni_ruc',
                            nombres='$objetoPost->nombres',
                            direccion='$objetoPost->direccion',
                            telefono='$objetoPost->telefono',
                            email='$objetoPost->email',
                            moneda='',
                            idadmin='',
                            notas='$objetoPost->notas',
                            total_items='$cantidad_total',
                            aplica_igv='$objetoPost->aplica_igv',
                            subtotal='$subtotal',
                            igv='$igv',
                            total='$total',
                            
                            usd_subtotal='" . round($subtotal / $objetoPost->tipo_cambio, 2) . "',
                            usd_igv='" . round($igv / $objetoPost->tipo_cambio, 2) . "',
                            usd_total='" . round($total / $objetoPost->tipo_cambio, 2) . "',
                            
                            comision_subtotal='$comision_subtotal',
                            comision_igv='$comision_igv',
                            comision_total='$comision_total',
                            
                            comision_usd_subtotal='" . round($comision_subtotal / $objetoPost->tipo_cambio, 2) . "',
                            comision_usd_igv='" . round($comision_igv / $objetoPost->tipo_cambio, 2) . "',
                            comision_usd_total='" . round($comision_total / $objetoPost->tipo_cambio, 2) . "',
                            
                            fecha_inicio='$objetoPost->fecha_inicio',
                            fecha_vencimiento='$objetoPost->fecha_vencimiento'
                            ";
        console($sql);
        die();
        $result = $conexion->query($sql);
        $id_insertado = $conexion->insert_id;

        foreach ($_POST['ids'] as $clave => $valor) {
            $sql = "SELECT * FROM producto WHERE prod_id = $valor ";
            $result = $conexion->query($sql);
            $registro = $result->fetch_assoc();
            $precio = $registro['precio_prod'];
            $cantidad = $_POST['cantidad'][$clave];

            $subtotal = $precio * $cantidad;
            $comicion = $subtotal * 0.2;
            $total = $subtotal * 1.2;
            $sql = "INSERT INTO cotizaciones_items SET   
                                                    idcotizacion = '$id_insertado',
                                                    idproducto  = '$valor',
                                                    precio_prod = '$precio',
                                                    cantidad  = '$cantidad',
                                                    subtotal  = '$subtotal',
                                                    comicion  = '0.2',
                                                    mi_comision  = '$comicion',
                                                    total  = '$total'";
            $conexion->query($sql);
        }

        $sql = "SELECT * FROM cotizaciones_documento";
        $result = $conexion->query($sql);
        $cotizaciones_documento = $result->fetch_assoc();
        $serie = $cotizaciones_documento['prefijo'] . '-' . $cotizaciones_documento['serie'];
        $sql = "UPDATE cotizaciones SET serie_cotizacion = '$serie' WHERE id = '$id_insertado'";
        #console($sql);
        $conexion->query($sql);

        $sql = "UPDATE cotizaciones_documento SET serie = LPAD(serie+1, 7, '0')";
        #console($sql);
        $conexion->query($sql);
    } else {
        header("Location: ../CYM/");
    }
?>