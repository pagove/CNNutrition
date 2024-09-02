<?php
include_once("Clases/Logger.php");
include_once("Modulos/Usuario.php");
$id_usuario = $_GET["id_usuario"];
?>
<script>
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
                    Cargar("./InformacionCliente.php?id_usuario=" + id_usuario, "cuerpo");
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
                    Cargar("./InformacionCliente.php?id_usuario=" + id_usuario, "cuerpo");
                } else {
                    alert("No se ha podido eliminar la información " + r.msg);
                }
            });
        }

    }
</script>
<?php

$u = Usuario::getDatosGenerales($id_usuario);
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
                    <button type="button" class="btn btn-outline-dark marginTop20" onclick="Cargar('NuevoCliente.html', 'cuerpo')">Editar informacion</button>
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
                            <input id="fechaDG" type="text" class="form-control" id="validationCustom01" value="<?php echo date("d/m/Y") ?>" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="validationCustom01" class="form-label"><b>Peso</b></label>
                            <input id="pesoDG" type="number" class="form-control" id="validationCustom01" value="55" required>
                        </div>
                        <div class="col-md-3">
                            <label for="validationCustom02" class="form-label"><b>% Grasa</b></label>
                            <input id="grasaDG" type="number" step="0.01" class="form-control" id="validationCustom02" value="10" required>
                        </div>
                        <div class="col-md-3">
                            <label for="validationCustom02" class="form-label"><b>% Musculo</b></label>
                            <input id="musculoDG" type="number" step="0.01" class="form-control" id="validationCustom02" value="10" required>
                        </div>

                        <div class="col-12">
                            <button type="button" class="btn btn-outline-dark" onclick="guardarDatosGeneralesJS(<?php echo $id_usuario ?>)">Guardar</button>
                        </div>
                    </form>
                </div>
                <div id="datosNutricionalesGenerales" class="scroll">
                    <table class='table table-striped marginTop20'>
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
                            $dg = Usuario::getDatosNutricionalesGenerales($id_usuario);
                            foreach ($dg as $d) {
                            ?>
                                <tr>
                                    <th scope='row'><?php echo $d->fecha ?></th>
                                    <td><?php echo $d->peso ?></td>
                                    <td><?php echo $d->grasaAVG ?></td>
                                    <td><?php echo $d->musculoAVG ?></td>
                                    <td><button type='button' class='btn btn-outline-dark' onclick='eliminarDatosNutricionalesGenerales(<?php echo $d->id ?>, <?= $id_usuario ?>)'>Eliminar</button></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <hr class="hrPer">
            <h4 class="noJump">Pliegues cutáneos</h4>
            <div class="container">
                <div class="marginTop20">
                    <form class="row g-3 needs-validation" novalidate>
                        <div class="col-md-3">
                            <label for="validationCustom01" class="form-label"><b>Fecha</b></label>
                            <input type="text" class="form-control" id="validationCustom01" value="19/03/2022" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="validationCustom01" class="form-label"><b>Tricipital 35</b></label>
                            <input type="number" class="form-control" id="validationCustom01" value="55" required>
                        </div>
                        <div class="col-md-3">
                            <label for="validationCustom02" class="form-label"><b>Subescapular</b></label>
                            <input type="number" step="0.01" class="form-control" id="validationCustom02" value="11.50" required>
                        </div>
                        <div class="col-md-3">
                            <label for="validationCustom02" class="form-label"><b>Supralíaco</b></label>
                            <input type="number" step="0.01" class="form-control" id="validationCustom02" value="Otto" required>
                        </div>
                        <div class="col-md-4">
                            <label for="validationCustom01" class="form-label"><b>Abdominal</b></label>
                            <input type="number" class="form-control" id="validationCustom01" value="55" required>
                        </div>
                        <div class="col-md-4">
                            <label for="validationCustom02" class="form-label"><b>Muslo anterior 38</b></label>
                            <input type="number" step="0.01" class="form-control" id="validationCustom02" value="11.50" required>
                        </div>
                        <div class="col-md-4">
                            <label for="validationCustom02" class="form-label"><b>Gemelo</b></label>
                            <input type="number" step="0.01" class="form-control" id="validationCustom02" value="Otto" required>
                        </div>

                        <div class="col-12">
                            <button type="button" class="btn btn-outline-dark">Guardar</button>
                        </div>
                    </form>
                </div>
                <div class="scroll">
                    <table class="table table-striped marginTop20">
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
                            $dpc = Usuario::getPlieguesCutaneos($id_usuario);
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
                                    <td><button type="button" class="btn btn-outline-dark">Eliminar</button></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <hr class="hrPer">
            <h4 class="noJump">Perímetros</h4>
            <div class="container">
                <div class="marginTop20">
                    <form class="row g-3 needs-validation" novalidate>
                        <div class="col-md-3">
                            <label for="validationCustom01" class="form-label"><b>Fecha</b></label>
                            <input type="text" class="form-control" id="validationCustom01" value="19/03/2022" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="validationCustom01" class="form-label"><b>Cintura superior abdominal</b></label>
                            <input type="number" class="form-control" id="validationCustom01" value="55" required>
                        </div>
                        <div class="col-md-3">
                            <label for="validationCustom02" class="form-label"><b>Abdominal</b></label>
                            <input type="number" step="0.01" class="form-control" id="validationCustom02" value="11.50" required>
                        </div>
                        <div class="col-md-3">
                            <label for="validationCustom02" class="form-label"><b>Cadera</b></label>
                            <input type="number" step="0.01" class="form-control" id="validationCustom02" value="Otto" required>
                        </div>
                        <div class="col-md-3">
                            <label for="validationCustom01" class="form-label"><b>Muslo</b></label>
                            <input type="number" class="form-control" id="validationCustom01" value="55" required>
                        </div>
                        <div class="col-md-3">
                            <label for="validationCustom02" class="form-label"><b>Gemelo</b></label>
                            <input type="number" step="0.01" class="form-control" id="validationCustom02" value="11.50" required>
                        </div>
                        <div class="col-md-3">
                            <label for="validationCustom02" class="form-label"><b>Brazo contraído</b></label>
                            <input type="number" step="0.01" class="form-control" id="validationCustom02" value="Otto" required>
                        </div>
                        <div class="col-md-3">
                            <label for="validationCustom02" class="form-label"><b>Brazo relajado</b></label>
                            <input type="number" step="0.01" class="form-control" id="validationCustom02" value="Otto" required>
                        </div>
                        <div class="col-12">
                            <button type="button" class="btn btn-outline-dark">Guardar</button>
                        </div>
                    </form>
                </div>
                <div class="scroll">
                    <table class="table table-striped marginTop20">
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
                            $dp = Usuario::getPerimetros($id_usuario);
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
                                    <td><button type="button" class="btn btn-outline-dark">Eliminar</button></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <hr class="hrPer">

            <!--graficas aqui -->

        </div>
    </div>
</body>

</html>