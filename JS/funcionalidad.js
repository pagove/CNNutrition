
function jsonAjax(url, data, callback) {
	fetch(url, {
		method: "POST",
		headers: {
			'Content-Type': 'application/json'
		},
		body: JSON.stringify(data)
	})
		.then(response => response.json())
		.then(jsonData => {
			callback(jsonData);
		})
		.catch(error => {
			console.error('Error en la solicitud AJAX:', error);
		});
}
function get(id) {
	return document.getElementById(id).value;
}
function eur2iso(fecha, separador = "/") {
	fecha = fecha.split(separador);
	return fecha[2] + "-" + fecha[1] + "-" + fecha[0];
}
function iso2eur(fecha, separado = "-") {
	fecha = fecha.split(separado);
	return fecha[2] + "/" + fecha[1] + "-" + fecha[0];
}

function errorAlert(texto) {
	var alert =
		"<div class='alert alert-danger d-flex align-items-center' role='alert'>" +
		"<svg class='bi flex-shrink-0 me-2' role='img' aria-label='Danger:'><use xlink:href='#exclamation-triangle-fill'/></svg>" +
		"<div>" +
		texto +
		"</div>" +
		"</div>";
}

function successAlert(texto) {
	var alert =
		"<div class='alert alert-success d-flex align-items-center' role='alert'>" +
		"<svg class='bi flex-shrink-0 me-2' role='img' aria-label='Success:'><use xlink:href='#check-circle-fill'/></svg>" +
		"<div>" +
		texto +
		"</div>" +
		"</div>";
}

function setActiveLink(num) {

	numOfLi = document.getElementById("myTab").getElementsByTagName("li").length;
	id = "subMenu";

	for (var i = 0; i < numOfLi; i++) {
		id = id + i;
		if (i == num) {
			document.getElementById(id).className = "nav-link active textoSubMenu";
		} else {
			document.getElementById(id).className = "nav-link textoSubMenu";
		}
		id = "subMenu";
	}

}

function generatePasswordRand(length, type) {
	switch (type) {
		case 'num':
			characters = "0123456789";
			break;
		case 'alf':
			characters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
			break;
		case 'rand':
		//FOR               break;
		default:
			characters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
			break;
	}
	var pass = "";
	for (i = 0; i < length; i++) {
		if (type == 'rand') {
			pass += String.fromCharCode((Math.floor((Math.random() * 100)) % 94) + 33);
		} else {
			pass += characters.charAt(Math.floor(Math.random() * characters.length));
		}
	}

	document.getElementById("textPasswd").value = pass;
}

function destruirBoton() {
	document.getElementById("botonLogout").innerHTML = "";
}

function anyadirBoton() {

	var boton = `<a class="nav-link active textoNavBar" aria-current="page" href="#" id="loginButton" onclick="Cargar('/phpForms/LogoutButtonForm.php', 'cuerpo')">Salir</a>`;

	document.getElementById("botonLogout").innerHTML = boton;

}

function cambiarBoton() {

	var boton = document.getElementById("loginButton");

	if (boton.textContent == "Entrar") {
		boton.innerHTML = "Perfil";
	} else {
		boton.innerHTML = "Entrar";
	}
}

function pintarNumClientes(arrJson) {
	//alert((arrJson.length));

	var chart = new CanvasJS.Chart("charNumClientes", {
		animationEnabled: true,
		exportEnabled: true,
		theme: "light2", // "light1", "light2", "dark1", "dark2"
		title: {
			text: "Numero de clientes ultimos 12 meses"
		},
		axisY: {
			title: "Num Clientes"
		},
		data: [{
			type: "column",
			showInLegend: true,
			legendMarkerColor: "grey",
			legendText: "Fecha",
			dataPoints: [
			]
		}]
	});
	chart.render();

	for (var i = 0; i < arrJson.length; i++) {
		//alert(arrJson[i].totalClientes);
		chart.data[0].addTo("dataPoints", { y: parseInt(arrJson[i].totalClientes), label: arrJson[i].fecha });
	}
	chart.render();
}

