<?php
include_once("modelo\Usuario.php");
include_once("modelo\Contacto.php");
session_start();
$sErr = "";
$sNom = "";
$arrContactos = null;
$oUsu = new Usuario();
$oContactos = new Contacto();

if (isset($_SESSION["usu"]) && !empty($_SESSION["usu"])) {
	$oUsu = $_SESSION["usu"];
	$sNom = $oUsu->getNombre();
	try {
		$arrContactos = $oContactos->buscarTodos();
	} catch (Exception $e) {
		
		error_log($e->getFile() . " " . $e->getLine() . " " . $e->getMessage(), 0);
		$sErr = "Error en base de datos, comunicarse con el administrador";
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
				<h3>Tabla de los contactos</h3>
			</div>
			<form name="formTablaGral" method="post" action="abcContactos.php">
				<input type="hidden" name="txtClave">
				<input type="hidden" name="txtOpe">
				<table class="tabla-estilo">
					<tr>
						<td style="display: none;">idContacto</td>
						<td>Nombre</td>
						<td>Direccion</td>
						<td>Telefono</td>
						<td>Email</td>
						<td>Opciones</td>
					</tr>
					<?php
					if ($arrContactos != null) {
						foreach ($arrContactos as $oContactos) {
							?>
							<tr>
								<td class="llave" style="display: none;"><?php echo $oContactos->getIdContacto(); ?></td>
								<td><?php echo $oContactos->getNombre(); ?></td>
								<td><?php echo $oContactos->getDireccion(); ?></td>
								<td><?php echo $oContactos->getTelefono(); ?></td>
								<td><?php echo $oContactos->getEmail(); ?></td>
								<td>
									<input type="submit" class="boton" name="Submit" value="Modificar"
										onClick="txtClave.value=<?php echo $oContactos->getIdContacto(); ?>; txtOpe.value='m'">
									<input type="submit" class="boton" name="Submit" value="Borrar"
										onClick="txtClave.value=<?php echo $oContactos->getIdContacto(); ?>; txtOpe.value='b'">
								</td>
							</tr>
							<?php
						}
					} else {
						?>
						<tr>
							<td colspan="2">No hay datos</td>
						</tr>
						<?php
					}
					?>
				</table>
				<br>
				<div class="centrado">
					<input type="submit" class="boton" name="Submit" value="Crear Nuevo"
						onClick="txtClave.value='-1';txtOpe.value='a'">
				</div>
			</form>
		</section>
	</main>
</div>
<?php
include_once("pie.html");
?>