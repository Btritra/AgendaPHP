<?php
include_once("cabecera.html");
?>
<div class="palSide">
	<?php

	include_once("aside.html");

	?>
	<main style="flex: 7;">
		<section>
			<div class="centrado">
				<form id="frm" method="post" action="login.php">
					<div class="form-group">
						<label>Nombre</label> <input type="text" name="txtCve" required="true" />
						<br />
						<label>Contrase&ntilde;a </label><input type="password" name="txtPwd" required="true" />
						<br />
						<input class="boton" type="submit" value="Enviar" />
					</div>
				</form>
			</div>
		</section>
	</main>
</div>
<?php
include_once("pie.html");
?>