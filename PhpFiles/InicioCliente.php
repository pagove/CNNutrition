<?php
include_once("clases.php");


$max_lines = 10;
$id_usuario = $_REQUEST["id_usuario"];
Logger::dev_log("ENTRA INICIO CLIENTE", $id_usuario);
$du = Usuario::getDatosUsuario($id_usuario);
Logger::haz_log("DATOS_USUARIO", var_export($du, true));
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
                </div>
                <div class="col">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="validationDefault01" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="validationDefault01" value="<?= $du->nombre ?>" readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="validationDefault02" class="form-label">Primer apellido</label>
                            <input type="text" class="form-control" id="validationDefault02" value="<?= $du->apellido1 ?>" readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="validationDefault03" class="form-label">Segundo apellido</label>
                            <input type="text" class="form-control" id="validationDefault03" value="<?= $du->apellido2 ?>" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="validationDefault04" class="form-label">Correo</label>
                            <input type="text" class="form-control" id="validationDefault04" value="<?= $du->email ?>" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="validationDefault05" class="form-label">Móvil</label>
                            <input type="text" class="form-control" id="validationDefault05" value="<?= $du->movil ?>" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="validationDefault06" class="form-label">Sexo</label>
                            <input type="text" class="form-control" id="validationDefault06" value="<?= $du->sexo ?>" readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="validationDefault07" class="form-label">Altura (m)</label>
                            <input type="number" step="0.01" value="<?= $du->altura ?>" class="form-control" id="validationDefault07" readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="validationDefault08" class="form-label">Plan dietético</label>
                            <?php
                            $tarifa = Tarifa::getTarifas($du->id_tarifa);
                            $nombre_tarifa = $tarifa[0]->titulo;
                            ?>
                            <input type="text" class="form-control" id="validationDefault08" value="<?= $nombre_tarifa ?>" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="floatingTextarea2">Patologías/Intoleráncias</label>
                            <textarea class="form-control" id="floatingTextarea2" style="height: 100px" readonly value=""></textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="floatingTextarea2">Grupos de alimentos con aversión </label>
                            <textarea class="form-control" id="floatingTextarea2" style="height: 100px" readonly value=""></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="hrPer">
            <h4 class="noJump">Datos generales</h4>
            <div class="container">
                <?php
                $datos_generales = Usuario::getDatosNutricionalesGenerales($id_usuario, $max_lines);
                if (!$datos_generales) {
                ?>
                    <br><br>
                <?php
                } else {
                ?>
                    <table class="table table-striped marginTop20" id="TablaDatosGenerales">
                        <thead>
                            <tr>
                                <th scope="col">Fecha</th>
                                <th scope="col">Peso (kg) </th>
                                <th scope="col">% Grasa</th>
                                <th scope="col">% Musculo</th>
                            </tr>
                        </thead>
                        <tbody class="overflow-auto">
                            <?php
                            foreach ($datos_generales as $dg) {
                            ?>
                                <tr>
                                    <th scope="row"><?= $dg->fecha ?></th>
                                    <td><?= $dg->peso ?></td>
                                    <td><?= $dg->grasaAVG ?></td>
                                    <td><?= $dg->musculoAVG ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                <?php
                }
                ?>
            </div>
            <script>
                pintarGraficaDG()
            </script>
            <div id="chartContainerDG" style="height: 370px; width: 100%;"></div>
            <hr class="hrPer">
            <h4 class="noJump">Pliegues cutáneos</h4>
            <div class="container">
                <?php
                $pliegues = Usuario::getPlieguesCutaneos($id_usuario, $max_lines);
                if (!$pliegues) {
                ?>
                    <br><br>
                <?php
                } else {
                ?>
                    <table id="TablaPlieguesCutaneos" class="table table-striped marginTop20">
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
                            foreach ($pliegues as $p) {
                            ?>
                                <tr>
                                    <th scope="row"><?= $p->fecha ?></th>
                                    <td><?= $p->tricipital35 ?></td>
                                    <td><?= $p->subescapular ?></td>
                                    <td><?= $p->supraliaco ?></td>
                                    <td><?= $p->abdominal ?></td>
                                    <td><?= $p->musloAnterior ?></td>
                                    <td><?= $p->gemelo ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                <?php
                }
                ?>
            </div>
            <script>
                pintarGraficaPC()
            </script>
            <div id="chartContainerPC" style="height: 370px; width: 100%;"></div>
            <hr class="hrPer">
            <h4 class="noJump">Perímetros</h4>
            <?php
            $perimetros = Usuario::getPerimetros($id_usuario, $max_lines);
            if (!$perimetros) {
            ?>
                <br><br>
            <?php
            } else {
            ?>
                <div class="container">
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
                            foreach ($perimetros as $p) {
                            ?>
                                <tr>
                                    <th scope="row"><?= $p->fecha ?></th>
                                    <td><?= $p->cinturaSuperiorAbdominal ?></td>
                                    <td><?= $p->abdominal ?></td>
                                    <td><?= $p->cadera ?></td>
                                    <td><?= $p->muslo ?></td>
                                    <td><?= $p->gemelo ?></td>
                                    <td><?= $p->brazoContraido ?></td>
                                    <td><?= $p->brazoRelajado ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                <?php
            }
                ?>
                </div>
                <hr class="hrPer">
                <script>
                    pintarGraficaP()
                </script>
                <div id="chartContainerP" style="height: 370px; width: 100%;"></div>
        </div>
    </div>
</body>

</html>