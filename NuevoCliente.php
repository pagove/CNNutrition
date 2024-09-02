<?php
session_start();
?>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width-scale=1">
	<link rel="stylesheet" href="/css/estilos.css">
	<title>&nbsp;</title>
</head>

<body>
	<?php
	if ($_SESSION['mensaje'] != "") {
		$mostrarM = $_SESSION['mensaje'];
		if ($_SESSION['error'] != "") {
	?>
			<div class="alert alert-danger" role="alert">
				<?php
				echo $mostrarM;
				?>
			</div>
		<?php
		} else {
		?>
			<div class="alert alert-success" role="alert">
				<?php
				echo $mostrarM;
				?>
			</div>
	<?php
		}
		$_SESSION['mensaje'] = "";
		$_SESSION['ventana'] = "";
	}
	?>
	<div class="container marginTop30">
		<form onsubmit="ProcesarForm(this, '/phpForms/NuevoClienteForm.php', 'cuerpo'); return false" method="post">
			<div class="row">
				<div class="col-md-4">
					<label for="validationDefault01" class="form-label">Nombre</label>
					<input type="text" class="form-control" name="nombre" id="validationDefault01" placeholder="Mark" required>
				</div>
				<div class="col-md-4">
					<label for="validationDefault02" class="form-label">Primer Apellido</label>
					<input type="text" class="form-control" id="validationDefault02" name="apellido1" placeholder="Otto" required>
				</div>
				<div class="col-md-4">
					<label for="validationDefault02" class="form-label">Segundo Apellido</label>
					<input type="text" class="form-control" id="validationDefault02" name="apellido2" placeholder="Obama" required>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<label for="validationDefaultUsername" class="form-label">Correo electrónico</label>
					<div class="input-group">
						<input type="email" class="form-control" id="validationDefaultUsername" name="email" aria-describedby="inputGroupPrepend2" placeholder="example@gmail.com" required>
					</div>
				</div>
				<div class="col-md-4">
					<label for="validationDefault03" class="form-label">Móvil</label>
					<input type="number" class="form-control" id="validationDefault03" name="tel" placeholder="xxxxxxxxx" required>
				</div>
				<div class="col-md-4">
					<label for="fechaNac">Fecha nacimiento:</label>
					<input type="date" class="form-control" id="fechaNac" name="fechaNac">
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<label for="validationDefault04" class="form-label">Sexo</label>
					<select class="form-select" id="validationDefault04" name="sexo" required>
						<option selected>Hombre</option>
						<option>Mujer</option>
					</select>
				</div>
				<div class="col-md-4">
					<label for="validationDefault05" class="form-label">Altura (m)</label>
					<input type="number" step="0.01" value="1.50" class="form-control" id="validationDefault05" name="altura" required>
				</div>
				<div class="col-md-4">
					<label for="validationDefault04" class="form-label">Plan dietético</label>
					<select class="form-select" id="validationDefault04" name="tarifa" required>
						<?php
						$tarifas = recuperarTarifas();
						while ($fila = mysqli_fetch_row($tarifas)) {
							$titulo = $fila[1];

						?>
							<option selected> <?php echo $titulo ?></option>
						<?php

						}
						?>
					</select>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<label for="floatingTextarea2">Contraseña</label>
					<input type="text" class="form-control" id="passwdRand" name="passwdRand" placeholder="1234" required>
				</div>
				<div class="col-md-6">
					<button type="button" class="btn btn-outline-dark marginTop20" onclick="generatePasswordRand(10)">Generar contraseña</button>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<label for="floatingTextarea2">Patologías/Intoleráncias</label>
					<textarea class="form-control" id="floatingTextarea2" name="patologias" style="height: 100px"></textarea>
				</div>
				<div class="col-md-6">
					<label for="floatingTextarea2">Grupos de alimentos con aversión </label>
					<textarea class="form-control" id="floatingTextarea2" name="aversion" style="height: 100px"></textarea>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="form-check">
						<input class="form-check-input" type="checkbox" value="" id="invalidCheck2" required>
						<label class="form-check-label" for="invalidCheck2">
							<a>Estoy de acuerdo con los términos y las condiciones</a>
						</label>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<button type="submit" class="btn btn-outline-dark marginLeft20">Guardar</button>
				</div>
			</div>
		</form>
	</div>
</body>

</html>