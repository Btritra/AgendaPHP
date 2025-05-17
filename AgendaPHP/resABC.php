<?php
include_once("modelo\Contacto.php");
include_once("modelo\Usuario.php");

session_start();

$sErr = "";
$sOpe = "";
$sCve = "";
$oContacto = new Contacto();

if (isset($_SESSION["usu"]) && !empty($_SESSION["usu"]) && is_object($_SESSION["usu"])) {

    if (
        isset($_POST["txtClave"]) && !empty($_POST["txtClave"]) &&
        isset($_POST["txtOpe"]) && !empty($_POST["txtOpe"])
    ) {

        $sOpe = $_POST["txtOpe"];
        $sCve = $_POST["txtClave"];
        $oContacto->setIdContacto($sCve);

        if ($sOpe != "b") {
            if (
                isset($_POST["txtNombre"], $_POST["txtDireccion"], $_POST["txtTelefono"], $_POST["txtEmail"])
            ) {
                $oContacto->setNombre(trim($_POST["txtNombre"]));
                $oContacto->setDireccion(trim($_POST["txtDireccion"]));
                $oContacto->setTelefono(trim($_POST["txtTelefono"]));
                $oContacto->setEmail(trim($_POST["txtEmail"]));
                if ($_SESSION["tipo"] === "Administrador") {
                    $oContacto->setPerteneceA((int) trim($_POST["txtPertenece"]));
                } else {
                    $oContacto->setPerteneceA($_SESSION["usu"]->getIdUsu());
                }
            } else {
                $sErr = "Faltan datos del contacto";
            }
        }

        if ($sErr == "") {

            try {
                if ($sOpe == 'a') {
                    $nResultado = $oContacto->insertar();
                } elseif ($sOpe == 'b') {
                    $nResultado = $oContacto->borrar();
                } else {
                    $nResultado = $oContacto->modificar();
                }

                if ($nResultado != 1) {
                    $sErr = "Error en base de datos, no se afectó ningún registro.";
                }
            } catch (Exception $e) {

                error_log($e->getFile() . " " . $e->getLine() . " " . $e->getMessage(), 0);
                $sErr = "Error en base de datos, comuníquese con el administrador";
            }
        }

    } else {
        $sErr = "Faltan datos necesarios para la operación";
    }

} else {
    $sErr = "Falta establecer el login";
}


if ($sErr == "") {
    header("Location: mostrar.php");
} else {
    header("Location: error.php?sError=" . urlencode($sErr));
}
exit();
?>