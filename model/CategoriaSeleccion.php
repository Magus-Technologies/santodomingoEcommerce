<?php


class CategoriaSeleccion
{
    private $id_seleccion;
    private $id_grupo;
    private $codi_categoria;
    private $imagen;
    private $estado;

    /**
     * @return mixed
     */
    public function getIdSeleccion()
    {
        return $this->id_seleccion;
    }

    /**
     * @param mixed $id_seleccion
     */
    public function setIdSeleccion($id_seleccion)
    {
        $this->id_seleccion = $id_seleccion;
    }

    /**
     * @return mixed
     */
    public function getIdGrupo()
    {
        return $this->id_grupo;
    }

    /**
     * @param mixed $id_grupo
     */
    public function setIdGrupo($id_grupo)
    {
        $this->id_grupo = $id_grupo;
    }

    /**
     * @return mixed
     */
    public function getCodiCategoria()
    {
        return $this->codi_categoria;
    }

    /**
     * @param mixed $codi_categoria
     */
    public function setCodiCategoria($codi_categoria)
    {
        $this->codi_categoria = $codi_categoria;
    }

    /**
     * @return mixed
     */
    public function getImagen()
    {
        return $this->imagen;
    }

    /**
     * @param mixed $imagen
     */
    public function setImagen($imagen)
    {
        $this->imagen = $imagen;
    }

    /**
     * @return mixed
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * @param mixed $estado
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

}