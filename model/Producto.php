<?php

class Producto{
    private $prod_id;
    private $categoria;
    private $marca;
    private $prod_cod;
    private $descripcion;
    private $caracteristicas;
    private $estado;
    private $nombre;
    private $subCate;
    private $content1;
    private $content2;
    private $content3;
    private $precio_prod;
    private $stock_prod;
    private $tipo_pro;
    private $garantia;

    /**
     * @return mixed
     */
    public function getGarantia()
    {
        return $this->garantia;
    }

    /**
     * @param mixed $garantia
     */
    public function setGarantia($garantia)
    {
        $this->garantia = $garantia;
    }

    /**
     * @return mixed
     */
    public function getPrecioProd()
    {
        return $this->precio_prod;
    }

    /**
     * @param mixed $precio_prod
     */
    public function setPrecioProd($precio_prod)
    {
        $this->precio_prod = $precio_prod;
    }

    /**
     * @return mixed
     */
    public function getStockProd()
    {
        return $this->stock_prod;
    }

    /**
     * @param mixed $stock_prod
     */
    public function setStockProd($stock_prod)
    {
        $this->stock_prod = $stock_prod;
    }

    /**
     * @return mixed
     */
    public function getTipoPro()
    {
        return $this->tipo_pro;
    }

    /**
     * @param mixed $tipo_pro
     */
    public function setTipoPro($tipo_pro)
    {
        $this->tipo_pro = $tipo_pro;
    }

    /**
     * @return mixed
     */
    public function getContent1()
    {
        return $this->content1;
    }

    /**
     * @param mixed $content1
     */
    public function setContent1($content1)
    {
        $this->content1 = $content1;
    }

    /**
     * @return mixed
     */
    public function getContent2()
    {
        return $this->content2;
    }

    /**
     * @param mixed $content2
     */
    public function setContent2($content2)
    {
        $this->content2 = $content2;
    }

    /**
     * @return mixed
     */
    public function getContent3()
    {
        return $this->content3;
    }

    /**
     * @param mixed $content3
     */
    public function setContent3($content3)
    {
        $this->content3 = $content3;
    }

    /**
     * @return mixed
     */
    public function getSubCate()
    {
        return $this->subCate;
    }

    /**
     * @param mixed $subCate
     */
    public function setSubCate($subCate)
    {
        $this->subCate = $subCate;
    }

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
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * @param mixed $categoria
     */
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;
    }

    /**
     * @return mixed
     */
    public function getMarca()
    {
        return $this->marca;
    }

    /**
     * @param mixed $marca
     */
    public function setMarca($marca)
    {
        $this->marca = $marca;
    }

    /**
     * @return mixed
     */
    public function getCaracteristicas()
    {
        return $this->caracteristicas;
    }

    /**
     * @param mixed $caracteristicas
     */
    public function setCaracteristicas($caracteristicas)
    {
        $this->caracteristicas = $caracteristicas;
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
    public function getProdCod()
    {
        return $this->prod_cod;
    }

    /**
     * @param mixed $prod_cod
     */
    public function setProdCod($prod_cod)
    {
        $this->prod_cod = $prod_cod;
    }

    /**
     * @return mixed
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * @param mixed $descripcion
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
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