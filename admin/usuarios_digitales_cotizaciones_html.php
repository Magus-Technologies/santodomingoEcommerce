<?php
    session_start();

    require "../utils/Tools.php";
    require "../dao/ProductoDao.php";
    require_once "../utils/Conexion.php";

    $conexion = (new Conexion())->getConexion();
    $tools = new Tools();

    $dataConf = $tools->getConfiguracion();
    $idusuario = $_GET['idusuario'] ?? 0;
    $idusuario = intval($idusuario);

    $fechaDesde = $_GET['fechaDesde'] ?? date('Y-m-d');
    $fechaHasta = $_GET['fechaHasta'] ?? date('Y-m-d');
    if (!strtotime($fechaDesde)) {
        $fechaDesde = date('Y-m-d');
    }
    if (!strtotime($fechaHasta)) {
        $fechaHasta = date('Y-m-d');
    }
    $q = $_GET['search']['value'] ?? '';
    $q = onlyTrim(strtolower($q));


    $busqueda = '';
    if (onlyTrim($q) != ''):
        $busqueda = " AND (a.dni_ruc LIKE '%$q%' OR a.email LIKE '%$q%' OR a.serie_cotizacion LIKE '%$q%')";
    endif;

    $where = '';
    if ($_SESSION['idrol'] == 1) {
        $where .= " WHERE ";
        if ($idusuario > 0) {
            $where .= " AND b.use_id = $idusuario ";
        }
        if ($fechaDesde && $fechaHasta) {
            $where .= " AND DATE(a.fecha_create) BETWEEN '$fechaDesde' AND '$fechaHasta' ";
        }
        $sql = "SELECT a.*, b.nombres AS vendedor 
            FROM cotizaciones a 
            LEFT JOIN usuarios b ON a.idusuario = b.use_id 
            $where $busqueda
            ORDER BY a.fecha_create ASC";
    } else {
        $where .= " WHERE a.idusuario = " . $_SESSION['usuario'];
        if ($fechaDesde && $fechaHasta) {
            $where .= " AND DATE(a.fecha_create) BETWEEN '$fechaDesde' AND '$fechaHasta' ";
        }
        $sql = "SELECT a.*, b.nombres AS vendedor 
            FROM cotizaciones a 
            LEFT JOIN usuarios b ON a.idusuario = b.use_id 
            $where $busqueda
            ORDER BY a.fecha_create ASC";
    }
    $sql = onlyReduceToOneSpace($sql);
    $sql = str_replace(['WHERE AND', 'AND AND'], ['WHERE', 'AND'], $sql);

    #console($sql);
    $result = $conexion->query($sql);
    $result = $result->fetch_all(MYSQLI_ASSOC);

    $data = []; // Arreglo para almacenar los datos

    $datos_result = [];
    foreach ($result as $row_ped) {
        $datos_result[] = $row_ped;
        $item = [];
        $item[] = $row_ped['id'];
        if ($_SESSION['idrol'] == 1) {
            $item[] = $row_ped['vendedor'];
        }
        $item[] = $row_ped['nombres'];
        $item[] = $row_ped['fecha_create'];
        $item[] = 'S/. ' . money($row_ped['suma_pedido_soles']);
        $item[] = 'S/. ' . money($row_ped['total_comisiones_ganancia']);
        $item[] = $row_ped['tipo_cambio'];
        $item[] = $row_ped['serie_cotizacion'];
        $item[] = $row_ped['telefono'] . ' | <a href="https://api.whatsapp.com/send?phone=51' . $row_ped['telefono'] . '&text=' . urlencode('Buen día, generé una cotización para usted; N: ' . $row_ped['serie_cotizacion']) . '" title="Escríbele al Cliente" target="_blank" rel="nofollow"><b style="font-weight: bold; font-size: 20px; color: green;" onmouseout="this.style.color=\'green\'" onmouseover="this.style.color=\'red\'"><i class="fab fa-whatsapp"></i></b></a>';
        switch ($row_ped['estado_cotizacion']) {
            case 0:
                $item[] = '<span class="badge badge-primary">Pendiente</span>';
                break;
            case 1:
                $item[] = '<span class="badge badge-warning">En proceso</span>';
                break;
            case 2:
                $item[] = '<span class="badge badge-success">Aprobado</span>';
                break;
            case 3:
                $item[] = '<span class="badge badge-danger">Rechazado</span>';
                break;
            default:
                $item[] = '';
        }
        // Opciones
        $opciones = '';
        #$opciones = '<a href="usuarios_digitales_cotizacion_editar.php?pd=' . $row_ped['id'] . '" class="btn btn-primary"><i class="fa fa-eye"></i></a>';
        $opciones .= '<a class="btn btn-success" id="btnDescargarPedidos" target="_blank" href="../admin/lista_pedidos_cotizaciones.php/' . $row_ped['id'] . '?comprador=true"><i class="fa fa-download"></i><i style="margin-left: 5px !important;" class="fa fa-user"></i></a>';
        if ($_SESSION['idrol'] == 1) {
            $opciones .= '<a class="btn btn-success" id="btnDescargarPedidos" target="_blank" href="../admin/lista_pedidos_cotizaciones.php/' . $row_ped['id'] . '"><i class="fa fa-download"></i></a>';
            $opciones .= '<a class="btn btn-success-2 gestionar" target="_blank" data-toggle="modal" data-target="#modal-new-banner" data-id="' . $row_ped['id'] . '"><i class="fa fa-check"></i></a>';
        } elseif ($_SESSION['idrol'] == 2 || $_SESSION['idrol'] == 3) {
            $opciones .= '<a class="btn btn-success" id="btnDescargarPedidos" target="_blank" href="../admin/lista_pedidos_cotizaciones.php/' . $row_ped['id'] . '"><i class="fa fa-download"></i></a>';
        }
        $item[] = $opciones;

        $data[] = $item;
    }
    // Convertir el arreglo a JSON
    echo json_encode([
        'data' => $data,
        "recordsTotal" => count($data),
        "recordsFiltered" => 4,
        "ingreso_comisiones" => round(array_sum(array_column($datos_result, 'total_comisiones')), 2),
        "ingreso_comisiones_extra" => round(array_sum(array_column($datos_result, 'total_comisiones_extra')), 2),
        "ingreso_suma_comisones" => round(array_sum(array_column($datos_result, 'total_comisiones_ganancia')), 2)
    ]);
?>