function clientesTarifas(arrJson) {

	var chart = new CanvasJS.Chart("charClientesTarifas", {
		exportEnabled: true,
		animationEnabled: true,
		title: {
			text: "Clientes por tarifas"
		},
		legend: {
			cursor: "pointer",
			itemclick: explodePie
		},
		data: [{
			type: "pie",
			showInLegend: true,
			toolTipContent: "{name}: <strong>{y}</strong>",
			indexLabel: "{name}  {y}",
			dataPoints: [

			]
		}]
	});
	chart.render();

	for (var i = 0; i < arrJson.length; i++) {
		//alert(arrJson[i].totalClientes);
		chart.data[0].addTo("dataPoints", { y: parseInt(arrJson[i].num), name: arrJson[i].titulo });
	}
	chart.render();
}

function explodePie(e) {
	if (typeof (e.dataSeries.dataPoints[e.dataPointIndex].exploded) === "undefined" || !e.dataSeries.dataPoints[e.dataPointIndex].exploded) {
		e.dataSeries.dataPoints[e.dataPointIndex].exploded = true;
	} else {
		e.dataSeries.dataPoints[e.dataPointIndex].exploded = false;
	}
	e.chart.render();

}

function pintarBoton(idB, background, foreground) {
	document.getElementById(idB).style.backgroundColor = background;
	document.getElementById(idB).style.color = foreground;
}

function pintarGraficaP() {
	var chart = new CanvasJS.Chart("chartContainerP", {
		title: {
			text: "Perímetros"
		},
		axisY: [{
			title: "Cintura SA",
			lineColor: "#C24642",
			tickColor: "#C24642",
			labelFontColor: "#C24642",
			titleFontColor: "#C24642",
			includeZero: true,
			suffix: "cm"
		},
		{
			title: "Abdominal",
			lineColor: "#369EAD",
			tickColor: "#369EAD",
			labelFontColor: "#369EAD",
			titleFontColor: "#369EAD",
			includeZero: true,
			suffix: "cm"
		},
		{
			title: "Cadera",
			lineColor: "#21EF38",
			tickColor: "#21EF38",
			labelFontColor: "#21EF38",
			titleFontColor: "#21EF38",
			includeZero: true,
			suffix: "cm"
		},
		{
			title: "Muslo",
			lineColor: "#F4F831",
			tickColor: "#F4F831",
			labelFontColor: "#F4F831",
			titleFontColor: "#F4F831",
			includeZero: true,
			suffix: "cm"
		}],
		axisY2: [{
			title: "Gemelo",
			lineColor: "#7F6084",
			tickColor: "#7F6084",
			labelFontColor: "#7F6084",
			titleFontColor: "#7F6084",
			includeZero: true,
			prefix: "$",
			suffix: "cm"
		},
		{
			title: "Brazo Contr",
			lineColor: "#A90EF1",
			tickColor: "#A90EF1",
			labelFontColor: "#A90EF1",
			titleFontColor: "#A90EF1",
			includeZero: true,
			prefix: "$",
			suffix: "cm"
		},
		{
			title: "Brazo Relaj",
			lineColor: "#8CAFF0",
			tickColor: "#8CAFF0",
			labelFontColor: "#8CAFF0",
			titleFontColor: "#8CAFF0",
			includeZero: true,
			prefix: "$",
			suffix: "cm"
		}],
		toolTip: {
			shared: true
		},
		legend: {
			cursor: "pointer",
			itemclick: toggleDataSeries
		},
		data: [{
			type: "line",
			name: "Cintura AS",
			color: "#C24642",
			showInLegend: true,
			axisYIndex: 1,
			dataPoints: [
			]
		},
		{
			type: "line",
			name: "Abdominal",
			color: "#369EAD",
			axisYIndex: 0,
			showInLegend: true,
			dataPoints: [
			]
		},
		{
			type: "line",
			name: "Cadera",
			color: "#21EF38",
			axisYType: "secondary",
			showInLegend: true,
			dataPoints: [
			]
		},
		{
			type: "line",
			name: "Muslo",
			color: "#F4F831",
			axisYType: "secondary",
			showInLegend: true,
			dataPoints: [
			]
		},
		{
			type: "line",
			name: "Gemelo",
			color: "#7F6084",
			axisYType: "secondary",
			showInLegend: true,
			dataPoints: [
			]
		},
		{
			type: "line",
			name: "Braazo Contr",
			color: "#A90EF1",
			axisYType: "secondary",
			showInLegend: true,
			dataPoints: [
			]
		},
		{
			type: "line",
			name: "Brazo Relaj",
			color: "#8CAFF0",
			axisYType: "secondary",
			showInLegend: true,
			dataPoints: [
			]
		}
		]
	});


	chart.render();

	var tabla = document.getElementById("TablaPerimetros");
	var nRows = tabla.rows.length - 1; // menos la fila de los titulos
	for (var i = 1, row; row = tabla.rows[i]; i++) {
		chart.data[0].addTo("dataPoints", { x: new Date(row.cells[0].textContent), y: parseInt(row.cells[1].textContent, 10) });
		chart.data[1].addTo("dataPoints", { x: new Date(row.cells[0].textContent), y: parseInt(row.cells[2].textContent, 10) });
		chart.data[2].addTo("dataPoints", { x: new Date(row.cells[0].textContent), y: parseInt(row.cells[3].textContent, 10) });
		chart.data[3].addTo("dataPoints", { x: new Date(row.cells[0].textContent), y: parseInt(row.cells[4].textContent, 10) });
		chart.data[4].addTo("dataPoints", { x: new Date(row.cells[0].textContent), y: parseInt(row.cells[5].textContent, 10) });
		chart.data[5].addTo("dataPoints", { x: new Date(row.cells[0].textContent), y: parseInt(row.cells[6].textContent, 10) });
		chart.data[6].addTo("dataPoints", { x: new Date(row.cells[0].textContent), y: parseInt(row.cells[7].textContent, 10) });

		//alert(row.cells[0].textContent + " " + row.cells[1].textContent + " " + row.cells[2].textContent + " " + row.cells[3].textContent);
	}

	chart.render();


}

