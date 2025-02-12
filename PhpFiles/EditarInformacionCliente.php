<?php
include_once("clases.php");
$id_usuario = $_GET["id_usuario"];
$u = Usuario::getDatosUsuario($id_usuario);
?>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width-scale=1">
	<link rel="stylesheet" href="/css/estilos.css">
	<title>&nbsp;</title>
	<script>
		function volver() {
			Cargar('InformacionCliente.php?id_usuario=<?= $id_usuario ?>', 'cuerpoLogin');
		}

		function updateCliente() {
			var dts = {
				function: "updateCliente",
				id_usuario: <?= $id_usuario ?>,
				nombre: get("txtNombre"),
				apellido1: get("txtAp1"),
				apellido2: get("txtAp2"),
				movil: get("numberTel"),
				fechaNacimiento: get("dateNac"),
				sexo: get("selSexo"),
				altura: get("numberAltura"),
				id_tarifa: get("selTarifa"),
				patologias: get("areaPatologias"),
				aversiones: get("areaAversion")
			}
			debugger;
			jsonAjax("_server.php?", dts, (r) => {
				if (r.ok) {
					Cargar('InformacionCliente.php?id_usuario=<?= $id_usuario ?>', 'cuerpoLogin');
				} else {
					alert(r.msg);
				}
			});
		}
	</script>
</head>

<body>
	<div class="container marginTop30">
		<div class="row">
			<div class="col-md-4">
				<label for="txtNombre" class="form-label">Nombre</label>
				<input type="text" class="form-control" name="nombre" id="txtNombre" value="<?= $u->nombre ?>" required>
			</div>
			<div class="col-md-4">
				<label for="txtAp1" class="form-label">Primer Apellido</label>
				<input type="text" class="form-control" id="txtAp1" name="apellido1" value="<?= $u->apellido1 ?>" required>
			</div>
			<div class="col-md-4">
				<label for="txtAp2" class="form-label">Segundo Apellido</label>
				<input type="text" class="form-control" id="txtAp2" name="apellido2" value="<?= $u->apellido2 ?>" required>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4">
				<label for="txtEmail" class="form-label">Correo electrónico</label>
				<div class="input-group">
					<input disabled readonly type="email" class="form-control" id="txtEmail" name="email" aria-describedby="inputGroupPrepend2" value="<?= $u->email ?>" required>
				</div>
			</div>
			<div class="col-md-4">
				<label for="numberTel" class="form-label">Móvil</label>
				<input type="number" class="form-control" id="numberTel" name="tel" value="<?= $u->movil ?>" required>
			</div>
			<div class="col-md-4">
				<label for="dateNac">Fecha nacimiento:</label>
				<input type="date" class="form-control" id="dateNac" name="dateNac" value="<?= $u->fechaNacimiento ?>">
			</div>
		</div>
		<div class="row">
			<div class="col-md-4">
				<label for="selSexo" class="form-label">Sexo</label>
				<select class="form-select" id="selSexo" name="sexo" required>
					<?php
					$sexos = array("Hombre", "Mujer");
					foreach ($sexos as $s) {
						if ($u->sexo == $s) {
					?>
							<option selected value="<?= $s ?>"><?= $s ?></option>
						<?php
						} else {
						?>
							<option value="<?= $s ?>"><?= $s ?></option>
					<?php
						}
					}
					?>
				</select>
			</div>
			<div class="col-md-4">
				<label for="numberAltura" class="form-label">Altura (m)</label>
				<input type="number" step="0.01" value="<?= $u->altura ?>" class="form-control" id="numberAltura" name="altura" required>
			</div>
			<div class="col-md-4">
				<label for="selTarifa" class="form-label">Plan dietético</label>
				<select class="form-select" id="selTarifa" name="tarifa" required>
					<?php
					$tarifas = Tarifa::getTarifas();
					foreach ($tarifas as $i => $t) {
						if ($i == 0) {
					?>
							<option selected value="<?= $t->id ?>"><?= $t->titulo ?></option>
						<?php
						} else {
						?>
							<option value="<?= $t->id ?>"><?= $t->titulo ?></option>
					<?php
						}
					}
					?>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<label for="areaPatologias">Patologías/Intoleráncias</label>
				<textarea class="form-control" id="areaPatologias" name="patologias" style="height: 100px"><?= $u->patologias ?></textarea>
			</div>
			<div class="col-md-6">
				<label for="areaAversion">Grupos de alimentos con aversión </label>
				<textarea class="form-control" id="areaAversion" name="aversion" style="height: 100px"><?= $u->aversiones ?></textarea>
			</div>
		</div>
		<div class="row" style="margin-top: 5px;">
			<div class="col-12">
				<button style="margin-left: 0px;" type="button" onclick="volver()" class="btn btn-outline-dark marginLeft20">Atrás</button>
				<button type="button" onclick="updateCliente()" class="btn btn-outline-dark marginLeft20">Guardar</button>
			</div>
		</div>
	</div>
</body>

</html>