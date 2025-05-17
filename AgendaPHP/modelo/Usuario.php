<?php
include_once("AccesoDatos.php");
class Usuario
{ 
    private $idUsu = 0;
    private $Pwd = "";
    private $AD = null;
    private $nombre = "";
    private $tipo = 0;

    const TIPO_visializador = 1;
    const TIPO_aministrador = 2;

    public function getIdUsu()
    {
        return $this->idUsu;
    }

    public function getPwd()
    {
        return $this->Pwd;
    }

    public function setPwd($Pwd)
    {
        $this->Pwd = $Pwd;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function getTipo()
    {
        return $this->tipo;
    }

    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }


    public function buscarCvePwd()
    {
        $bRet = false;
        $sQuery = "";
        $arrRS = null;
        if (($this->nombre == "" || $this->Pwd == ""))
            throw new Exception("Usuario->buscar: faltan datos");
        else {
            $sQuery = "SELECT t1.idUsu, t1.tipo
                           FROM usuario t1
                           WHERE t1.nombre = '" . $this->nombre . "'
                           AND t1.password = '" . $this->Pwd . "'";
            $oAD = new AccesoDatos();
            if ($oAD->conectar()) {
                $arrRS = $oAD->ejecutarConsulta($sQuery);
                $oAD->desconectar();
                if ($arrRS != null) {
                    $this->idUsu=$arrRS[0][0];
                    $this->tipo=$arrRS[0][1];
                    $bRet = true;
                }
            }
        }
        return $bRet;
    }
}
?>