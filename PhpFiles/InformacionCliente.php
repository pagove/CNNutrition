<?php
include_once("clases.php");
$id_usuario = $_GET["id_usuario"];

if (isset($_GET["cantidad"])) {
    $cantidad = $_GET["cantidad"];
} else {
    $cantidad = 10;
}

?>
<script>
    function reload(id_usuario) {
        var cantidad = get("cantidadDatos");
        Cargar("./InformacionCliente.php?id_usuario=" + id_usuario + "&cantidad=" + cantidad, "cuerpoLogin");
    }

    function guardarDatosGeneralesJS(id_usuario) {
        var fecha = eur2iso(get("fechaDG"));
        var peso = get("pesoDG");
        var grasa = get("grasaDG");
        var musculo = get("musculoDG");

        if (!fecha || !peso || !grasa || !musculo) {
            alert("Falta información por rellenar");
        } else {
            var dts = {
                function: "guardarDatosGenerales",
                id_usuario: id_usuario,
                fecha: fecha,
                peso: peso,
                grasa: grasa,
                musculo: musculo
            };
            jsonAjax("_server.php?", dts, (r) => {
                if (!r.ok) {
                    alert(r.msg);
                } else {
                    Cargar("./InformacionCliente.php?id_usuario=" + id_usuario, "cuerpoLogin");
                }
            });
        }
    }

    function eliminarDatosNutricionalesGenerales(id_dato_general, id_usuario) {
        var dts = {
            function: "eliminarDatosNutricionalesGenerales",
            id_dato_general: id_dato_general
        };
        var confirm = window.confirm("¿Estas seguro que deseas eliminar el dato?");
        if (confirm) {
            jsonAjax("_server.php", dts, (r) => {
                if (r.ok) {
                    Cargar("./InformacionCliente.php?id_usuario=" + id_usuario, "cuerpoLogin");
                } else {
                    alert("No se ha podido eliminar la información " + r.msg);
                }
            });
        }
    }

    function guardarPlieguesCutaneos(id_usuario) {
        var dts = {
            function: "guardarPlieguesCutaneos",
            id_usuario: id_usuario,
            tricipital: get("inPlTricipital"),
            subescapular: get("inPlSubescapular"),
            supraliaco: get("inPlSupraliaco"),
            abdominal: get("inPlAbdominal"),
            muslo_anterior: get("inPlMusloAnterior"),
            gemelo: get("inPlGemelo")
        }
        if (!dts.tricipital || !dts.subescapular || !dts.supraliaco || !dts.abdominal || !dts.muslo_anterior || !dts.gemelo) {
            alert("Datos incompletos");
            return false;
        }
        jsonAjax("_server.php?", dts, (r) => {
            if (!r.ok) {
                alert(r.msg);
            } else {
                Cargar("./InformacionCliente.php?id_usuario=" + id_usuario, "cuerpoLogin");
            }
        });

    }

    function eliminarPlieguesCutaneos(id_pliegue, id_usuario) {
        var dts = {
            function: "eliminarPlieguesCutaneos",
            id_pliegue: id_pliegue
        };
        var confirm = window.confirm("¿Estas seguro que deseas eliminar el dato?");
        if (confirm) {
            jsonAjax("_server.php", dts, (r) => {
                if (r.ok) {
                    Cargar("./InformacionCliente.php?id_usuario=" + id_usuario, "cuerpoLogin");
                } else {
                    alert("No se ha podido eliminar la información " + r.msg);
                }
            });
        }
    }

    function guardaPerimetros(id_usuario) {
        var dts = {
            function: "guardaPerimetros",
            id_usuario: id_usuario,
            cinturaSuperiorAbdominal: get("inPCinturaSuperiorAbdominal"),
            abdominal: get("inPAbdominal"),
            cadera: get("inPCadera"),
            muslo: get("inPMuslo"),
            gemelo: get("inPGemelo"),
            brazo_contraido: get("inPBrazoContraido"),
            brazo_relajado: get("inPBrazoRelajado")
        }
        if (!dts.cinturaSuperiorAbdominal || !dts.abdominal || !dts.cadera || !dts.muslo || !dts.gemelo || !dts.brazo_contraido || !dts.brazo_relajado) {
            alert("Datos incompletos");
            return false;
        }
        jsonAjax("_server.php?", dts, (r) => {
            if (!r.ok) {
                alert(r.msg);
            } else {
                Cargar("./InformacionCliente.php?id_usuario=" + id_usuario, "cuerpoLogin");
            }
        });
    }

    function eliminaPerimetros(id_perimetro, id_usuario) {
        var dts = {
            function: "eliminaPerimetros",
            id_perimetro: id_perimetro
        };
        var confirm = window.confirm("¿Estas seguro que deseas eliminar el dato?");
        if (confirm) {
            jsonAjax("_server.php", dts, (r) => {
                if (!r.ok) {
                    alert(r.msg);
                } else {
                    Cargar("./InformacionCliente.php?id_usuario=" + id_usuario, "cuerpoLogin");
                }
            });
        }
    }

    function guardarCantidadDatos(el, id_usuario) {
        localStorage.setItem("CNNutritionCantidadDatos", el.value);
        Cargar("./InformacionCliente.php?id_usuario=" + id_usuario + "&cantidad=" + el.value, "cuerpoLogin");
    }

    /*
    function guardarPlieguesCutaneos(id_usuario) {
        var fecha = eur2iso(get("inPlfFcha"));
        var tricipital = get("inTricipital");
        var subescapular = get("inSubescapular");
        var supraliaco = get("inSupraliaco");
        var abdominal = get("inAbdominal");
        var muslo = get("inMuslo");
        var gemelo = get("inGemelo");
        if (!fecha) return alert("El campo fecha es obligatorio");
        if (!tricipital) return alert("El campo tricipital es obligatorio");
        if (!subescapular) return alert("El campo subescapular es obligatorio");
        if (!supraliaco) return alert("El campo supraliaco es obligatorio");
        if (!abdominal) return alert("El campo abdominal es obligatorio");
        if (!muslo) return alert("El campo muslo es obligatorio");
        if (!gemelo) return alert("El campo gemelo es obligatorio");

        var dts = {
            function: "guardarPlieguesCutaneos",
            id_usuario: id_usuario,
            fecha: fecha,
            tricipital: tricipital,
            subescapular: subescapular,
            supraliaco: supraliaco,
            abdominal: abdominal,
            muslo: muslo,
            gemelo: gemelo
        };
        jsonAjax("_server.php", dts, (r) => {
            if (!r.ok) {
                alert(r.msg);
            } else {
                Cargar("./InformacionCliente.php?id_usuario=" + id_usuario, "cuerpoLogin");
            }
        });
    }
    */