function pintarGraficaPC() {
	var chart = new CanvasJS.Chart("chartContainerPC", {
		title: {
			text: "Pliegues cutaneos"
		},
		axisY: [{
			title: "Tricipital",
			lineColor: "#C24642",
			tickColor: "#C24642",
			labelFontColor: "#C24642",
			titleFontColor: "#C24642",
			includeZero: true,
			suffix: "cm"
		},
		{
			title: "Subescapular",
			lineColor: "#369EAD",
			tickColor: "#369EAD",
			labelFontColor: "#369EAD",
			titleFontColor: "#369EAD",
			includeZero: true,
			suffix: "cm"
		},
		{
			title: "Supraliaco",
			lineColor: "#21EF38",
			tickColor: "#21EF38",
			labelFontColor: "#21EF38",
			titleFontColor: "#21EF38",
			includeZero: true,
			suffix: "cm"
		}],
		axisY2: [{
			title: "Abdominal",
			lineColor: "#7F6084",
			tickColor: "#7F6084",
			labelFontColor: "#7F6084",
			titleFontColor: "#7F6084",
			includeZero: true,
			prefix: "$",
			suffix: "cm"
		},
		{
			title: "MusloAnterior",
			lineColor: "#A90EF1",
			tickColor: "#A90EF1",
			labelFontColor: "#A90EF1",
			titleFontColor: "#A90EF1",
			includeZero: true,
			prefix: "$",
			suffix: "cm"
		},
		{
			title: "Gemelo",
			lineColor: "#8CAFF0",
			tickColor: "#8CAFF0",
			labelFontColor: "#8CAFF0",
			titleFontColor: "#8CAFF0",
			includeZero: true,
			prefix: "$",
			suffix: "cm"
		}],
		toolTip: {
			shared: true
		},
		legend: {
			cursor: "pointer",
			itemclick: toggleDataSeries
		},
		data: [{
			type: "line",
			name: "Tricipital",
			color: "#C24642",
			showInLegend: true,
			axisYIndex: 1,
			dataPoints: [
			]
		},
		{
			type: "line",
			name: "Subescapular",
			color: "#369EAD",
			axisYIndex: 0,
			showInLegend: true,
			dataPoints: [
			]
		},
		{
			type: "line",
			name: "Supraliaco",
			color: "#21EF38",
			axisYType: "secondary",
			showInLegend: true,
			dataPoints: [
			]
		},
		{
			type: "line",
			name: "Abdominal",
			color: "#7F6084",
			axisYType: "secondary",
			showInLegend: true,
			dataPoints: [
			]
		},
		{
			type: "line",
			name: "MusloAnterior",
			color: "#A90EF1",
			axisYType: "secondary",
			showInLegend: true,
			dataPoints: [
			]
		},
		{
			type: "line",
			name: "Gemelo",
			color: "#8CAFF0",
			axisYType: "secondary",
			showInLegend: true,
			dataPoints: [
			]
		}
		]
	});


	chart.render();

	var tabla = document.getElementById("TablaPlieguesCutaneos");
	var nRows = tabla.rows.length - 1; // menos la fila de los titulos
	for (var i = 1, row; row = tabla.rows[i]; i++) {
		chart.data[0].addTo("dataPoints", { x: new Date(row.cells[0].textContent), y: parseInt(row.cells[1].textContent, 10) });
		chart.data[1].addTo("dataPoints", { x: new Date(row.cells[0].textContent), y: parseInt(row.cells[2].textContent, 10) });
		chart.data[2].addTo("dataPoints", { x: new Date(row.cells[0].textContent), y: parseInt(row.cells[3].textContent, 10) });
		chart.data[3].addTo("dataPoints", { x: new Date(row.cells[0].textContent), y: parseInt(row.cells[4].textContent, 10) });
		chart.data[4].addTo("dataPoints", { x: new Date(row.cells[0].textContent), y: parseInt(row.cells[5].textContent, 10) });
		chart.data[5].addTo("dataPoints", { x: new Date(row.cells[0].textContent), y: parseInt(row.cells[6].textContent, 10) });

		//alert(row.cells[0].textContent + " " + row.cells[1].textContent + " " + row.cells[2].textContent + " " + row.cells[3].textContent);
	}

	chart.render();


}

