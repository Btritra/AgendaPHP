<?php
include_once("AccesoDatos.php");
include_once("Usuario.php");
class Contacto
{
    protected $idContacto = 0;
    protected $Nombre = "";
    protected $Direccion = "";
    protected $email = "";
    protected $telefono = "";
    protected $perteneceA = 0;

    public function getIdContacto()
    {
        return $this->idContacto;
    }

    public function setIdContacto($idContacto)
    {
        $this->idContacto = $idContacto;
    }
    public function getNombre()
    {
        return $this->Nombre;
    }

    public function setNombre($Nombre)
    {
        $this->Nombre = $Nombre;
    }

    public function getDireccion()
    {
        return $this->Direccion;
    }

    public function setDireccion($Direccion)
    {
        $this->Direccion = $Direccion;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getTelefono()
    {
        return $this->telefono;
    }

    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }

    public function getPerteneceA()
    {
        return $this->perteneceA;
    }

    public function setPerteneceA($perteneceA)
    {
        $this->perteneceA = $perteneceA;
    }

    function insertar()
    {
        $oAccesoDatos = new AccesoDatos();
        $sQuery = "";
        $nAfectados = -1;

        if ( $this->Nombre == "" || $this->Direccion == "" ||$this->perteneceA == 0 ) {
            throw new Exception("Faltan datos");
        } else {
            if ($oAccesoDatos->conectar()) {
                $sQuery = "INSERT INTO contactos (nombre, direccion, telefono, email, pertenece)
                       VALUES ('" . $this->Nombre . "', '" . $this->Direccion . "',
                               '" . $this->telefono . "', '" . $this->email . "', " . $this->perteneceA . ");";

                $nAfectados = $oAccesoDatos->ejecutarComando($sQuery);
                $oAccesoDatos->desconectar();
            }
        }

        return $nAfectados;
    }

    function buscar()
    {
        $oAccesoDatos = new AccesoDatos();
        $sQuery = "";
        $arrRS = null;
        $bRet = false;
        if ($this->idContacto == 0)
            throw new Exception("Faltan datos");
        else {
            if ($oAccesoDatos->conectar()) {
                $sQuery = " SELECT nombre,direccion,telefono,email,pertenece
                                FROM contactos
                                WHERE idContacto = " . $this->idContacto;
                $arrRS = $oAccesoDatos->ejecutarConsulta($sQuery);
                $oAccesoDatos->desconectar();
                if ($arrRS) {
                    $this->Nombre = $arrRS[0][0];
                    $this->Direccion = $arrRS[0][1];
                    $this->telefono = $arrRS[0][2];
                    $this->email = $arrRS[0][3];
                    $this->perteneceA = $arrRS[0][4];
                    $bRet = true;
                }
            }
        }
        return $bRet;
    }

    function modificar()
    {
        $oAccesoDatos = new AccesoDatos();
        $sQuery = "";
        $nAfectados = -1;

        if (
            $this->idContacto == 0 ||
            $this->Nombre == "" ||
            $this->Direccion == "" ||
            $this->telefono == "" ||
            $this->email == "" ||
            $this->perteneceA == 0
        ) {
            throw new Exception("Favor de insertar todos los datos");
        } else {
            if ($oAccesoDatos->conectar()) {
                $sQuery = "UPDATE contactos
                       SET nombre = '" . $this->Nombre . "',
                           direccion = '" . $this->Direccion . "',
                           telefono = '" . $this->telefono . "',
                           email = '" . $this->email . "'
                       WHERE idContacto = " . $this->idContacto . ";";

                $nAfectados = $oAccesoDatos->ejecutarComando($sQuery);
                $oAccesoDatos->desconectar();
            }
        }

        return $nAfectados;
    }

    function borrar()
    {
        $oAccesoDatos = new AccesoDatos();
        $sQuery = "";
        $nAfectados = -1;
        if ($this->idContacto == 0)
            throw new Exception("error en el borrado");
        else {
            if ($oAccesoDatos->conectar()) {
                $sQuery = "DELETE FROM contactos
                                WHERE idContacto = " . $this->idContacto;
                $nAfectados = $oAccesoDatos->ejecutarComando($sQuery);
                $oAccesoDatos->desconectar();
            }
        }
        return $nAfectados;
    }

    function buscarTodos()
    {
        $oAccesoDatos = new AccesoDatos();
        $sQuery = "";
        $arrRS = null;
        $aLinea = null;
        $j = 0;
        $contacto = null;
        $arrResultado = [];
        if ($oAccesoDatos->conectar()) {

            if ($_SESSION["tipo"] === "Visualizador") {
                $sQuery = "SELECT idContacto, nombre, direccion,
            telefono, email, pertenece
            FROM contactos
            WHERE pertenece = " . $_SESSION["usu"]->getIdUsu() . "
            ORDER BY idContacto";
                $arrRS = $oAccesoDatos->ejecutarConsulta($sQuery);
                $oAccesoDatos->desconectar();
            } else {
                $sQuery = "SELECT idContacto, nombre, direccion,
            telefono, email, pertenece
            FROM contactos
            ORDER BY idContacto";
                $arrRS = $oAccesoDatos->ejecutarConsulta($sQuery);
                $oAccesoDatos->desconectar();
            }
            if ($arrRS) {
                foreach ($arrRS as $aLinea) {
                    $contacto = new Contacto();
                    $contacto->setIdContacto($aLinea[0]);
                    $contacto->setNombre($aLinea[1]);
                    $contacto->setDireccion($aLinea[2]);
                    $contacto->setTelefono($aLinea[3]);
                    $contacto->setEmail($aLinea[4]);
                    $contacto->setPerteneceA($aLinea[5]);
                    $arrResultado[$j] = $contacto;
                    $j = $j + 1;
                }
            } else
                $arrResultado = [];
        }
        return $arrResultado;
    }

    function ultimoID()
    {
        $ultimo = null;
        $Acceso = new AccesoDatos();
        $sQuery = "";

        if ($Acceso->conectar()) {
            $sQuery = "SELECT MAX(idContacto) FROM contactos";
            $ultimo = $Acceso->ejecutarConsulta($sQuery);
            $Acceso->desconectar();
        }

        if ($ultimo) {
            return $ultimo[0][0];
        } else {
            return 0;
        }
    }

}
?>