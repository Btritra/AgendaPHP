<?php
include_once("modelo\Usuario.php");
include_once("modelo\Contacto.php");
session_start();

$sErr = "";
$sOpe = "";
$sCve = "";
$sNomBoton = "Borrar";
$oContacto = new Contacto();
$bCampoEditable = false;
$bLlaveEditable = false;

if (isset($_SESSION["usu"]) && !empty($_SESSION["usu"])) {
	if (
		isset($_POST["txtClave"]) && !empty($_POST["txtClave"]) &&
		isset($_POST["txtOpe"]) && !empty($_POST["txtOpe"])
	) {
		$sOpe = $_POST["txtOpe"];
		$sCve = $_POST["txtClave"];
		if ($sOpe != 'a') {
			$oContacto->setIdContacto($sCve);
			try {
				if (!$oContacto->buscar()) {
					$sErr = "El contacto no existe";
				}
			} catch (Exception $e) {
				error_log($e->getFile() . " " . $e->getLine() . " " . $e->getMessage(), 0);
				$sErr = "Error en base de datos, comunicarse con el administrador";
			}
		}
		if ($sOpe == 'a') {
			$bCampoEditable = true;
			$bLlaveEditable = true;
			$sNomBoton = "Agregar";
		} else if ($sOpe == 'm') {
			$bCampoEditable = true;
			$sNomBoton = "Modificar";
		}
	} else {
		$sErr = "Faltan datos";
	}
} else
	$sErr = "Falta establecer el login";

if ($sErr == "") {
	include_once("cabecera.html");
	include_once("menu.html");
} else {
	header("Location: error.php?sError=" . $sErr);
	exit();
}
?>
<div class="palSide">
	<?php

	include_once("aside.html");

	?>
	<main style="flex: 7;">
		<section>
			<div class="centrado">
				<div class="form-group">
				<form name="abcPH" action="resABC.php" method="post">
					<input type="hidden" name="txtOpe" value="<?php echo $sOpe; ?>">
					<input type="hidden" name="txtClave" value="<?php echo $sCve; ?>" />
					<label>Nombre</label>
					<input type="text" name="txtNombre" <?php echo ($bCampoEditable == true ? '' : ' disabled '); ?>
						value="<?php echo $oContacto->getNombre(); ?>" />
					<br />
					<label>Direccion</label>
					<input type="text" name="txtDireccion" <?php echo ($bCampoEditable == true ? '' : ' disabled '); ?>
						value="<?php echo $oContacto->getDireccion(); ?>" />
					<br />
					<label>Telefono</label>
					<input type="text" name="txtTelefono" <?php echo ($bCampoEditable == true ? '' : ' disabled '); ?>
						value="<?php echo $oContacto->getTelefono(); ?>" />
					<br />
					<label>Email</label>
					<input type="text" name="txtEmail" <?php echo ($bCampoEditable == true ? '' : ' disabled '); ?>
						value="<?php echo $oContacto->getEmail(); ?>" />
					<br />
					<?php if ($_SESSION["tipo"] === "Administrador"): ?>
						<label>id de Usuario al que pertenece</label>
						<input type="number" name="txtPertenece" <?php echo ($bCampoEditable == true ? '' : ' disabled '); ?>
							value="<?php echo $oContacto->getPerteneceA(); ?>" />
					<?php endif; ?>

					<br />
					<input class="boton" type="button" id="btnEnviar" value="<?php echo $sNomBoton; ?>" />

					<input class="boton" type="submit" name="Submit" value="Cancelar"
						onClick="abcPH.action='mostrar.php';">
				</form>
				</div>
			</div>
		</section>
	</main>
</div>
<script src="script.js"></script>
<?php
include_once("pie.html");
?>