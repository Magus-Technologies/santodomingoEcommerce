<?php

class MarcaSeleccion
{
    private $marca_id;
    private $cod_marca;
    private $nombre;
    private $imagen;

    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param mixed $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * @return mixed
     */
    public function getMarcaId()
    {
        return $this->marca_id;
    }

    /**
     * @param mixed $marca_id
     */
    public function setMarcaId($marca_id)
    {
        $this->marca_id = $marca_id;
    }

    /**
     * @return mixed
     */
    public function getCodMarca()
    {
        return $this->cod_marca;
    }

    /**
     * @param mixed $cod_marca
     */
    public function setCodMarca($cod_marca)
    {
        $this->cod_marca = $cod_marca;
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


}