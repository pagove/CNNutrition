<?php
include_once("clases.php");
session_start();
?>

<html>

<head>
	<!-- Required meta tags -->
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link rel="stylesheet" href="css/estilos.css">
	<title>&nbsp;</title>
</head>

<body onload="Cargar('/php/Buscar.php', 'cuerpoLogin')">
	<header>

		<ul class="nav nav-tabs" id="myTab" role="tablist">
			<li class="nav-item" role="presentation">
				<button class="nav-link textoSubMenu" id="subMenu0" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false" onclick="Cargar('NuevoCliente.php', 'cuerpoLogin')">Nuevo Cliente</button>
			</li>
			<li class="nav-item" role="presentation">
				<button class="nav-link active textoSubMenu" id="subMenu1" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true" onclick="Cargar('Buscar.php', 'cuerpoLogin')">Buscar Cliente</button>
			</li>
			<li class="nav-item" role="presentation">
				<button class="nav-link textoSubMenu" id="subMenu2" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false" onclick="Cargar('ModTarifas.php', 'cuerpoLogin')">Modificar Tarifas</button>
			</li>
			<li class="nav-item" role="presentation">
				<button class="nav-link textoSubMenu" id="subMenu3" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false" onclick="Cargar('Estadisticas.php', 'cuerpoLogin')">Estadísticas</button>
			</li>
		</ul>
	</header>

	<?php
	$ventana = isset($_SESSION['ventana']) ? $_SESSION['ventana'] : "";
	switch ($ventana) {
		case "":
		case "Buscar":
	?>
			<script>
				setActiveLink(1)
			</script>
			<script>
				Cargar('Buscar.php', 'cuerpoLogin');
			</script>
		<?php
			break;
		case "ModTarifas":
		?>
			<script>
				setActiveLink(2)
			</script>
			<script>
				Cargar('ModTarifas.php', 'cuerpoLogin');
			</script>
		<?php
			break;
		case "NuevoCliente":
		?>
			<script>
				setActiveLink(0)
			</script>
			<script>
				Cargar('NuevoCliente.php', 'cuerpoLogin');
			</script>
		<?php
			break;
		case "InformacionCliente":
			$datosG = filter_input(INPUT_GET, 'idDatosG');
			$idPliegue = filter_input(INPUT_GET, 'idPliegue');
			$idPerimetro = filter_input(INPUT_GET, 'idPerimetro');
		?>
			<script>
				Cargar('InformacionCliente.php/?idDatosG=<?php echo $datosG ?>&idPliegue=<?php echo $idPliegue ?>&idPerimetro=<?php echo $idPerimetro ?>', 'cuerpoLogin')
			</script>
		<?php
			break;
		case "EditarCliente":
		?>
			<script>
				Cargar('EditarCliente.php', 'cuerpoLogin')
			</script>
	<?php
			break;
	}
	?>
	<div id="cuerpoLogin" class="container marginTop30"></div>
</body>

</html>