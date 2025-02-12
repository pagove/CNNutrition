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
		function cargarPefilUsuario(id_usuario) {
			Cargar('InformacionCliente.php?id_usuario=' + id_usuario, 'cuerpoLogin')
		}

		function guardarDatos(id_usuario) {
			var regex_email = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
			var dts = {
				function: "editarUsuario",
				id_usuario: id_usuario,
				nombre: get("inNombre"),
				ap1: get("inAp1"),
				ap2: get("inAp2"),
				email: get("inEmail"),
				tel: get("inTel"),
				nacimiento: get("inFechaNac"),
				sexo: get("inSex"),
				altura: get("inAltura"),
				tarifa: get("inTarifa"),
				patologias: get("inPatologias"),
				aversion: get("inAversion")
			};
			if (!dts.nombre) return alert("El campo 'nombre' es obligatorio");
			if (!dts.ap1 || !dts.ap2) return alert("Los apellidos son obligatorios");
			if (!dts.email) return alert("El campo 'email' es obligatorio");
			if (!dts.tel) return alert("El campo 'móvil' es obligatorio");
			if (!dts.nacimiento) return alert("El campo 'fecha nacimiento' es obligatorio");
			if (!dts.sexo) return alert("El campo 'sexo' es obligatorio");
			if (!dts.altura) return alert("El campo 'altura' es obligatorio");
			if (!dts.tarifa) return alert("El campo 'plan dietético' es obligatorio");
			if (new Date(dts.nacimiento) >= new Date()) return alert("Fecha nacimiento incorrecta");
			if (!regex_email.test(dts.email)) return alert("El correo no está bien formado");

			jsonAjax("_server.php", dts, (r) => {
				if (r.ok) {
					alert("Se han modificado los datos correctamente");
					Cargar('InformacionCliente.php?id_usuario=' + id_usuario, 'cuerpoLogin');
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
				<label for="inNombre" class="form-label">Nombre</label>
				<input type="text" class="form-control" name="inNombre" id="inNombre" value="<?= $u->nombre  ?>">
			</div>
			<div class="col-md-4">
				<label for="inAp1" class="form-label">Primer Apellido</label>
				<input type="text" class="form-control" id="inAp1" name="inAp1" value="<?= $u->apellido1 ?>">
			</div>
			<div class="col-md-4">
				<label for="inAp2" class="form-label">Segundo Apellido</label>
				<input type="text" class="form-control" id="inAp2" name="inAp2" value="<?= $u->apellido2 ?>">
			</div>
		</div>
		<div class="row">
			<div class="col-md-4">
				<label for="inEmail" class="form-label">Correo electrónico</label>
				<div class="input-group">
					<input type="email" class="form-control" id="inEmail" name="inEmail" aria-describedby="inputGroupPrepend2" value="<?= $u->email ?>">
				</div>
			</div>
			<div class="col-md-4">
				<label for="inTel" class="form-label">Móvil</label>
				<input type="number" class="form-control" id="inTel" name="inTel" value="<?= $u->movil ?>">
			</div>
			<div class="col-md-4">
				<label for="inFechaNac">Fecha nacimiento:</label>
				<input type="date" class="form-control" id="inFechaNac" name="inFechaNac" value="<?= $u->fechaNacimiento ?>">
			</div>
		</div>
		<div class="row">
			<div class="col-md-4">
				<label for="inSex" class="form-label">Sexo</label>
				<select class="form-select" id="inSex" name="inSex">
					<?php
					if ($u->sexo == "Hombre") {
					?>
						<option selected>Hombre</option>
						<option>Mujer</option>
					<?php
					} else {
					?>
						<option>Hombre</option>
						<option selected>Mujer</option>
					<?php
					}
					?>
				</select>
			</div>
			<div class="col-md-4">
				<label for="inAltura" class="form-label">Altura (m)</label>
				<input type="number" step="0.01" class="form-control" id="inAltura" name="inAltura" value="<?= $u->altura  ?>">
			</div>
			<div class="col-md-4">
				<label for="inTarifa" class="form-label">Plan dietético</label>
				<select class="form-select" id="inTarifa" name="inTarifa">
					<?php
					$tarifas = Tarifa::getTarifas();
					foreach ($tarifas as $t) {
						$sel = $t->id == $u->id_tarifa ? "selected" : "";
					?>
						<option <?= $sel ?> value=<?= $t->id ?>> <?= $t->titulo ?></option>
					<?php
					}
					?>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<label for="inPatologias">Patologías/Intoleráncias</label>
				<textarea class="form-control" id="inPatologias" name="inPatologias" style="height: 100px"> <?= $u->patologias ?></textarea>
			</div>
			<div class="col-md-6">
				<label for="inAversion">Grupos de alimentos con aversión </label>
				<textarea class="form-control" id="inAversion" name="inAversion" style="height: 100px"> <?= $u->aversiones ?></textarea>
			</div>
		</div>
		<div class="row marginTop10">
			<div class="col-3">
				<button type="button" onclick="cargarPefilUsuario('<?= $id_usuario ?>')" class="btn btn-outline-danger">Cancelar</button>
				<button type="button" onclick="guardarDatos('<?= $id_usuario ?>')" class="btn btn-outline-dark marginLeft20">Guardar</button>
			</div>
		</div>

</html>