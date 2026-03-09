<?php


class GrupoCategoria
{
    private $grupo_id;
    private $icono;
    private $nombre_grupo;
    private $estado;

    /**
     * @return mixed
     */
    public function getGrupoId()
    {
        return $this->grupo_id;
    }

    /**
     * @param mixed $grupo_id
     */
    public function setGrupoId($grupo_id)
    {
        $this->grupo_id = $grupo_id;
    }

    /**
     * @return mixed
     */
    public function getIcono()
    {
        return $this->icono;
    }

    /**
     * @param mixed $icono
     */
    public function setIcono($icono)
    {
        $this->icono = $icono;
    }

    /**
     * @return mixed
     */
    public function getNombreGrupo()
    {
        return $this->nombre_grupo;
    }

    /**
     * @param mixed $nombre_grupo
     */
    public function setNombreGrupo($nombre_grupo)
    {
        $this->nombre_grupo = $nombre_grupo;
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