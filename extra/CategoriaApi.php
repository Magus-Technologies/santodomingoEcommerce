<?php
require_once "../utils/Conexion.php";

class CategoriaApi
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = (new Conexion())->getConexion();
    }

    /**
     * Obtiene el listado de categorías activas desde la BD del sistema de facturación.
     *
     * Fuente: factura_santoD.categorias (Laravel - facturacion_santoDomingo)
     * Endpoint equivalente: GET http://localhost:8000/api/categorias (requiere auth:sanctum)
     * Se conecta directo a BD para evitar dependencia del servidor Laravel.
     *
     * Retorna array con claves cod_sub1 (id) y nom_sub1 (nombre),
     * compatibles con el dropdown del panel admin/categorias.php.
     */
    public function getLista(){
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_FACTURA_NAME);
        $conn->set_charset('utf8');
        $respuesta = [];
        $res = $conn->query("SELECT id, nombre FROM categorias WHERE estado = '1' ORDER BY nombre ASC");
        if ($res) {
            while ($row = $res->fetch_assoc()) {
                $respuesta[] = [
                    'cod_sub1' => $row['id'],
                    'nom_sub1' => $row['nombre'],
                ];
            }
        }
        $conn->close();
        return $respuesta;
    }
    public function getData($codigo){
        $sql ="SELECT
  cod_sub1,
  nom_sub1
FROM sopsub1 WHERE cod_sub1 = '$codigo'";
        $resul = $this->conexion->query($sql);
        if ( $rowCat = $resul->fetch_assoc() ){

            $respuesta= $rowCat;
        }
        return $respuesta;
    }
}