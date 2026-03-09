<?php


class NuevoImgreso
{
    private $id;
    private $prod_id;
    private $nuevo;
    private $orden;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getProdId()
    {
        return $this->prod_id;
    }

    /**
     * @param mixed $prod_id
     */
    public function setProdId($prod_id)
    {
        $this->prod_id = $prod_id;
    }

    /**
     * @return mixed
     */
    public function getNuevo()
    {
        return $this->nuevo;
    }

    /**
     * @param mixed $nuevo
     */
    public function setNuevo($nuevo)
    {
        $this->nuevo = $nuevo;
    }

    /**
     * @return mixed
     */
    public function getOrden()
    {
        return $this->orden;
    }

    /**
     * @param mixed $orden
     */
    public function setOrden($orden)
    {
        $this->orden = $orden;
    }




}