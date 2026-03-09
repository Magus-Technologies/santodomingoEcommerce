<?php


class Usuario
{
    private $use_id;
    private $nombres;
    private $email;
    private $clave;

    /**
     * @return mixed
     */
    public function getUseId()
    {
        return $this->use_id;
    }

    /**
     * @param mixed $use_id
     */
    public function setUseId($use_id)
    {
        $this->use_id = $use_id;
    }

    /**
     * @return mixed
     */
    public function getNombres()
    {
        return $this->nombres;
    }

    /**
     * @param mixed $nombres
     */
    public function setNombres($nombres)
    {
        $this->nombres = $nombres;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getClave()
    {
        return $this->clave;
    }

    /**
     * @param mixed $clave
     */
    public function setClave($clave)
    {
        $this->clave = $clave;
    }

}