</script>
<?php

$u = Usuario::getDatosUsuario($id_usuario);
$tarifa = Usuario::getTarifaUsuario($id_usuario);
?>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width-scale=1">
    <link rel="stylesheet" href="estilos.css">
    <title>&nbsp;</title>
</head>

<body>
    <div class="container marginTop30">
        <h4 class="noJump">Información general</h4>
        <div class="container marginTop10">
            <div class="row">
                <div class="col-md-4 autoMargin centrarTexto">
                    <img src="web_images/profileIco.ico" class="img-fluid" alt="...">
                    <div>
                        <button type="button" class="btn btn-outline-dark" onclick="Cargar('EditarInformacionCliente.php?id_usuario=<?= $id_usuario ?>', 'cuerpoLogin')">Editar informacion</button>
                        <button title="Recargar página" style="border: none; background: none; padding: 10px;" onclick="reload(<?= $id_usuario ?>)">
                            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAAAXNSR0IArs4c6QAAAtNJREFUWEfFl0nIjVEYx3+fUIQFUh9S5qEsfEqIsJKhyBw7Cymrr0wbyrARVopIWQiZSZkWKEMIS/MUykrGLMhw/jpHx+Pe95zvvbfuU7fb+55n+J9nfptoMDU12D5tASDeFmAWMBFoBvoC7YB3wAvgKnDe/4e7zXC8u4FfwDLgXHzpHADimQ9sAoZkeuw+sAXYD7zyQCX6GujXFgADndGDwJhMw5btBjDevPzn0kUemAAcB3qVNF5NLAvAFOAC0MFo+QacBE4D94A3PrbKh7HAbP9rXwA6CUBuvwX0MErkjdXA84RH+jvZHYCSrxIVAtDhTRPzH8AaYHvCcMj2Pgm+QgALgMNGwcoM4yHDVZYpqgpABw9Nqcnt81Ia/blKLAWgsAxHA3ciY0q44RkxDyLTgD0FIGRcjUiN6i/F7tgIrIvOFIpFmbcvzRYDuAxMjjQtBg6V1pwpGAN4DAyO5NR2n2TqKc0WA/gMdIk0dQW+lNacKRgD+OTKTUYDdQMEql400yfpT5+MZ6U4BvDIlOBQQGGpB2lkqwp6e2Ua3QMsgEuAZkCgeibhOECTMdB7oLsFsAFYHzEdARbW4/rALmB5pOsiMNUC0LZzN2JSIxoBPKsRhGaDQtk50rMU2GcBKB8euNpX7AOdAObWCEDtfE6k4y0wyE3WrxaAntX3jxqDq1x5bisJQoNsq5Fd4ZacneGd3Yj0rGTRchFIZbO2gqIUplYPXBUQ6DowybV8jfg/VGkl00JxG+hpLJwC5I2nCctaOuUxLbIxfXCb1CjgZfyy2k4olMrUjkbJd0BAtJIpYbWSiTSGR/pYa23vZOTU0KYD1yz4oqVUII5V8ETK9fZcHVbG5f7/KPVdoHAccAuqGkkZ0n6xpKijpgCEPFEZbQaGZaJQ71D2740TrowHrIySKHyaqa8r9lrBP/pbKi/OuL3iiuuqqp4k5XggqaQWhoYD+A2CanchubdP/QAAAABJRU5ErkJggg==" alt="Botón de imagen" style="width: 32px; height: 32px;">
                        </button>
                    </div>
                    <div class="col">
                        <label for="cantidadDatos" class="form-label text-dark">Cantidad de datos:</label>
                        <input type="number" id="cantidadDatos" onchange="guardarCantidadDatos(this, <?= $id_usuario ?>)" class="text-dark" id="cantidadDatos" style="width: 70px; border-radius: 3px; border: 1px solid black; text-align: right;" value="<?= $cantidad ?>">
                    </div>
                </div>
                <div class="col">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="validationDefault01" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="validationDefault01" value="<?php echo $u->nombre ?>" readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="validationDefault01" class="form-label">Primer apellido</label>
                            <input type="text" class="form-control" id="validationDefault01" value="<?php echo $u->apellido1 ?>" readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="validationDefault01" class="form-label">Segundo apellido</label>
                            <input type="text" class="form-control" id="validationDefault01" value="<?php echo $u->apellido2 ?>" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="validationDefault01" class="form-label">Correo</label>
                            <input type="text" class="form-control" id="validationDefault01" value="<?php echo $u->email ?>" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="validationDefault01" class="form-label">Móvil</label>
                            <input type="text" class="form-control" id="validationDefault01" value="<?php echo $u->movil ?>" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="validationDefault04" class="form-label">Sexo</label>
                            <input type="text" class="form-control" id="validationDefault01" value="<?php echo $u->sexo ?>" readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="validationDefault05" class="form-label">Altura (m)</label>
                            <input type="number" step="0.01" value="<?php echo $u->altura ?>" class="form-control" id="validationDefault05" readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="validationDefault04" class="form-label">Plan dietético</label>
                            <input type="text" class="form-control" id="validationDefault01" value="<?php echo $tarifa ?>" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="floatingTextarea2">Patologías/Intoleráncias</label>
                            <textarea class="form-control" id="floatingTextarea2" style="height: 100px" readonly value="<?php echo $u->patologias ?>"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="floatingTextarea2">Grupos de alimentos con aversión </label>
                            <textarea class="form-control" id="floatingTextarea2" style="height: 100px" readonly value="<?php echo $u->aversiones ?>"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="hrPer">
            <h4 class="noJump">Datos generales</h4>
            <div class="container">
                <div class="marginTop20">
                    <form class="row g-3 needs-validation" novalidate>
                        <div class="col-md-3">
                            <label for="validationCustom01" class="form-label"><b>Fecha</b></label>
                            <input id="fechaDG" type="text" class="form-control" id="validationCustom01" value="<?= date("d/m/Y") ?>" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="validationCustom01" class="form-label"><b>Peso</b></label>
                            <input id="pesoDG" type="number" class="form-control" id="validationCustom01" placeholder="55" required>
                        </div>
                        <div class="col-md-3">
                            <label for="validationCustom02" class="form-label"><b>% Grasa</b></label>
                            <input id="grasaDG" type="number" step="0.01" class="form-control" id="validationCustom02" placeholder="10" required>
                        </div>
                        <div class="col-md-3">
                            <label for="validationCustom02" class="form-label"><b>% Musculo</b></label>
                            <input id="musculoDG" type="number" step="0.01" class="form-control" id="validationCustom02" placeholder="10" required>
                        </div>

                        <div class="col-12">
                            <button type="button" class="btn btn-outline-dark" onclick="guardarDatosGeneralesJS(<?= $id_usuario ?>)">Guardar</button>
                        </div>
                    </form>
                </div>
                <div id="datosNutricionalesGenerales" class="scroll">
                    <table id="TablaDatosGenerales" class='table table-striped marginTop20'>
                        <thead>
                            <tr>
                                <th scope='col'>Fecha</th>
                                <th scope='col'>Peso (kg) </th>
                                <th scope='col'>% Grasa</th>
                                <th scope='col'>% Musculo</th>
                            </tr>
                        </thead>
                        <tbody class='overflow-auto'>
                            <?php
                            $dg = Usuario::getDatosNutricionalesGenerales($id_usuario, $cantidad);
                            foreach ($dg as $d) {
                            ?>
                                <tr>
                                    <th scope='row'><?php echo $d->fecha ?></th>
                                    <td><?php echo $d->peso ?></td>
                                    <td><?php echo $d->grasaAVG ?></td>
                                    <td><?php echo $d->musculoAVG ?></td>
                                    <td><button type='button' class='btn btn-outline-danger' onclick='eliminarDatosNutricionalesGenerales(<?php echo $d->id ?>, <?= $id_usuario ?>)'>Eliminar</button></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <script>
                pintarGraficaDG()
            </script>
            <div id="chartContainerDG" style="height: 370px; width: 100%;"></div>
            <hr class="hrPer">
            <h4 class="noJump">Pliegues cutáneos</h4>
            <div class="container">
                <div class="marginTop20">
                    <form class="row g-3 needs-validation" novalidate>
                        <div class="col-md-3">
                            <label for="inPlfFcha" class="form-label"><b>Fecha</b></label>
                            <input type="text" class="form-control" id="inPlfFcha" value="<?php echo date("d/m/Y") ?>" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="inPlTricipital" class="form-label"><b>Tricipital 35</b></label>
                            <input type="number" class="form-control" id="inPlTricipital" placeholder="18.80" required>
                        </div>
                        <div class="col-md-3">
                            <label for="inPlSubescapular" class="form-label"><b>Subescapular</b></label>
                            <input type="number" step="0.01" class="form-control" id="inPlSubescapular" placeholder="17.50" required>
                        </div>
                        <div class="col-md-3">
                            <label for="inPlSupraliaco" class="form-label"><b>Supralíaco</b></label>
                            <input type="number" step="0.01" class="form-control" id="inPlSupraliaco" placeholder="18.30" required>
                        </div>
                        <div class="col-md-4">
                            <label for="inPlAbdominal" class="form-label"><b>Abdominal</b></label>
                            <input type="number" class="form-control" id="inPlAbdominal" placeholder="24.30" required>
                        </div>
                        <div class="col-md-4">
                            <label for="inPlMusloAnterior" class="form-label"><b>Muslo anterior 38</b></label>
                            <input type="number" step="0.01" class="form-control" id="inPlMusloAnterior" placeholder="27.30" required>
                        </div>
                        <div class="col-md-4">
                            <label for="inPlGemelo" class="form-label"><b>Gemelo</b></label>
                            <input type="number" step="0.01" class="form-control" id="inPlGemelo" placeholder="13.70" required>
                        </div>

                        <div class="col-12">
                            <button type="button" class="btn btn-outline-dark" onclick="guardarPlieguesCutaneos(<?php echo $id_usuario ?>)">Guardar</button>
                        </div>
                    </form>
                </div>
                <div class="scroll">
                    <table id='TablaPlieguesCutaneos' class="table table-striped marginTop20">
                        <thead>
                            <tr>
                                <th scope="col">Fecha</th>
                                <th scope="col">Tricipital 35</th>
                                <th scope="col">Subescapular</th>
                                <th scope="col">Supralíaco</th>
                                <th scope="col">Abdominal</th>
                                <th scope="col">Muslo anterior 38</th>
                                <th scope="col">Gemelo</th>
                            </tr>
                        </thead>
                        <tbody class="overflow-auto">
                            <?php
                            $dpc = Usuario::getPlieguesCutaneos($id_usuario, $cantidad);
                            foreach ($dpc as $d) {
                            ?>
                                <tr>
                                    <th scope="row"><?php echo $d->fecha ?></th>
                                    <td><?php echo $d->tricipital35 ?></td>
                                    <td><?php echo $d->subescapular ?></td>
                                    <td><?php echo $d->supraliaco ?></td>
                                    <td><?php echo $d->abdominal ?></td>
                                    <td><?php echo $d->musloAnterior ?></td>
                                    <td><?php echo $d->gemelo ?></td>
                                    <td><button type="button" class="btn btn-outline-danger" onclick="eliminarPlieguesCutaneos(<?= $d->id ?>, <?= $id_usuario ?>)">Eliminar</button></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <hr class="hrPer">
            <script>
                pintarGraficaPC()
            </script>
            <div id="chartContainerPC" style="height: 370px; width: 100%;"></div>
            <h4 class="noJump">Perímetros</h4>
            <div class="container">
                <div class="marginTop20">
                    <form class="row g-3 needs-validation" novalidate>
                        <div class="col-md-3">
                            <label for="validationCustom01" class="form-label"><b>Fecha</b></label>
                            <input type="text" class="form-control" id="validationCustom01" value="<?= date("d/m/Y") ?>" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="inPCinturaSuperiorAbdominal" class="form-label"><b>Cintura superior abdominal</b></label>
                            <input type="number" class="form-control" id="inPCinturaSuperiorAbdominal" placeholder="92.27" required>
                        </div>
                        <div class="col-md-3">
                            <label for="inPAbdominal" class="form-label"><b>Abdominal</b></label>
                            <input type="number" step="0.01" class="form-control" id="inPAbdominal" placeholder="86.95" required>
                        </div>
                        <div class="col-md-3">
                            <label for="inPCadera" class="form-label"><b>Cadera</b></label>
                            <input type="number" step="0.01" class="form-control" id="inPCadera" placeholder="101.67" required>
                        </div>
                        <div class="col-md-3">
                            <label for="inPMuslo" class="form-label"><b>Muslo</b></label>
                            <input type="number" class="form-control" id="inPMuslo" placeholder="56.5" required>
                        </div>
                        <div class="col-md-3">
                            <label for="inPGemelo" class="form-label"><b>Gemelo</b></label>
                            <input type="number" step="0.01" class="form-control" id="inPGemelo" placeholder="36.15" required>
                        </div>
                        <div class="col-md-3">
                            <label for="inPBrazoContraido" class="form-label"><b>Brazo contraído</b></label>
                            <input type="number" step="0.01" class="form-control" id="inPBrazoContraido" placeholder="9.40" required>
                        </div>
                        <div class="col-md-3">
                            <label for="inPBrazoRelajado" class="form-label"><b>Brazo relajado</b></label>
                            <input type="number" step="0.01" class="form-control" id="inPBrazoRelajado" placeholder="19.30" required>
                        </div>
                        <div class="col-12">
                            <button type="button" class="btn btn-outline-dark" onclick="guardaPerimetros(<?= $id_usuario ?>)">Guardar</button>
                        </div>
                    </form>
                </div>
                <div class="scroll">
                    <table id="TablaPerimetros" class="table table-striped marginTop20">
                        <thead>
                            <tr>
                                <th scope="col">Fecha</th>
                                <th scope="col">Cintura superior abdominal</th>
                                <th scope="col">Abdominal</th>
                                <th scope="col">Cadera</th>
                                <th scope="col">Muslo</th>
                                <th scope="col">Gemelo</th>
                                <th scope="col">Brazo contraído</th>
                                <th scope="col">Brazo relajado</th>
                            </tr>
                        </thead>
                        <tbody class="overflow-auto">
                            <?php
                            $dp = Usuario::getPerimetros($id_usuario, $cantidad);
                            foreach ($dp as $d) {
                            ?>
                                <tr>
                                    <th scope="row"><?php echo $d->fecha ?></th>
                                    <td><?php echo $d->cinturaSuperiorAbdominal ?></td>
                                    <td><?php echo $d->abdominal ?></td>
                                    <td><?php echo $d->cadera ?></td>
                                    <td><?php echo $d->muslo ?></td>
                                    <td><?php echo $d->gemelo ?></td>
                                    <td><?php echo $d->brazoContraido ?></td>
                                    <td><?php echo $d->brazoRelajado ?></td>
                                    <td><button type="button" class="btn btn-outline-danger" onclick="eliminaPerimetros(<?= $d->id ?>, <?= $id_usuario ?>)">Eliminar</button></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <script>
                pintarGraficaP()
            </script>
            <div id="chartContainerP" style="height: 370px; width: 100%;"></div>
            <hr class="hrPer">
        </div>
    </div>
</body>

</html>