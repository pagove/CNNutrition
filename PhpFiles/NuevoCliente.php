<?php
include_once("clases.php");
?>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width-scale=1">
	<link rel="stylesheet" href="/css/estilos.css">
	<title>&nbsp;</title>
	<script>
		function abrirPoliticasPrivacidad() {
			event.preventDefault();
			window.open("PhpFiles/PoliticasPrivacidad.php", "_blank");
		}

		function registraUsuario() {
			var regex_email = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
			var dts = {
				function: "registraUsuario",
				nombre: get("txtNombre"),
				ap1: get("txtAp1"),
				ap2: get("txtAp2"),
				email: get("txtEmail"),
				tel: get("numberTel"),
				nacimiento: get("dateNac"),
				sexo: get("selSexo"),
				altura: get("numberAltura"),
				tarifa: get("selTarifa"),
				passwd: get("textPasswd"),
				patologias: get("areaPatologias"),
				aversion: get("areaAversion")
			};
			if (!dts.nombre) return alert("El campo 'nombre' es obligatorio");
			if (!dts.ap1 || !dts.ap2) return alert("Los apellidos son obligatorios");
			if (!dts.email) return alert("El campo 'email' es obligatorio");
			if (!dts.tel) return alert("El campo 'móvil' es obligatorio");
			if (!dts.nacimiento) return alert("El campo 'fecha nacimiento' es obligatorio");
			if (!dts.sexo) return alert("El campo 'sexo' es obligatorio");
			if (!dts.altura) return alert("El campo 'altura' es obligatorio");
			if (!dts.tarifa) return alert("El campo 'plan dietético' es obligatorio");
			if (!dts.passwd) return alert("El campo 'contraseña' es obligatorio");
			if (new Date(dts.nacimiento) >= new Date()) return alert("Fecha nacimiento incorrecta");
			if (!regex_email.test(dts.email)) return alert("El correo no está bien formado");

			jsonAjax("_server.php", dts, (r) => {
				if (r.ok) {
					Cargar('Buscar.php', 'cuerpoLogin')
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
				<input type="text" class="form-control" name="nombre" id="txtNombre" placeholder="Mark" required>
			</div>
			<div class="col-md-4">
				<label for="txtAp1" class="form-label">Primer Apellido</label>
				<input type="text" class="form-control" id="txtAp1" name="apellido1" placeholder="Otto" required>
			</div>
			<div class="col-md-4">
				<label for="txtAp2" class="form-label">Segundo Apellido</label>
				<input type="text" class="form-control" id="txtAp2" name="apellido2" placeholder="Obama" required>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4">
				<label for="txtEmail" class="form-label">Correo electrónico</label>
				<div class="input-group">
					<input type="email" class="form-control" id="txtEmail" name="email" aria-describedby="inputGroupPrepend2" placeholder="example@gmail.com" required>
				</div>
			</div>
			<div class="col-md-4">
				<label for="numberTel" class="form-label">Móvil</label>
				<input type="number" class="form-control" id="numberTel" name="tel" placeholder="xxxxxxxxx" required>
			</div>
			<div class="col-md-4">
				<label for="dateNac">Fecha nacimiento:</label>
				<input type="date" class="form-control" id="dateNac" name="dateNac">
			</div>
		</div>
		<div class="row">
			<div class="col-md-4">
				<label for="selSexo" class="form-label">Sexo</label>
				<select class="form-select" id="selSexo" name="sexo" required>
					<option selected>Hombre</option>
					<option>Mujer</option>
				</select>
			</div>
			<div class="col-md-4">
				<label for="numberAltura" class="form-label">Altura (m)</label>
				<input type="number" step="0.01" value="1.50" class="form-control" id="numberAltura" name="altura" required>
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
				<label for="textPasswd">Contraseña</label>
				<input type="text" class="form-control" id="textPasswd" name="textPasswd" placeholder="1234" required>
			</div>
			<div class="col-md-6">
				<button type="button" class="btn btn-outline-dark marginTop20" onclick="generatePasswordRand(10)">Generar contraseña</button>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<label for="areaPatologias">Patologías/Intoleráncias</label>
				<textarea class="form-control" id="areaPatologias" name="patologias" style="height: 100px"></textarea>
			</div>
			<div class="col-md-6">
				<label for="areaAversion">Grupos de alimentos con aversión </label>
				<textarea class="form-control" id="areaAversion" name="aversion" style="height: 100px"></textarea>
			</div>
		</div>
		<div class="row" style="margin-top: 5px;">
			<div class="col-12">
				<button type="button" onclick="registraUsuario()" class="btn btn-outline-dark marginLeft20">Guardar</button>
			</div>
		</div>
	</div>
</body>

</html>