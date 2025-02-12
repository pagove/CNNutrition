<html lang="en">
<?php
include_once("clases.php");
?>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width-scale=1">
	<link rel="stylesheet" href="/css/estilos.css">
	<title>&nbsp;</title>
</head>

<body>

	<div class="container marginTop60">
		<div class="centrarTexto">
			<h2>Tarifas</h2>
		</div>
		<hr id="hrPerTarifa">
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
		<div class="row align-items-center">
			<?php
			$tarifas = Tarifa::getTarifas();
			while ($fila = mysqli_fetch_row($tarifas)) {
				$id = $fila[0];
				$titulo = $fila[1];
				$descripcion = $fila[2];
				$precio = $fila[3];
				$imagen = $fila[4];

			?>

				<div class="col">
					<div class="centrarTexto marginTop20 bordeRedondoFin" style="width: 16rem;">
						<div class="card-body centrarTexto">
							<form onsubmit="ProcesarForm(this, '/phpForms/ModTarifasForm.php', 'cuerpoLogin'); return false" method="post">
								<p class="centrarTexto">Introduce nombre de la imagen</p>
								<input type="text" class="form-control margin10 centrarTexto" name="id" id="validationCustom01" value='<?php echo $id ?>' required readonly>
								<input type="text" class="form-control margin10" name="imgName" id="validationCustom01" value='<?php echo $imagen ?>' required>
								<input type="text" class="form-control marginTop10" name="tituloName" id="validationCustom02" value='<?php echo $titulo ?>' required>
								<input type="text" class="form-control marginTop10" name="descripcionName" id="validationCustom03" value='<?php echo $descripcion ?>' required>
								<input type="number" step="0.1" class="form-control marginTop10" name="precioName" id="validationCustom04" value='<?php echo $precio ?>' required>
								<input type="submit" class="btn btn-outline-dark marginTop10" name="hacer" value="Guardar"></input>
							</form>
							<form onsubmit="ProcesarForm(this, '/phpForms/EliminarTarifaForm.php', 'cuerpoLogin'); return false" method="post">
								<input type="hidden" name="id" value="<?php echo $id ?>">
								<input type="submit" class="btn btn-outline-dark marginTop10" name="hacer" value="Eliminar"></input>
							</form>
						</div>
					</div>
				</div>

			<?php
			}
			?>
			<div id="nuevaTar" class="col">
				<div class="centrarTexto marginTop20 bordeRedondoFin" style="width: 16rem;">
					<img src="/web_images/mas.jpg" class="card-img-top tamCardImg" alt="..." onclick="nuevaTarifa()">
				</div>
			</div>
		</div>


</body>

</html>