function pintarGraficaDG() {

	var chart = new CanvasJS.Chart("chartContainerDG", {
		title: {
			text: "Datos Generales"
		},
		axisY: [{
			title: "Peso",
			lineColor: "#C24642",
			tickColor: "#C24642",
			labelFontColor: "#C24642",
			titleFontColor: "#C24642",
			includeZero: true,
			suffix: "Kg"
		},
		{
			title: "Grasa",
			lineColor: "#369EAD",
			tickColor: "#369EAD",
			labelFontColor: "#369EAD",
			titleFontColor: "#369EAD",
			includeZero: true,
			suffix: "%"
		}],
		axisY2: {
			title: "Musculo",
			lineColor: "#7F6084",
			tickColor: "#7F6084",
			labelFontColor: "#7F6084",
			titleFontColor: "#7F6084",
			includeZero: true,
			prefix: "$",
			suffix: "%"
		},
		toolTip: {
			shared: true
		},
		legend: {
			cursor: "pointer",
			itemclick: toggleDataSeries
		},
		data: [{
			type: "line",
			name: "Peso",
			color: "#369EAD",
			showInLegend: true,
			axisYIndex: 1,
			dataPoints: [
			]
		},
		{
			type: "line",
			name: "Grasa",
			color: "#C24642",
			axisYIndex: 0,
			showInLegend: true,
			dataPoints: [
			]
		},
		{
			type: "line",
			name: "Musculo",
			color: "#7F6084",
			axisYType: "secondary",
			showInLegend: true,
			dataPoints: [
			]
		}
		]
	});


	chart.render();

	var tabla = document.getElementById("TablaDatosGenerales");
	var nRows = tabla.rows.length - 1; // menos la fila de los titulos
	for (var i = 1, row; row = tabla.rows[i]; i++) {
		chart.data[0].addTo("dataPoints", { x: new Date(row.cells[0].textContent), y: parseInt(row.cells[1].textContent, 10) });
		chart.data[1].addTo("dataPoints", { x: new Date(row.cells[0].textContent), y: parseInt(row.cells[2].textContent, 10) });
		chart.data[2].addTo("dataPoints", { x: new Date(row.cells[0].textContent), y: parseInt(row.cells[3].textContent, 10) });

		//alert(row.cells[0].textContent + " " + row.cells[1].textContent + " " + row.cells[2].textContent + " " + row.cells[3].textContent);
	}

	chart.render();



}

