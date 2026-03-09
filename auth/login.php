<?php
    require "../dao/UsuarioDao.php";
    $usuarioDao = new UsuarioDao();

    $dataAdmin = "admin@gmail.com";

    if (isset($_POST['vr'])) {
        $usuario = $_POST['user'];
        $clave = $_POST['clave'];

        $listaCrrito = isset($_POST['carrito']) ? json_decode($_POST['carrito'], true) : [];

        $usuarioDao->setEmail($usuario);
        $usuarioDao->setClave($clave);
        $res = $usuarioDao->validar();
        $respuesta = [];
        if ($row = $res->fetch_assoc()) {
            if ($row['clave'] == $clave) {
                if (count($listaCrrito) > 0) {
                    $sql = "DELETE FROM carrito_compra WHERE usuario_id = '{$row['use_id']}';";
                    $usuarioDao->exeSQL($sql);
                    foreach ($listaCrrito as $car) {
                        $sql = "INSERT INTO carrito_compra SET usuario_id='{$row['use_id']}',prod_id='{$car['prod']}',cantidad='{$car['cantidad']}'";
                        $usuarioDao->exeSQL($sql);
                    }

                }
                $respuesta['res'] = true;
                $respuesta['msg'] = "";
            } else {
                $respuesta['res'] = false;
                $respuesta['msg'] = "Clave incorrecta";
            }
        } else {
            $respuesta['res'] = false;
            $respuesta['msg'] = "Email no registrado";

        }
        echo json_encode($respuesta);
    } else {
        session_start();

        $usuario = $_POST['user'];
        $clave = $_POST['clave'];
        $usuarioDao->setEmail($usuario);
        $usuarioDao->setClave($clave);
        $res = $usuarioDao->validar();
        $respuesta = [];
        if ($row = $res->fetch_assoc()) {
            if ($row['clave'] == $clave) {
                $_SESSION['usuario'] = $row['use_id'];
                $_SESSION['perfil'] = $row['perfil'];
                $_SESSION['nombres'] = $row['nombres'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['idrol'] = $row['idrol'];

                if ('admin' == $row['perfil']) {
                    header("Location: ../admin/");
                } elseif ('vendedor' == $row['perfil']) {
                    header("Location: ../admin/pedidos.php");
                } elseif ('usuarios digital' == $row['perfil']) {
                    header("Location: ../admin/usuarios_digitales_cotizaciones.php");
                } else {
                    if (isset($_POST['ruta'])) {
                        $ruta = $_POST['ruta'];
                        if ($ruta == 'checkout') {
                            header("Location: ../CYM/checkout.php");
                        } elseif ($ruta == 'index') {
                            header("Location: ../");
                        }
                    } else {
                        header("Location: ../");
                    }
                }

            } else {
                header("Location: ../");
            }
        } else {
            header("Location: ../");
        }
//echo "login";
    }