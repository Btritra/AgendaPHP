<?php
include_once("modelo\Usuario.php");
session_start();
$sErr = "";
$sNom = "";
$sTipo = "";
$oUsu = new Usuario();

if (isset($_SESSION["usu"])) {
	$oUsu = $_SESSION["usu"];
	$sNom = $oUsu->getNombre();
	$sTipo = $_SESSION["tipo"];
} else
	$sErr = "Debe estar firmado";

if ($sErr == "") {
	include_once("cabecera.html");
	include_once("menu.html");
} else {
	header("Location: error.php?sErr=" . $sErr);
	exit();
}
?>
<div class="palSide">
	<?php

	include_once("aside.html");

	?>
	<main style="flex: 7;">
		<section>

			<div class="hola">
				<h1>Bienvenido <?php echo $sNom; ?></h1>
				<br>
				<h3>Eres tipo <?php echo $sTipo; ?></h3>
			</div>

		</section>
	</main>
</div>
<?php
include_once("pie.html");
?>