function toggleDataSeries(e) {
	if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
		e.dataSeries.visible = false;
	} else {
		e.dataSeries.visible = true;
	}
	e.chart.render();
}

function nuevaTarifa() {

	var nuevaT = "";
	nuevaT += "<div class='centrarTexto marginTop20 bordeRedondoFin' style='width: 16rem;'>";
	nuevaT += "<div class='card-body centrarTexto'>";
	nuevaT += `<form onsubmit="ProcesarForm(this, '/phpForms/ModTarifasForm.php', 'cuerpoLogin'); return false" method="post">`;
	nuevaT += "<form method='post' onsubmit='ProcesarForm(this, \'ModTarifas.php\', \'cuerpo\'); return false'>";
	nuevaT += "<p class='centrarTexto'>Introduce nombre de la imagen</p>";
	nuevaT += "<input type='text' class='form-control margin10 centrarTexto' name='id' id='validationCustom01' value='NuevaTarifa' required readonly>";
	nuevaT += "<input type='text' class='form-control margin10' name='imgName' id='validationCustom01' placeholder='Imagen' required>";
	nuevaT += "<input type='text' class='form-control marginTop10' name='tituloName' id='validationCustom02' placeholder='Titulo' required>";
	nuevaT += "<input type='text' class='form-control marginTop10' name='descripcionName' id='validationCustom03' placeholder='Descripcion' required>";
	nuevaT += "<input type='number' step='0.1' class='form-control marginTop10' name='precioName' id='validationCustom04' placeholder='30,00' required>";
	nuevaT += "<input type='submit' class='btn btn-outline-dark marginTop10' value='Guardar'></input>";
	nuevaT += "</form>";
	nuevaT += "</div>";
	nuevaT += "</div>";

	document.getElementById("nuevaTar").innerHTML = nuevaT;


}

function Cargar(url, capa, ruta_x_defecto = true) {
	if (ruta_x_defecto) url = "PhpFiles/" + url;
	var contenido = document.getElementById(capa);
	var conexion = nuevaConexion();
	conexion.open("GET", url, true);
	conexion.onreadystatechange = function () {
		if ((conexion.readyState == 4) && (conexion.status == 200)) {
			contenido.innerHTML = conexion.responseText;
			invokeScript(document.getElementById(capa));

		}
	}
	conexion.send(null);
}

function nuevaConexion() {
	var xmlhttp = false;
	try {
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (e) {
		try {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		} catch (E) {
			xmlhttp = false;
		}
	}

	if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
		xmlhttp = new XMLHttpRequest();
	}
	return xmlhttp;
}

function invokeScript(divid) {

	var scriptObj = divid.getElementsByTagName("SCRIPT");
	var len = scriptObj.length;

	for (var i = 0; i < len; i++) {

		var scriptText = scriptObj[i].text;
		var scriptFile = scriptObj[i].src
		var scriptTag = document.createElement("SCRIPT");

		if ((scriptFile != null) && (scriptFile != "")) {
			scriptTag.src = scriptFile;
		}

		scriptTag.text = scriptText;

		if (!document.getElementsByTagName("HEAD")[0]) {
			document.createElement("HEAD").appendChild(scriptTag)
		} else {
			document.getElementsByTagName("HEAD")[0].appendChild(scriptTag);
		}

	}

}

function CargarForm(url, capa, valores) {
	var contenido = document.getElementById(capa);

	conexion = nuevaConexion();

	conexion.open("POST", url, true);

	conexion.onreadystatechange = function () {

		if ((conexion.readyState == 4) && (conexion.status == 200)) {

			contenido.innerHTML = conexion.responseText;

			invokeScript(document.getElementById(capa));

		}

	}
	conexion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=utf-8');

	conexion.send(valores);

}

function ProcesarForm(formulario, url, capa) {
	valores = "";

	for (i = 0; i < formulario.elements.length; i++) {
		nombre = formulario.elements[i].name;
		if (nombre != "") {
			if ((formulario.elements[i].type == "radio") && (!formulario.elements[i].checked))
				;
			else {
				valores += formulario.elements[i].name + "=";
				valores += formulario.elements[i].value + "&";
			}

		}

	}
	CargarForm(url, capa, valores);
}





